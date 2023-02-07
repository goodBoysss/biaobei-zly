<?php
/**
 * ShortAddrsModel.php
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
use LGCore\base\LG;
use Utils\ApiUtils;

class ShortAddrsModel
{

    /**
     * 短链接urls对象
     * @var lyx_short_addrs_data
     */
    private $shortAddrsObj;

    /**
     * 短网址基类
     * @var lyx_urls_data
     */
    private $urlsObj;


    public function __construct()
    {
        $this->shortAddrsObj = new lyx_short_addrs_data();
        $this->urlsObj = new lyx_urls_data();
    }

    /**
     *
     * 添加/编辑短网址
     * @param $shortUrl
     * @param int $company_id  企业ID：0 - 表示公共地址域，所有用户共享；  >0 - 表示企业独有
     * @param int $status
     * @param int $id
     * @date 2020/5/19 1:47 PM
     * @author goen<goen88@163.com>
     */
    public function saveUrl($shortUrl,$company_id=0,$status=1,$id=0){
        //修正URL，url没有http(s)开头，会自动加上，默认加上http
        $shortUrl =  ApiUtils::url_modify($shortUrl);

        $urlArr = parse_url($shortUrl);
        $host = $urlArr['host']; //获取域名,例：xbc.tt
        $urlSha1 = sha1($host); //单纯对域名进行sha1

        if($id==0 ){ //编辑的时候不检测URL
          $rlt = $this->shortAddrsObj->select_row_by_sha1($urlSha1);
          if($rlt){
              return ['error_code'=>'10021','error'=>'短网址已存在'];
          }
        }

        //通过短链接地址，检查对应的表是否存在（上线后不进行检测，主要用于测试）
        $urlTabName = $this->checkTableByUrl($shortUrl);
        if($urlTabName==false){ //如果表不存在则创建Table
            $urlTabName = ApiUtils::shortUrlToTabName($shortUrl);
            $rlt = $this->urlsObj->createTable($urlTabName);
            if($rlt==false){
                return ['error_code'=>'10040','error'=>'创建表映射失败'];
            }
        }

        $row_rec = [
              'name' => $urlTabName,
              'sha1' => $urlSha1,
              'short_url' => $shortUrl,
              'company_id' => $company_id,
              'status' => $status
        ];

        if($id>0){
          $this->shortAddrsObj->update_a_row_by_id($row_rec,$id);
        }else{
          $id = $this->shortAddrsObj->insert_a_row($row_rec);
        }
        LG::$redis->del("lyx_shortdomains_list_".$company_id);

        if($id){
            $row_rec['id'] = $id;
            return $row_rec;
        }else{
           return ['error_code'=>'10047','error'=>'短链接添加失败'];
        }
    }


    /**
     *
     * 根据ID查询短网址信息
     *
     * @param $id
     * @date 2020/5/20 4:20 AM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function getOne($id){
        $rlt = $this->shortAddrsObj->select_row_by_id($id,"id,short_url,status,company_id");
        return $rlt;
    }


    /**
     *
     * 通过短链地址检测表是否存在
     *
     * @param $shortUrl
     * @date 2020/5/19 12:56 PM
     * @author goen<goen88@163.com>
     */
    public function checkTableByUrl($shortUrl){
        $urlTabName =  ApiUtils::shortUrlToTabName($shortUrl);
        $chkRlt = $this->urlsObj->checkTable($urlTabName);

        if(isset($chkRlt)&&!empty($chkRlt)){
            return $urlTabName;
        }else{
            return false;
        }
    }
}
