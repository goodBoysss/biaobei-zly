<?php
/**
 * UrlsModel.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/5/19
 * @version: v2.0.0
 * @since: 2020/5/19 9:02 AM
 */


namespace Models;


use LGCommon\data_data\lyx_short_addrs_data;
use LGCommon\data_data\lyx_urls_data;
use LGCommon\module\HashIdsModule;
use LGCore\db\redis\LGRedis;
use LGCore\log\LGError;
use Utils\ApiUtils;
use LGCore\base\LG;
use Utils\RedisLockHelper;

class UrlsModel
{

    /**
     * 短链接urls对象
     * @var lyx_urls_data
     */
    private $urlsObj;

    /**
     * @var lyx_short_addrs_data
     */
    private $shortAddrObj;

    /**
     * @var HashIdsModule
     */
    private $hash;

    /**
     * @var RedisLockHelper
     */
    private $lockHelper;


    public function __construct()
    {

        $this->hash = new HashIdsModule();

        $this->urlsObj = new lyx_urls_data();

        $this->shortAddrObj = new lyx_short_addrs_data();

        $this->lockHelper = new RedisLockHelper(LG::$redis);


    }

    /**
     *
     * 获取系统可用的短域名
     * @param int $companyId
     * @date 2020/6/10 1:01 下午
     * @author goen<goen88@163.com>
     */
    public  function getSupportDomains(int $companyId=0){
        $redis  =LG::$redis;
        $shortDomainsCache = $redis->get("lyx_shortdomains_list_".$companyId);
        if(!empty($shortDomainsCache)){
            $data = \json_decode($shortDomainsCache,false);
            return $data;
        }else{
            $where = [
                'company_id'=>$companyId,
                'status'=>1
            ];
            $rlt = $this->shortAddrObj->select_muti_rows($where,"short_url",0,100);
            if(!empty($rlt)){
                $data = [];
                foreach ($rlt as $k=>$surl){
                    $data[] = $surl['short_url'];
                }
                $redis->set("lyx_shortdomains_list_".$companyId,\json_encode($data));
                return $data;
            }else{
                return [];
            }
        }
    }

    /**
     * 生成短链接
     *
     * @param $url 源转义地址
     * @param $domain 短链接地址
     * @param $company_id 企业ID
     * @date 2020/5/19 9:18 AM
     * @author goen<goen88@163.com>
     */
    public function shortenUrl(string $url,string $domain,int $company_id=0){
        if(LG::$redis==null){
            return ["error_code"=>"10005","error"=>"Redis服务连接失败"];
        }

        //修正URL，url没有http(s)开头，会自动加上，默认加上http
        $url =  ApiUtils::url_modify($url);
        //验证domain是否存在，不存在则不处理
        $domain =  !empty($domain) ? ApiUtils::getStandUrl(ApiUtils::url_modify($domain)) : '';

        //当前企业或者系统的支持的短域名
        //$supportUrls = LG::$params['shortUrls'];
        $supportUrls = $this->getSupportDomains($company_id);
        if(empty($supportUrls)){
            return ["error_code"=>"100020","error"=>"生成失败：没有可用的短域名"];
        }

        if ($url) {
            if ( in_array( ApiUtils::getStandUrl($url),$supportUrls) ) { //判断是否已经是短地址
                return ["error_code"=>"100032","error"=>"该地址无法被缩短"];
            } else {
                try{
                    /**
                     * 如果指定了短域名（$domain），则需要和系统支持的短域名进行验证
                     * 如果传了短域名参数且验证通过则使用指定的短域名
                     * 否则使用当前企业或者系统的支持的短域名
                     */
                    //if(!empty($domain)&& !in_array($domain,$supportUrls) ){

                    $domain = !empty($domain)?$this->_checkShortUrlAviable($domain,$supportUrls):'';
                    if($domain===false ){
                        return ["error_code"=>"10010","error"=>"短域名不合法或本系统不支持"];
                    }else if($domain){
                        $baseUrl = $domain;
                    }else{
                        //随机获取短链地址
                        $baseUrl =  $supportUrls[ mt_rand(0,count($supportUrls)-1) ];
                    }

                    //tablename，（线上启用）
                    $urlTabName = ApiUtils::shortUrlToTabName($baseUrl);

                    //根据短域名，自动切换对应的url存放的表
                    $this->urlsObj->setTable($urlTabName);

                    //查询URL是否存在指定的短域名系统中
                    $sha1 = sha1($url);
                    $store = $this->urlsObj->select_row_by_sha1($sha1,"*");
                    if (!$store) {
                        $row_rec = [
                            'sha1'      => $sha1,
                            'url'       => $url,
                            'create_at' => time(),
                            'creator'   => ip2long(ApiUtils::real_remote_addr())
                        ];
                        $id = $this->urlsObj->insert_a_row($row_rec);
                        if(!id){
                            return ["error_code"=>"10047","error"=>"生成数据异常"];
                        }

                        //插入成功对key进行自增操作
                        $redisTabMaxidKey =  $urlTabName.'_maxid';
                        $rdsid = (int)LG::$redis->get($redisTabMaxidKey); //获取当前最大的ID
                        if($rdsid==0){
                            $_id = $this->urlsObj->getMaxId('id');
                            LG::$redis->incrBy($redisTabMaxidKey,$_id);
                        }else{
                            LG::$redis->incrBy($redisTabMaxidKey,1);
                        }
                    } else {
                        $id = $store['id'];
                    }

                    LG::$redis->expire($redisTabMaxidKey,1800);

                    $hash = new HashIdsModule();
                    $urlId = $hash->encode($id);
                    $s_url =  $baseUrl.$urlId;
                    $rlt = [
                        'id' => $id,
                        's_url' => $s_url,
                        'sha1'=>$sha1,
                        'url'=>$url,
                        'timestamp'=>\time()
                    ];
                    return $rlt;
                }catch (\Exception $e){
                    return ["error_code"=>"10034","error"=>"生成短网址服务异常。"];
                }
            }
        }else{
             return ["error_code"=>"100012","error"=>"请输入正确的URL"];
        }
    }


