<?php
/**
 * ApiAuthorizeModel.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 10:55 上午
 */


namespace Models;

use LGCommon\data_data\lyx_api_authorize_data;
use LGCore\base\LG;

class ApiAuthorizeModel
{
    /**
     * @var lyx_api_authorize_data
     */
    private $apiAuthorizeObj;
    public function __construct()
    {
        $this->apiAuthorizeObj = new lyx_api_authorize_data();
    }

    public function apiAuthorizeList(array $where,$fields="*",int $page=0,int $limit=10,array $orderby){
        $rlt = $this->apiAuthorizeObj->select_muti_num_and_rows($where,$fields,$page,$limit,$orderby);
        return $rlt;
    }

    /**
     *
     * 添加/更新数据
     * @param array $row_rec
     * @date 2020/6/11 1:12 下午
     * @return array|string[]
     * @author goen<goen88@163.com>
     */
    public function saveOne(array $row_rec){
        try{
            if(isset($row_rec['id'])&&(int)$row_rec['id']>0){
                $id=(int)$row_rec['id'];
                unset($row_rec['id']);
                $rlt = $this->apiAuthorizeObj->update_a_row_by_id($row_rec,$id);

                //如果权限修改，则删除对应的缓存
                $_apiAuth = $this->getOne($id);
                if(isset($_apiAuth['access_key'])){
                    $rdsAKKey = "lyx_urls_ak_".$_apiAuth['access_key'];
                    LG::$redis->del($rdsAKKey);
                }

                return ['count'=>$rlt];
            }else{
                //自动生成uuid
                $uuid = md5(uniqid().microtime());
                //生成access key
                $access_key = substr(md5("lyx_xb_ak_".uniqid().microtime()), 8, 24);
                //secret key
                $secret_key = sha1("lyx_xb_sk_".uniqid().microtime());
                $row_rec['uuid']= $uuid;
                $row_rec['access_key']= $access_key;
                $row_rec['secret_key']= $secret_key;
                $id = $this->apiAuthorizeObj->insert_a_row($row_rec);
                if($id>0){
                    $row_rec['id'] = $id;
                    return  $row_rec;
                }else{
                    return ['error_code'=>'10040','error'=>'新增数据失败'];
                }
            }
        }catch (\Exception $e){
            return ['error_code'=>'10040','error'=>'保存数据异常'];
        }

    }

    /**
     *
     * 通过ID获取信息
     * @param int $id
     * @date 2020/6/15 8:36 上午
     * @return array|\LGCore\db\mysqli\MysqliDb|null
     * @author goen<goen88@163.com>
     */
    public function getOne(int $id){
        return $this->apiAuthorizeObj->select_row_by_id($id);
    }

    /**
     *
     * 通过access key完成查询授权信息
     *
     * @date 2020/6/16 12:52 下午
     * @author goen<goen88@163.com>
     */
    public function getOneByAccessKey(string $ak,$fileds="*"){
        return $this->apiAuthorizeObj->select_row_by_access_key($ak,$fileds);
    }

    /**
     * 刷新Secret Key
     *
     * @param int $id
     * @date 2020/6/16 11:32 上午
     * @author goen<goen88@163.com>
     */
    public function refreshSK(int $id){
        $row_rec = [];
        //secret key
        $secret_key = sha1("lyx_xb_sk_".uniqid().microtime());
        $row_rec['secret_key']= $secret_key;
        if($this->apiAuthorizeObj->update_a_row_by_id($row_rec,$id)>0){

            //如果权限修改，则删除对应的缓存
            $_apiAuth = $this->getOne($id);
            if(isset($_apiAuth['access_key'])){
                $rdsAKKey = "lyx_urls_ak_".$_apiAuth['access_key'];
                LG::$redis->del($rdsAKKey);
            }

            return $secret_key;
        }else{
            return false;
        }
    }

    /**
     *
     * 删除ID
     *
     * @param $id
     * @date 2020/6/11 1:43 下午
     * @return int|string
     * @author goen<goen88@163.com>
     */
    public function deleteOne($id){
        return $this->apiAuthorizeObj->delete_a_row_by_id($id);
    }
}