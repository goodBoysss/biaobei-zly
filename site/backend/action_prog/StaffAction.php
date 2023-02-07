<?php

/**
 * StaffAction.php * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/5/7
 * @version: v2.0.0
 * @since: 2019/5/7 15:39
 *
 */
namespace Controllers;

use Comments\BackendAction;
use Comments\WebAction;
use Models\StaffModel;
use Utils\BackendUtils;
use LGCore\base\LG;

class StaffAction extends BackendAction
{

    private $staffModel = null;
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();


        $this->staffModel = new StaffModel();
    }

    /**
     * @methodName: goAction
     *
     * Enter description here ...
     *
     * @since File available since Version 1.0 ${DATE}
     * @author goen<goen88@163.com>
     * @return string
     */
    public function goAction() {
//        $staffs = $this->staffModel->staffLists();
//        $this->smarty->assign('staffs',$staffs);

        $this->smarty->display('staff/staff.htm');

    }

    /**
     *
     * 添加/编辑用户
     *
     * @date 2019/5/23 3:57 PM
     * @author goen<goen88@163.com>
     */
    public function staffSaveAction(){
        if($this->check_post_method()){//添加用户信息
            $act = LG::reqeust()->getString('act');
            //var_export($_POST);exit;
            switch ($act){
                case "saveStaffInfo" : $this->_saveStaffInfo(); break;
            }
        }

        $staffId = $this->backendParamCheck('staff_id','int','用户ID',false);
        $groupId = 0;
        if($staffId){
            $staffInfo = $this->staffModel->getStaffById($staffId);
            $groupId = $staffInfo['group_id'];
            $this->smarty->assign('staffInfo',$staffInfo);
        }


        $groupOptions = $this->staffModel->getGroupOptions();
        $staffgroupOptions= BackendUtils::html_option($groupOptions, $groupId, 'group_id', 'group_name');
        $this->smarty->assign('staffgroupOptions',$staffgroupOptions);

        //是否弹层模式
        $is_layer = $this->backendParamCheck('is_layer','int','弹层模式',false);
        $this->smarty->assign('is_layer',$is_layer);

        $this->smarty->display('staff/staff_save.htm');
    }

    public function roleAction(){
        $this->smarty->display('staff/role.htm');
    }

    /**
     * 保存用户组信息
     *
     * @date 2019/5/29 3:11 PM
     * @author goen<goen88@163.com>
     */
    public function roleSaveAction(){
        if($this->check_post_method()){//保存用户组信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveGroupInfo" : $this->_saveGroupInfo(); break;
            }
        }

        $groupId = $this->backendParamCheck('group_id','int','用户组ID',false);
        if($groupId){
            $groupInfo = $this->staffModel->getGroupById($groupId);
            $this->smarty->assign('groupInfo',$groupInfo);
        }



        //是否弹层模式
        $is_layer = $this->backendParamCheck('is_layer','int','弹层模式',false);
        $this->smarty->assign('is_layer',$is_layer);

        $this->smarty->display('staff/role_save.htm');
    }

    public function authCategoryAction(){
        $this->smarty->display('staff/auth_category.htm');
    }

    public function authAction(){
        $this->smarty->display('staff/auth.htm');
    }

    public function authSaveAction(){

        if($this->check_post_method()){//保存权限信息
            $act = LG::reqeust()->getString('act');
            switch ($act){
                case "saveRightMenusInfo" : $this->_saveRightMeunsInfo(); break;
            }
        }

        $sr_menu_id = $this->backendParamCheck('sr_menu_id','int','菜单ID',false);
        if($sr_menu_id){
            $menusInfo = $this->staffModel->getRightMenusById($sr_menu_id);
            $this->smarty->assign('menusInfo',$menusInfo);
        }

        $parent_id = (int)$this->backendParamCheck('parent_id','int','父ID',false);
        $level = (int)$this->backendParamCheck('level','int','层级',false);
        $this->smarty->assign('parent_id',$parent_id);
        $this->smarty->assign('level',$level?$level:1);


        //是否弹层模式
        $is_layer = $this->backendParamCheck('is_layer','int','弹层模式',false);
        $this->smarty->assign('is_layer',$is_layer);

        $this->smarty->display('staff/auth_save.htm');
    }


    //**获取异步请求数据(ajax)******************************************************************************
    /**
     * 获取后台用户列表
     *
     * @since File available since Version 1.0 2019-5-6
     * @author gaorq
     * @return json
     */
    public function staffListAction(){
        $group_id = $this->backendParamCheck('group_id', "int", "用户组ID",false);
        $username = $this->backendParamCheck('username', "string", "用户名",false);
        $truename = $this->backendParamCheck('truename', "string", "真实姓名",false);
        $is_super = $this->backendParamCheck('is_super', "int", "是否是超级用户",false);
        $ifmod = $this->backendParamCheck('ifmod', "int", "是否通过",false);


        $page = $this->backendParamCheck('page', "int", "页码",false);
        $count = $this->backendParamCheck('page_size', "int", "显示数量",false);
        $orderby = $this->backendParamCheck('orderby', "string", "排序",false);

        if($page<=0) {
            $page =1;
        }
        if($count==0) {
            $_REQUEST['page_size'] = 10;
            $count = 10;
        }
        $orderby = !empty($orderby)?$orderby:"staff_id,desc";
        $where = array();

        if($group_id)$where['group_id']=$group_id;
        if($username)$where['username']=$username;
        if($truename)$where['truename']=$truename;

        if($is_super===0||$is_super==1)$where['is_super']=$is_super;
        if($ifmod===0||$ifmod==1)$where['ifmod']=$ifmod;

        $rlt = $this->staffModel->staffLists($where,'*',($page-1)*$count,$count);
        $filter['record_count'] = $rlt['totalCount'] ? $rlt['totalCount'] : 0;
        $filter = BackendUtils::page_and_size($filter);

        $staffLists =  array('filter'=>$filter,'data'=>$rlt['items']);
        exit(json_encode($staffLists));
    }


    /**
     *
     * 获取用户组列表
     *
     * @date 2019/05/16
     * @author goen<goen88@163.com>
     */
    public function groupListAction(){
        $group_name = $this->backendParamCheck('group_name', "string", "用户组名称",false);
        $is_delete = $this->backendParamCheck('is_delete', "int", "是否删除",false);
        $page = $this->backendParamCheck('page', "int", "页码",false);
        $count = $this->backendParamCheck('page_size', "int", "显示数量",false);
        $orderby = $this->backendParamCheck('orderby', "string", "排序",false);
        if($page<=0) {
            $page =1;
        }
        if($count==0) {
            $_REQUEST['page_size'] = 20;
            $count = 20;
        }

        $orderby = !empty($orderby)?$orderby:"group_id,desc";
        $where = array();
        if($group_name) $where['group_name'] = $group_name;
        if($is_delete===0||$is_delete===1) $where['is_delete'] = $is_delete;
        $rlt = $this->staffModel->groupLists($where,'*',($page-1)*$count,$count);
        $filter['record_count'] =  $rlt['totalCount'] ? $rlt['totalCount'] : 0;
        $filter = BackendUtils::page_and_size($filter);

        $groupLists =  array('filter'=>$filter,'data'=>$rlt['items']);
        exit(json_encode($groupLists));
    }


    /**
     *
     * 根据ID删除用户
     *
     * @date 2019/5/29 10:36 PM
     * @author goen<goen88@163.com>
     */
    public function delStaffOneAction(){
        $staff_id = $this->backendParamCheck('staff_id', 'int', '后台用户ID',true);

        $rlt = $this->staffModel->deleteStaffById($staff_id);

        if(is_array($rlt)&&array_key_exists('error',$rlt)){
            $data = $rlt;
        }else{
            $data = array(
                'error'=>''
                ,'delete_count'=>intval($rlt)
            );
        }

        exit(json_encode($data));
    }

    /**
     *
     * 根据ID删除用户组
     *
     * @date 2019/5/29 10:36 PM
     * @author goen<goen88@163.com>
     */
    public function delGroupOneAction(){
        $group_id = $this->backendParamCheck('group_id', 'int', '用户组ID',true);

        $rlt = $this->staffModel->deleteGroupById($group_id);

        if(is_array($rlt)&&array_key_exists('error',$rlt)){
            $data = $rlt;
        }else{
            $data = array(
                'error'=>''
                ,'delete_count'=>intval($rlt)
            );
        }

        exit(json_encode($data));
    }


    /**
     *
     * 权限菜单列表
     *
     * @date 2019/5/30 1:00 PM
     * @author goen<goen88@163.com>
     */
    public function rightMenusAction(){
        $rlt = $this->staffModel->staffRightMenus();
        $data = array(
            'msg'=>'',
            'code'=>0,
            'data'=>$rlt['items'],
            'count'=>(int)$rlt['totalCount'],
            'is'=>true,
            'tip'=>'获取数据成功',
        );
        exit( json_encode($data) );
    }

    /**
     *
     * 删除菜单权限
     *
     * @date 2019/5/31 1:02 PM
     * @author goen<goen88@163.com>
     */
    public function delRightMenusOneAction(){
        $sr_menu_id =(int)$this->backendParamCheck('sr_menu_id', 'int', "ID",true);
        $rlt = $this->staffModel->deleteRightMenuById($sr_menu_id);

        if(is_array($rlt)&&array_key_exists('error',$rlt)){
            $data = $rlt;
        }else{
            $data = array(
                'error'=>''
                ,'delete_count'=>1
            );
        }

        exit(json_encode($data));
    }


    /**
     *
     * 获取权限树菜单
     *
     * @date 2019/6/2 2:09 PM
     * @author goen<goen88@163.com>
     */
    public function authtreesAction(){
        $rlt = $this->staffModel->getAuthTrees(0);
        $data = array(
            'msg'=>'',
            'code'=>0,
            'data'=>array(
                'trees'=>$rlt
            )
        );
        exit( json_encode($data) );
    }

    //**私有方法******************************************************************************
    /**
     * 保存后台用户信息
     *
     * @since File available since Version 1.0 2019-05-28
     * @author gaorq
     * @return json
     */

    private function _saveStaffInfo(){
        $staff_id = $this->backendParamCheck('staff_id', 'int', '后台用户ID',false); //如果任务ID大于0则是编辑信息
        $group_id = $this->backendParamCheck('group_id', 'int', '用户组ID',true);
        $username = $this->backendParamCheck('username', 'string', '用户名',true);
        $truename = $this->backendParamCheck('truename', 'string', '真实姓名',true);
        $is_super = $this->backendParamCheck('is_super', 'int', '是否超级用户',false);
        $password1= $this->backendParamCheck('password1', 'string', '密码1',false);
        $password2= $this->backendParamCheck('password2', 'string', '密码2',false);
        $ifmod    = $this->backendParamCheck('ifmod', 'int', '是否通过',false);

        $arr=array();
//        if ($is_super==0){
//            $right_id_list=array();
//            $arr=$_POST['authids'];
//            foreach($arr as $right_id){
//                $status = $this->backendParamCheck('right_status_'.$right_id,'int','用户组权限ID',false);
//                if($status==1){
//                    $right_id_list[]=(int)$right_id;
//                }
//            }
//            //json用户组权限ID数组
//            $right_id_list=json_encode($right_id_list);
//        }

//        echo '<pre>';
//        var_export($_POST['authids']);
//        exit();

        //后台比对密码
        if($password1!=$password2){
            $data=array(
                'type'  =>'addStaffInfo',
                'error' =>array('密码1'=>$password1,'密码2'=>$password2,),
                'message'=>'两次输入密码不相同',
            );
            exit(json_encode($data));
        }
        $params=array(
            'group_id'  =>$group_id,
            'username'  =>$username,
            'truename'  =>$truename,
            'is_super'  =>$_SESSION['adm_user']['is_super']==1?$is_super:0,
            'ifmod'     =>$ifmod,
        );




        if($staff_id>0){
            //编辑
            if($password1){
                $params['password']=md5($password1);
            }
            //if($right_id_list)$params['right_id_list']=$right_id_list;
            $params['staff_id']=$staff_id;
            $params['edit_time']=date('Y-m-d H:i:s');

        }else {
            //添加
            if($password1){
                $params['password']=md5($password1);
            }else{
                exit(json_encode(array('error'=>'注册密码不能为空')));
            }
            $params['add_time']=date('Y-m-d H:i:s');
            //if($right_id_list)$params['right_id_list']=$right_id_list;
        }

        $rlt = $this->staffModel->saveStaffInfo($params);

        $staff_id = is_array($rlt)&&isset($rlt['staff_id'])?$rlt['staff_id']:0;

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$group_id>0?'更新用户信息成功':'添加用户成功'
                ,'id'=>$staff_id
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


    /**
     *
     * 保存用户组信息
     *
     * @date 2019/5/29 3:13 PM
     * @author goen<goen88@163.com>
     */
    private function _saveGroupInfo(){

        $group_id = $this->backendParamCheck('group_id', 'string', "组ID",false);
        $group_name = $this->backendParamCheck('group_name', 'string', "用户组名称",true);
        $note = $this->backendParamCheck('note', 'string', "备注",false);
        $is_delete = $this->backendParamCheck('is_delete', 'int', "是否删除",false);
        $right_id_list=$this->backendParamCheck('right_id_list', 'string', '权限ID列表',false);

        $params=array(
            'group_name'  =>$group_name,
            'note'  =>$note,
            'is_delete'  =>$is_delete,
        );

        if($group_id>0){//编辑
            $params['group_id'] =  $group_id;
            $params['edit_time'] =  date('Y-m-d H:i:s');
        }else{ //添加
            $params['add_time'] =  date('Y-m-d H:i:s');
        }

        //保存操作
        $rlt = $this->staffModel->saveGroup($params,$right_id_list);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$group_id>0?'更新用户组信息成功':'添加用户组成功'
                ,'id'=>$rlt['group_id']
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

    /**
     *
     * 保存权限信息
     *
     * @date 2019/5/30 5:19 PM
     * @author goen<goen88@163.com>
     */
    private function _saveRightMeunsInfo(){
        $sr_menu_id =(int)$this->backendParamCheck('sr_menu_id', 'int', "ID",false);
        $parent_id  = (int)$this->backendParamCheck('parent_id', 'int', "父ID",true);
        $right_name = $this->backendParamCheck('right_name', 'string', "权限名称",true);
        $state      = (int)$this->backendParamCheck('state', 'int', "状态",true);
        $note       = $this->backendParamCheck('note', 'string', "备注",false);
        $url        = $this->backendParamCheck('url', 'string', "url地址",false);
        $sort_num   = (int)$this->backendParamCheck('sort_num', 'int', "排序值",false);
        $level      = (int)$this->backendParamCheck('level', 'int', "层级",false);
        $params=array(
            'sr_menu_id' =>$sr_menu_id,
            'parent_id' =>$parent_id,
            'right_name'=>$right_name,
            'state'     =>$state,
            'url'       =>$url,
            'sort_num'  =>$sort_num,
            'note'      =>$note,
            'level'      =>$level,
        );
        $rlt = $this->staffModel->saveRightMenus($params);
        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$sr_menu_id>0?'更新权限菜单信息成功':'添加权限菜单成功'
                ,'id'=>$rlt['sr_menu_id']
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