    /**
     *
     * 批量生成短链接
     *
     * @param $raw_url
     * @date 2020/5/26 5:48 PM
     * @author goen<goen88@163.com>
     */
    public function batchShortenUrl($raw_url,$company_id=0,$batchMax=100){
        if(LG::$redis==null){
            return ["error_code"=>"10005","error"=>"Redis服务连接失败"];
        }

        $urlArr =explode("\n",$raw_url);
        $urlsCount = count($urlArr); //当前url的要处理的数量

        if($urlsCount>$batchMax){
            return ["error_code"=>"10032","error"=>"单批次URL数不能超过{$batchMax}条,需要生成{$urlsCount}条"];
        }

        //URL验证
        $errUrls = []; //不合法的URL
        $validUrls = []; //有效的URL
        foreach ($urlArr as $k=>$v){
            if(!empty($v) && !ApiUtils::is_url($v)){
                $errUrls[] = $v;
            }else{
                $v = ApiUtils::url_modify($v);
                $validUrls[sha1($v)] = $v;
            }
        }

        if(count($errUrls)>0){
            return ["error_code"=>"100012","error"=>"不合法的URL：\n".implode("\n",$errUrls)];
        }

        //当前企业或者系统的支持的短域名
        //$supportUrls = LG::$params['shortUrls'];
        $supportUrls = $this->getSupportDomains($company_id);
        if(empty($supportUrls)){
            return ["error_code"=>"100020","error"=>"生成失败：没有可用的短域名"];
        }

        //随机获取短链地址
        $baseUrl =  $supportUrls[ mt_rand(0,count($supportUrls)-1) ];


        //tablename，（线上启用）
        $urlTabName = ApiUtils::shortUrlToTabName($baseUrl);
        //根据短域名，自动切换对应的url存放的表
        $this->urlsObj->setTable($urlTabName);


        //获取可用URL的sha1值
        $validSha1s = array_keys($validUrls);
        $where = [
            'sha1'=>Array( 'IN' => $validSha1s )
        ];

        $rltDatas = []; //请求结果集

        //数据查重处理
        //处理已经获存在的URL，
        //存在的URL，从有效的$validUrls移除，并在请求结果里面直接返回
        $existUrls = $this->urlsObj->select_muti_rows($where,"id,sha1",0,$batchMax);
        foreach ($existUrls as $ev) {
            $_sha1 = $ev['sha1'];
            $_id = $ev['id'];

            $rltDatas[]=[
                's_url'=> $baseUrl.$this->hash->encode($_id),
                'url'=> $validUrls[$_sha1]
            ];
            unset($validUrls[$_sha1]); //从$validUrls移除当前url
        }


        //最终需要插入的数据总数
        $insertCount = count($validUrls);
        //获取当前表的MaxID
        $redisTabMaxidKey =  $urlTabName.'_maxid';
        $redisTabMaxidKeyLock = $urlTabName.'_maxid_lock';

        //加入请求互斥锁,解决并发问题
        //TODO::防止高并发，导致ID重复，这里需要对进行读锁，防止ID累加会重复
        $this->lockHelper->mutexLock($redisTabMaxidKeyLock,2,100);

        $id = (int)LG::$redis->get($redisTabMaxidKey); //获取当前最大的ID
        if($id==0){
            try{
                $id = $this->urlsObj->getMaxId('id')+1;
                LG::$redis->incrBy($redisTabMaxidKey,$id);
            }catch (\Exception $e){
                return ["error_code"=>"10040","error"=>"系统异常：获取或设置唯一标识异常"];
            }
        }
        if($insertCount>0){
            LG::$redis->incrBy($redisTabMaxidKey,$insertCount+1);
        }
        LG::$redis->expire($redisTabMaxidKey,1800);

        $insertDatas = [];
        foreach ($validUrls as $vk=>$vv){
            $row_rec = [
                'id'=> $id,
                'sha1'      => $vk,
                'url'       => $vv,
                'create_at' => time(),
                'creator'   => ip2long(ApiUtils::real_remote_addr())
            ];
            $insertDatas[] = $row_rec;

            $rltDatas[]=[
                's_url'=> $baseUrl.$this->hash->encode($id),
                'url'=> $vv
            ];

            $id++; //id自增
        }

        if(count($insertDatas)>0){
            $rlt = $this->urlsObj->insertMulti($insertDatas,"id,sha1,url,create_at,creator",false);
            if($rlt==false){
                LG::$redis->del($redisTabMaxidKey); //防止发号器重复,删除key，重新生成
                return ["error_code"=>"10040","error"=>"系统异常：生成短链接失败"];
            }
        }

        //执行完成一次,主动释放锁
        $this->lockHelper->cleanLock($redisTabMaxidKeyLock);
        return $rltDatas;
    }


