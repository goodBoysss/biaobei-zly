<?php
/**
 * StaffModel.php
 * ==============================================
 * Copy right 2014-2017  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 后台用户model
 * @author: goen<goen88@163.com>
 * @date: 2017/6/19
 * @version: v2.0.0
 * @since: 2017/6/19 18:35
 */
namespace Models;

use LGCommon\data_data\lg_staff_data;
use LGCommon\data_data\lg_staff_group_data;
use LGCommon\data_data\lg_staff_right_menus_data;

class StaffModel{


    /**
     * @var lg_staff_data|null
     */
    private $staffObj = null;

    /**
     * @var lg_staff_group_data|null
     */
    private $staffGruopObj = null;

    public function __construct()
    {


        $this->staffObj = new lg_staff_data();
        $this->staffGruopObj = new lg_staff_group_data();
        //后台权限表
        $this->staffRightMenusObj = new lg_staff_right_menus_data();
    }

    /**
     * @methodName: staffLists
     *
     * 职员列表
     *
     * @param array $where
     * @param string $fileds
     * @param int $offset
     * @param int $count
     * @since File available since Version 1.0 ${DATE}
     * @author goen<goen88@163.com>
     * @return array
     */
    public function staffLists(array $where = array(),
                               string $fileds = "*",
                               int $offset = 0,
                               int $count = 10
                                ) :array {
        $rlt =  $this->staffObj->select_muti_num_and_rows($where,$fileds,$offset,$count);

        return $rlt;
    }


    /**
     * 检查用户名是否存在，并返回用户信息
     *
     * @param string[用户名称] $username
     * @since File available since Version 1.0 2019-5-14
     * @author goen<goen88@163.com>
     * @return array
     */
    public function checkUsername($username){
        $rlt = $this->staffObj->select_a_row_by_username($username);
        return $rlt;
    }


    /**
     *
     * 获取用户组列表
     *
     * @date 2019/5/16
     * @author goen<goen88@163.com>
     * @return array
     */
    public function groupLists(array $where = array(),
                     string $fileds = "*",
                     int $offset = 0,
                     int $count = 10
                    ) :array{

        $rlt = $this->staffGruopObj->select_muti_num_and_rows($where,$fileds,$offset,$count);
        return $rlt;
    }

    /**
     *
     * 保存用户信息
     * @param $params
     * @date 2019/5/29 8:23 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function saveStaffInfo($params) {
        //判断参数
        if(empty($params)){
            return array('error'=>'后台用户基本信息参数值不存在或不能为空','error_code'=>10010);
        }
        if(!is_array($params)){
            return array('error'=>'后台用户基本信息参数不正确，必须为数组','error_code'=>10011);
        }



        if(isset($params['staff_id'])&&!empty($params['staff_id'])) { //更新
            $staff_id = (int)$params['staff_id'];
            unset($params['staff_id']);
            $numRow = $this->staffObj->update_a_row_by_staff_id($params,$staff_id);

            return array('staff_id'=>$staff_id,'updateCount'=>$numRow);
        }else{ //新增

            //判断用户名是否存在
            $usernameList=$this->staffObj->select_muti_rows(array('username'=>$params['username']));
            if($usernameList){
                return array('error'=>'用户名已存在','error_code'=>10030);
            }
            unset($params['staff_id']);

            $staff_id = $this->staffObj->insert_a_row($params);

            if($staff_id){
                return array('staff_id'=>$staff_id);
            }else{
                return array('error'=>'数据异常：添加用户基本信息失败','error_code'=>10040);
            }
        }
    }



    /**
     *
     * 通过用户ID获取组信息
     * @param $group_id
     * @date 2019/5/29 8:54 PM
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public function getStaffById($staff_id){
        $rlt = $this->staffObj->select_a_row_by_staff_id($staff_id);
        return $rlt;
    }


    /**
     *
     * 保存用户组信息
     * @param $params
     * @param $right_id_list
     * @date ${dt}
     * @author goen<goen88@163.com>
     * @return array
     */
    public function saveGroup($params,$right_id_list){
        //判断参数
        if(empty($params)){
            return array('error'=>'后台用户组基本信息参数值不存在或不能为空','error_code'=>10010);
        }
        if(!is_array($params)){
            return array('error'=>'后台用户组基本信息参数不正确，必须为数组','error_code'=>10011);
        }


        if(isset($params['group_id'])&&!empty($params['group_id'])){ //更新
            $group_id = (int)$params['group_id'];
            unset($params['group_id']);

            $numRow = $this->staffGruopObj->update_a_row_by_group_id($params,$group_id);

            return array('group_id'=>$group_id,'updateCount'=>$numRow);
        }else{ //新增

            //判断用户组名是否存在
            $groupNameList=$this->staffGruopObj->select_muti_rows(array('group_name'=>$params['group_name']));
            if($groupNameList){
                return array('error'=>'用户组名已存在','error_code'=>10030);
            }
            unset($params['group_id']);
            $group_id = $this->staffGruopObj->insert_a_row($params);

            if($group_id){
                return array('group_id'=>$group_id);
            }else{
                return array('error'=>'数据异常：添加后台用户组基本信息失败','error_code'=>10040);
            }
        }
    }


