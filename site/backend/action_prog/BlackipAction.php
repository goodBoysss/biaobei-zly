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
 * @since: 2020/6/11 7:14 下午
 */


namespace Controllers;


use Comments\BackendAction;
use LGCore\base\LG;
use Models\BlackipModel;
use Utils\BackendUtils;

class BlackipAction extends BackendAction
{
    /**
     * @var BlackipModel
     */
    private $blackipModel;

    public function __construct($son_action_name = '', $tpl_dir = '')
    {
        parent::__construct($son_action_name, $tpl_dir);

        $this->blackipModel = new BlackipModel();
    }

    public function goAction(){
        $this->smarty->assign("","");
        $this->smarty->display("blackip/black_list.htm");
    }


    public function addAction(){
        if($this->check_post_method()){//添加信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveBlackipInfo" : $this->_saveBlackipInfo(); break;
            }
        }

        $blackipOne = [
            'id'=>0,
            'ip'=>'',
            'state'=>1,
        ];
        $this->smarty->assign("blackipOne",$blackipOne);
        $this->smarty->display("blackip/save.htm");
    }

    public function editAction(){
        if($this->check_post_method()){//编辑信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveBlackipInfo" : $this->_saveBlackipInfo(); break;
            }
        }
        $id = $this->backendParamCheck('id','int','ID',true);
        $blackipOne = [
            'id'=>0,
            'ip'=>'',
            'state'=>1,
        ];
        $rlt = $this->blackipModel->getOne($id);
        if(isset($rlt['items'])){
            $blackipOne = $rlt['items'];
        }
        $this->smarty->assign("blackipOne",$blackipOne);
        $this->smarty->display("blackip/save.htm");
    }


    //**获取异步请求数据(ajax)******************************************************************************

    /**
     *
     * 获取黑名单列表
     *
     * @date 2020/6/11 9:16 下午
     * @author goen<goen88@163.com>
     */
    public function blackipsListAction(){

        $ip = $this->backendParamCheck('search_ip', "string", "IP",false);
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
        if($ip)$where['ip']=$ip;
        if($state)$where['state']=$state;
        $where['orderby']=$orderby;

        $rlt = $this->blackipModel->blackipsList($where);

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

        $rlt = $this->blackipModel->delete(['id'=>$id]);

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

    //**私有方法******************************************************************************
    /**
     *
     * 添加/修改黑名单
     *
     * @date 2020/6/11 9:17 下午
     * @author goen<goen88@163.com>
     */
    private function _saveBlackipInfo(){
        $id = $this->backendParamCheck('id', 'int', "ID",false);
        $ip = $this->backendParamCheck('ip', 'string', "IP",true);
        $state = $this->backendParamCheck('state', 'int', "状态",false);

        $params=array(
            'ip'  =>$ip,
            'state'  => $state,
        );

        if($id>0){//编辑
            $params['id'] =  $id;
        }else{ //添加
            //...
        }

        //保存操作
        $rlt = $this->blackipModel->save($params);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$id>0?'更新黑名单成功':'添加黑名单成功'
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