    /**
     *
     * 还原短网址URL
     *
     * string $url
     * @date 2020/5/26 4:05 PM
     * @author goen<goen88@163.com>
     */
    public function expandUrl(string $url){
        //修正URL，url没有http(s)开头，会自动加上，默认加上http
        $url =  ApiUtils::url_modify($url);
        if ($url) {
            try{
                //根据短域名，自动切换对应的url存放的表
                $urlTabName = ApiUtils::shortUrlToTabName($url);
                if(!empty($urlTabName)){
                    $this->urlsObj->setTable($urlTabName);
                    $urlId = ApiUtils::getShortUrlID($url);
                    $hash = new HashIdsModule();
                    $id = $hash->decode($urlId);
                    if(!empty($id)){
                        return $this->urlsObj->select_row_by_id($id);
                    }else{
                        return ["error_code"=>"100012","error"=>"解析失败：未找到网址"];
                    }
                }else{
                    return ["error_code"=>"100012","error"=>"解析失败：短链不合法或不是本站支持的短链地址"];
                }
            }catch (\Exception $e){
                return ["error_code"=>"10034","error"=>"短链接解析异常"];
            }

        }else{
            return ["error_code"=>"100012","error"=>"请输入正确的URL"];
        }
    }




    /**
     * 短域名列表
     * @param array $where
     * @param string $fileds
     * @param int $page
     * @param int $count
     * @param array $orderBy
     * @return array
     * @throws \Exception
     * @author: goen<goen88@163.com>
     * @date: 2020/05/13
     * @version: v1.0.0
     * @since: 2020/05/13 14:11
     */
    public function shortAddrsList(array $where = [], string $fileds = "*", int $page = 1, int $count = 10, array $orderBy = []): array {
        $ret = $this->shortAddrObj->select_muti_num_and_rows($where, $fileds, $page, $count, $orderBy);

        return $ret;
    }



