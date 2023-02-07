<?php
/**
 * ApiAuthorizeAction.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 7:14 下午
 */


namespace Controllers;


use Comments\BackendAction;
use LGCore\base\LG;
use Models\ApiAuthorizeModel;
use Utils\BackendUtils;

class ApiAuthorizeAction extends BackendAction
{
    /**
     * @var ApiAuthorizeModel
     */
    private $apiAuthorizeModel;

    public function __construct($son_action_name = '', $tpl_dir = '')
    {
        parent::__construct($son_action_name, $tpl_dir);

        $this->apiAuthorizeModel = new ApiAuthorizeModel();
    }

    public function goAction(){
        $this->smarty->assign("","");
        $this->smarty->display("apiauthorize/apiauthorize_list.htm");
    }


    public function addAction(){
        if($this->check_post_method()){//添加信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveBaseInfo" : $this->_saveApiAuthorizeInfo(); break;
            }
        }

        $apiauthorizeOne = [
            'id'=>0,
            'mame'=>'',
            'status'=>1,
            'company_id'=>0,
            'rate_minute'=>0,
            'rate_hour'=>0,
            'rate_day'=>0,
            'rate_month'=>0,
            'batch_num'=>100,
            'access_type'=>1,
            'expire'=>'',
            'white_list'=>'',
        ];
        $this->smarty->assign("apiauthorizeOne",$apiauthorizeOne);
        $this->smarty->display("apiauthorize/save.htm");
    }

    public function editAction(){
        if($this->check_post_method()){//编辑信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveBaseInfo" : $this->_saveApiAuthorizeInfo(); break;
            }
        }
        $id = $this->backendParamCheck('id','int','ID',true);
        $apiauthorizeOne = [
            'id'=>0,
            'mame'=>'',
            'status'=>1,
            'company_id'=>0,
            'rate_minute'=>0,
            'rate_hour'=>0,
            'rate_day'=>0,
            'rate_month'=>0,
            'batch_num'=>100,
            'access_type'=>1,
            'expire'=>'',
            'white_list'=>'',
        ];
        $rlt = $this->apiAuthorizeModel->getOne($id);
        if(isset($rlt['items'])){
            $apiauthorizeOne = $rlt['items'];
        }


        $this->smarty->assign("apiauthorizeOne",$apiauthorizeOne);
        $this->smarty->display("apiauthorize/save.htm");
    }


    //**获取异步请求数据(ajax)******************************************************************************

    /**
     *
     * 获取黑名单列表
     *
     * @date 2020/6/11 9:16 下午
     * @author goen<goen88@163.com>
     */
    public function apiAuthorizeListAction(){

        $name = $this->backendParamCheck('search_name', "string", "IP",false);
        $state = $this->backendParamCheck('search_state', "int", "state",false);
        $page = $this->backendParamCheck('page', "int", "页码",false);
        $count = $this->backendParamCheck('page_size', "int", "显示数量",false);

        if($page<=0) {
            $page =1;
        }
        if($count==0) {
            $_REQUEST['page_size'] = 10;
            $count = 10;
        }
        $orderby = !empty($orderby)?$orderby:"id,desc";
        $where = array();
        if($name)$where['name']=$name;
        if($state)$where['state']=$state;
        $where['orderby']=$orderby;

        $rlt = $this->apiAuthorizeModel->apiAuthorizeList($where);

        $filter['record_count'] = $rlt['num_items'] ? $rlt['num_items'] : 0;
        $filter = BackendUtils::page_and_size($filter);

        $staffLists =  array('filter'=>$filter,'data'=>$rlt['items']?$rlt['items']:[]);
        exit(json_encode($staffLists));
    }

    /**
     *
     * 删除黑名单
     *
     * @date 2020/6/15 10:46 上午
     * @author goen<goen88@163.com>
     */
    public function deleteAction(){
        $id = $this->backendParamCheck('id','int','ID',true);

        $rlt = $this->apiAuthorizeModel->delete(['id'=>$id]);

        if(!array_key_exists('error',$rlt)){
            $data = ['msg'=>'数据删除成功'];
        }else{
             $data = array(
                    'error'=>isset($rlt['error'])?$rlt['error']:'未知错误',
                    'error_code'=>isset($rlt['error_code'])?$rlt['error_code']:'100040'
            );
        }
        echo json_encode($data);
        exit();
    }

    /**
     *
     * 刷新Secret Key
     *
     * @date 2020/6/16 11:38 上午
     * @author goen<goen88@163.com>
     */
    public function refreshSKAction(){
        $id = $this->backendParamCheck('id','int','ID',true);
        $rlt = $this->apiAuthorizeModel->refreshSK(['id'=>$id]);
        if(!array_key_exists('error',$rlt)){
            $data = ['msg'=>'更新成功','sk'=>$rlt['items']];
        }else{
            $data = array(
                'error'=>isset($rlt['error'])?$rlt['error']:'未知错误',
                'error_code'=>isset($rlt['error_code'])?$rlt['error_code']:'100040'
            );
        }
        echo json_encode($data);
        exit();
    }

    //**私有方法******************************************************************************
    /**
     *
     * 添加/修改黑名单
     *
     * @date 2020/6/11 9:17 下午
     * @author goen<goen88@163.com>
     */
    private function _saveApiAuthorizeInfo(){
        $id = $this->backendParamCheck('id', 'int', "ID",false);
        $name = $this->backendParamCheck('name', 'string', "授权名称",true);
        $company_id = $this->backendParamCheck('company_id', 'int', "公司ID",true);
        $rate_minute = $this->backendParamCheck('rate_minute', 'int', "每分钟请求速率",true);
        $rate_hour = $this->backendParamCheck('rate_hour', 'int', "每小时请求速率",true);
        $rate_day = $this->backendParamCheck('rate_day', 'int', "每天请求速率",true);
        $rate_month = $this->backendParamCheck('rate_month', 'int', "每月请求速率",true);
        $batch_num = $this->backendParamCheck('batch_num', 'int', "单次最大生成数",true);
        $access_type = $this->backendParamCheck('access_type', 'int', "请求访问类型",true);
        $status = $this->backendParamCheck('status', 'int', "状态",false);
        $expire = $this->backendParamCheck('expire', 'datetime', "有效期",false);

        //如果是白名单类型，则white_list为必须传值
        if($access_type==2){
            $white_list = $this->backendParamCheck('white_list', 'string', "白名单",true);
        }else{
            $white_list = $this->backendParamCheck('white_list', 'string', "白名单",false);
        }



        $params=array(
            'name'  =>$name,
            'company_id'  => $company_id,
            'rate_minute'  => $rate_minute,
            'rate_hour'  => $rate_hour,
            'rate_day'  => $rate_day,
            'rate_month'  => $rate_month,
            'batch_num'  => $batch_num,
            'access_type'  => $access_type,
            'status'  => (int)$status,
            'expire'  => $expire,
            'white_list'  => $white_list,
        );

        if($id>0){//编辑
            $params['id'] =  $id;
        }else{ //添加
            //...
        }

        //保存操作
        $rlt = $this->apiAuthorizeModel->save($params);
        $rlt = $rlt['items'];
        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$id>0?'更新API授权信息成功':'添加API授权信息成功'
                ,'id'=>$rlt['id']
            );
        }else{
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>is_array($rlt)?$rlt:''
                ,'id'=>0
            );
        }
        exit(json_encode($data));
    }

}