    /**
     *
     * 通过用户组ID获取组信息
     * @param $group_id
     * @date ${dt}
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public function getGroupById($group_id){
        $rlt = $this->staffGruopObj->select_row_by_group_id($group_id);
        return $rlt;
    }


    /**
     *
     * 获取分组Options
     *
     * @date 2019/5/29 5:37 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function getGroupOptions(){
        $rlt = $this->staffGruopObj->select_muti_rows(array(),array('group_id','group_name'),0,500);
        return $rlt;
    }


    /**
     *
     * 通过ID删除用户组
     * @param $group_id
     * @date 2019/5/29 10:20 PM
     * @author goen<goen88@163.com>
     * @return array|string
     */
    public function deleteGroupById($group_id){
        //查询当前用户组是否被占用
        $rlt = $this->staffObj->select_muti_rows(array('group_id'=>$group_id),array('group_id'));

        if(is_array($rlt)&&empty($rlt)){
            return array('error'=>'删除失败：此用户组已被使用，无法删除。','error_code'=>10040);
        }

        $count = $this->staffGruopObj->delete_a_row_by_group_id($group_id);
        return $count;
    }


    /**
     *
     * 通过ID删除用户组
     * @param $group_id
     * @date 2019/5/29 10:20 PM
     * @author goen<goen88@163.com>
     * @return array|string
     */
    public function deleteStaffById($stafff_id){
        $currentUid = isset($_SESSION['adm_user']['uid'])?$_SESSION['adm_user']['uid']:0; //获取当前登录用户ID

        if($currentUid==0){
            return array('error'=>'删除失败：没有删除权限，您还未登录。','error_code'=>10040);
        }
        if($currentUid==$stafff_id){
            return array('error'=>'删除失败：不支持的操作（自己不能删除自己）。','error_code'=>10040);
        }
        $count = $this->staffObj->delete_a_row_by_staff_id($stafff_id);
        return $count;
    }


    /**
     *
     * 获取权限菜单
     *
     * @date 2019/5/30 1:52 PM
     * @author goen<goen88@163.com>
     */
    public function staffRightMenus(){
        $orderBy = array(
          'sr_menu_id'=>'asc'
        );
        $rlt = $this->staffRightMenusObj->select_muti_num_and_rows(array(),'*',0,1000,$orderBy);

        return $rlt;
    }