    /**
     *
     * 短网址列表
     * @param string $s_url
     * @param array $where
     * @param string $fileds
     * @param int $page
     * @param int $count
     * @param array $orderBy
     * @date 2020/6/8 12:46 下午
     * @return array
     * @author goen<goen88@163.com>
     */
    public function urlsList(string $s_url,array $where = [], string $fileds = "*", int $page = 1, int $count = 10, array $orderBy = []): array {
        $baseUrl = ApiUtils::url_modify($s_url);
        $table = ApiUtils::shortUrlToTabName($baseUrl);
        $this->urlsObj->setTable($table);
        $ret = $this->urlsObj->select_muti_num_and_rows($where, $fileds, $page, $count, $orderBy);

        foreach ($ret['items'] as &$item) {
            $hash = new HashIdsModule();
            $urlId = $hash->encode($item['id']);
            $s_url =  $baseUrl.$urlId;
            $item['short_url'] =$s_url;
            $item['create_at'] =date('Y-m-d H:i:s', $item['create_at']);
        }

        return $ret;
    }


    /**
     *
     * 根据短链接获取短链接信息
     *
     * @param string $url
     * @date 2020/6/9 8:38 下午
     * @return array|\LGCore\db\mysqli\MysqliDb|string[]|null
     * @author goen<goen88@163.com>
     */
    public function urlOne(string $url){
       $shortAddrModel = new ShortAddrsModel();
       $tableName = $shortAddrModel->checkTableByUrl($url);
       if($tableName){
           $this->urlsObj->setTable($tableName);
           $urlArr = parse_url($url);
           if(isset($urlArr['path'])){
               $hashVal = trim($urlArr['path'],'/');
               $urlId = (int)$this->hash->decode($hashVal);
               if($urlId>0){
                  return  $this->urlsObj->select_row_by_id($urlId);
               }else{
                   return ["error_code"=>"100012","error"=>"短链接不存在"];
               }
           }else{
               return ["error_code"=>"100012","error"=>"无效的短域名"];
           }
       }else{
           return ["error_code"=>"100012","error"=>"无效的短链接"];
       }
    }

    /**
     *
     * 更新短链接的状态
     * @date 2020/6/16 8:19 下午
     * @author goen<goen88@163.com>
     */
    public function changeStatus($url,$status){
        $shortAddrModel = new ShortAddrsModel();
        $tableName = $shortAddrModel->checkTableByUrl($url);
        if($tableName){
            $this->urlsObj->setTable($tableName);
            $urlArr = parse_url($url);
            if(isset($urlArr['path'])){
                $hashVal = trim($urlArr['path'],'/');
                $urlId = (int)$this->hash->decode($hashVal);
                if($urlId>0){
                    return  $this->urlsObj->update_a_row_by_id(['status'=>$status],$urlId);
                }else{
                    return ["error_code"=>"100012","error"=>"短链接不存在"];
                }
            }else{
                return ["error_code"=>"100012","error"=>"无效的短域名"];
            }
        }else{
            return ["error_code"=>"100012","error"=>"无效的短链接"];
        }
    }

    /**
     *
     * 更新短链接访问计数
     * @date 2020/6/28 3:42 下午
     * @author goen<goen88@163.com>
     */
    public function updateHits($url){
        $shortAddrModel = new ShortAddrsModel();
        $tableName = $shortAddrModel->checkTableByUrl($url);
        if($tableName){
            $this->urlsObj->setTable($tableName);
            $urlArr = parse_url($url);
            if(isset($urlArr['path'])){
                $hashVal = trim($urlArr['path'],'/');
                $urlId = (int)$this->hash->decode($hashVal);
                if($urlId>0){
                    return  $this->urlsObj->update_hits_by_id($urlId);
                }else{
                    return ["error_code"=>"100012","error"=>"短链接不存在"];
                }
            }else{
                return ["error_code"=>"100012","error"=>"无效的短域名"];
            }
        }else{
            return ["error_code"=>"100012","error"=>"无效的短链接"];
        }
    }

    /**
     *
     * 检查短网址有效性，是否包含在本系统中
     * @param $domain
     * @param $supportUrls
     * @date 2020/6/19 8:06 下午
     * @return bool
     * @author goen<goen88@163.com>
     */
    private function _checkShortUrlAviable($domain,$supportUrls){
        $urlArr = parse_url($domain);
        if(!isset($urlArr['host'])){
            return false;
        }
        foreach ($supportUrls as $v){
            if( stripos($v,$urlArr['host']) !==false ){
                return $v;
            }
        }

        return false;
    }
}
