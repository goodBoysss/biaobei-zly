<?php
/**
 * BlackipAction.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 9:22 上午
 */


namespace Controllers;


use Comments\ApiAction;
use LGCore\base\LG;
use Models\BlackipListModel;

class BlackipAction extends ApiAction
{

    /**
     * @var BlackipListModel
     */
    private $blackipListModel;

    public function __construct()
    {
        parent::__construct();
        $this->blackipListModel = new BlackipListModel();
    }

    /**
     *
     * 获取Black IP列表
     *
     * @date 2020/6/11 9:24 上午
     * @author goen<goen88@163.com>
     */
    public function goAction(){
        $ip = $this->apiParamCheck('ip','string','ip',false);
        $state = $this->apiParamCheck('state','int','状态',false);

        $where = [];
        if($ip!=='') $where['ip'] = $ip;
        if($state!=='') $where['state'] = $state;
        $orderby = ['id'=>'desc'];
        $rlt = $this->blackipListModel->blackipList($where,"*",$this->page,$this->count,$orderby);

        $this->returnSuccess(
            isset($rlt['items'])?$rlt['items']:[],
            isset($rlt['totalCount'])?$rlt['totalCount']:$rlt['totalCount']
        );
    }

    /**
     *
     * 保存修改/IP
     *
     * @date 2020/6/11 9:25 上午
     * @author goen<goen88@163.com>
     */
    public function saveAction(){
        //设置为post请求
        $this->check_post_method();
        $id = $this->apiParamCheck('id','int','ID',false);
        $ip = $this->apiParamCheck('ip','string','IP',false);
        $state = $this->apiParamCheck('state','int','状态',false);

        $row_rec = [];
        if($id!==''&&!empty($id)) $row_rec['id'] = $id;
        if($ip!=='') $row_rec['ip'] = $ip;
        if($state!==''){
            $row_rec['state'] = $state;
        }else{
            $row_rec['state'] = 0;
        }
        if(empty($row_rec)){
            $this->returnError('100012',"保存信息不能为空");
        }
        LG::log()->info(var_export($row_rec,true));
        $rlt = $this->blackipListModel->saveOne($row_rec);

        $this->returnSuccess(['count'=>$rlt],1);
    }

    /**
     *
     * 通过ID获取单个黑名单信息
     *
     * @date 2020/6/15 8:38 上午
     * @author goen<goen88@163.com>
     */
    public function oneAction(){
        $id = $this->apiParamCheck('id','int','ID',true);
        $rlt = $this->blackipListModel->getOne($id);
        $this->returnSuccess($rlt,1);
    }




    /**
     *
     * 删除黑名单
     *
     * @date 2020/6/11 9:27 上午
     * @author goen<goen88@163.com>
     */
    public function deleteAction(){
        $id = $this->apiParamCheck('id','int','ID',true);
        $rlt = $this->blackipListModel->deleteOne($id);
        $this->returnSuccess(['count'=>$rlt],1);
    }

}