    /**
     * 通过ID权限菜单列表
     *
     * @param $sr_menu_id
     * @date 2019/5/30 5:06 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function getRightMenusById($sr_menu_id){
        $rlt = $this->staffRightMenusObj->select_a_row_by_sr_menu_id($sr_menu_id);
        return $rlt;
    }


    /**
     *
     * 保存权限菜单
     * @param $params
     * @date 2019/5/31 1:05 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function saveRightMenus($params){
        //判断参数
        if(empty($params)){
            return array('error'=>'权限菜单参数值不存在或不能为空','error_code'=>10010);
        }
        if(!is_array($params)){
            return array('error'=>'权限菜单参数不正确，必须为数组','error_code'=>10011);
        }


        if(isset($params['sr_menu_id'])&&!empty($params['sr_menu_id'])){ //更新
            $sr_menu_id = (int)$params['sr_menu_id'];
            unset($params['sr_menu_id']);

            $numRow = $this->staffRightMenusObj->update_a_row_by_right_id($params,$sr_menu_id);

            return array('sr_menu_id'=>$sr_menu_id,'updateCount'=>$numRow);
        }else{ //新增

            //判断用户组名是否存在
            $groupNameList=$this->staffRightMenusObj->select_muti_rows(array('right_name'=>$params['right_name'],'parent_id'=>$params['parent_id']));
            if($groupNameList){
                return array('error'=>'权限菜单名已存在','error_code'=>10030);
            }
            unset($params['sr_menu_id']);
            $sr_menu_id = $this->staffRightMenusObj->insert_a_row($params);

            if($sr_menu_id){
                if($params['level']==1){
                    $right_code=sprintf("%04d", $sr_menu_id);
                    $this->staffRightMenusObj->update_a_row_by_right_id(array('right_code'=>$right_code), $sr_menu_id);
                }elseif($params['level']==3||$params['level']==2){//权限CODE码
                    $rltInfo=$this->staffRightMenusObj->select_a_row_by_sr_menu_id($params['parent_id']);
                    $right_code_1=$rltInfo['right_code'];
                    $right_code_2=sprintf("%04d", $sr_menu_id);
                    $right_code=$right_code_1.$right_code_2;
                    $this->staffRightMenusObj->update_a_row_by_right_id(array('right_code'=>$right_code), $sr_menu_id);
                }
                return array('sr_menu_id'=>$sr_menu_id);
            }else{
                return array('error'=>'数据异常：添加权限菜单失败','error_code'=>10040);
            }

        }
    }

    /**
     *
     * 通过ID删除权限
     * @param $sr_menu_id
     * @date ${dt}
     * @author goen<goen88@163.com>
     */
    public function deleteRightMenuById($sr_menu_id){
        $currentUid = isset($_SESSION['adm_user']['uid'])?$_SESSION['adm_user']['uid']:0; //获取当前登录用户ID

        if($currentUid==0){
            return array('error'=>'删除失败：没有删除权限，您还未登录。','error_code'=>10040);
        }

        $rightSonInfo=$this->staffRightMenusObj->select_a_row_by_parent_id($sr_menu_id);
        if($rightSonInfo){
            return array('error'=>'存在子权限，删除失败','error_code'=>10039);
        }

        $count = $this->staffRightMenusObj->delete_a_row_by_sr_menu_id($sr_menu_id);
        return $count;
    }


    /**
     *
     * 获取权限树
     *
     * @param int $pid
     * @date 2019/6/2 2:05 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function getAuthTrees($pid=0){
        $rlt = $this->staffRightMenusObj->select_muti_rows(array('parent_id'=>$pid),'sr_menu_id,right_name',0,500);
        $data = array();
        if(!empty($rlt)){
            foreach ( $rlt as $item) {
                $_id = $item['sr_menu_id'];
                $sonLists = $this->getAuthTrees($_id);
                $data[] = array(
                    'name'=> $item['right_name']
                    ,'value'=> $_id
                    ,'checked'=>false
                    ,'list'=>!empty($sonLists)?$sonLists:''
                );
            }
        }
        return $data;
    }
}
