<?php
/**
 * LGAction.php
 * ==============================================
 * Copy right 2014-2019 by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/16
 * @version: v2.0.0
 * @since: 2017/6/16 13:34
 */

namespace LGCore\base;

use LGCore\session\LGDBSession;
use LGCore\templates\smarty\LGSmarty;
use LGCore\utils\LGUtils;

class LGAction{

    /**
     * @var \Smarty
     */
    public $smarty;//smarty模板引擎句柄

    private $smarty_tpl_dir;//smarty模板引擎目录
    private $son_action_name; //子类类名去除后缀的,homeAction->home

    public function __construct($son_action_name='',$tpl_dir=''){
//        echo "get_class->".get_class()."<br>";
//        echo "get_called_class->".get_called_class()."<br>";


        $this->smarty_tpl_dir = $tpl_dir;
        $this->_init();
    }

    private function _init(){
        $this->_getSmarty();
        $this->authenticationCheck($this->son_action_name);
        $this->db_session();
    }



    private function _getSmarty(){
        $smartyObj = new LGSmarty();
        $smartyObj->setTemplateDir($this->smarty_tpl_dir);

        $this->smarty = $smartyObj->getInstance();
    }

    /**
     * 开启数据库session
     * @copyright 2016 by gaorunqiao.ltd
     * @author goen<goen88@163.com>
     * @return null
     */
    protected function db_session(){
        if(LG_SESSION_MODE==1){
            $session = new LGDBSession();
            $session->gc();
        }
    }

    /**
     *
     * 控制器权限认证
     * @param string $action 控制器名称
     * @copyright 2015 by gaorunqiao.ltd
     * @since File available since Version 1.0 2015-12-31
     * @author goen<goen88@163.com>
     * @return null
     */
    protected  function authenticationCheck($action,$acces=array('admin','user','guest')){
        if($action!=''&&LG_AUTHENTICATION==true){
            $auth = new LGAuthentication();
            $row_struct = $auth->get_stuct_info($action);
            if($auth->get_stuct_info($this->controller)){
                LG::authentication($row_struct,$acces);
            }
        }
    }

    /**
     * 校验http参数
     *
     * @param string[参数键值] $key
     * @param string[参数类型:int、float、string、bool、double、date、datetime、array] $type
     * @param string[参数含义] $note
     * @param bool[是否必须，默认必须] $required
     * @copyright 2016 by gaorunqiao.ltd
     * @since File available since Version 1.0 2016-5-5
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public  function paramCheck($key,$type,$note,$required=true,$is_aes=null){
        if($required&&!LG::reqeust()->hasKey($key)){
            return array('error'=>"参数[$note]不存在",'error_code'=>10009);
        }
        if($type != "array"){
            $val = LG::reqeust()->getString($key,$is_aes);
            if($required&&$val==''){
                return array('error'=>"参数[$note]不能为空",'error_code'=>10010);
            }
        }else{
            $val = LG::reqeust()->getArray($key);
            if($required && empty($val)){
                return array('error'=>"参数[$note]不能为空",'error_code'=>10010);
            }
        }
        if(!empty($val)){
            switch ($type){
                case "int" : {
                    if(!is_numeric($val)&&intval($val)==0){
                        return array('error'=>"参数[$note]类型不正确,必须为整型",'error_code'=>10011);
                    }
                    $val = intval($val);
                    break;
                }
                case "float" : {
                    if(!is_numeric($val)&&floatval($val)==0){
                        return array('error'=>"参数[$note]类型不正确,必须为浮型",'error_code'=>10011);
                    }
                    $val = floatval($val);
                    break;
                }
                case "string" : {
                    if(is_string($val)==false){
                        return array('error'=>"参数[$note]类型不正确,必须为字符串",'error_code'=>10011);
                    }
                    $val=html_entity_decode($val);
                    break;
                }
                case "bool" : {
                    if((bool)($val)==false){
                        return array('error'=>"参数[$note]类型不正确,必须为布尔类型",'error_code'=>10011);
                    }
                    $val = (bool)$val;
                    break;
                }
                case "double" : {
                    if(doubleval($val)==0){
                        return array('error'=>"参数[$note]类型不正确,必须为double",'error_code'=>10011);
                    }
                    $val = doubleval($val);
                    break;
                }
                case "date" : {
                    if(!preg_match("/^\d{4}-\d{2}-\d{2}$/s",$val)){
                        return array('error'=>"参数[$note]类型不正确,日期必须为1978-01-01的格式",'error_code'=>10011);
                    }
                    break;
                }
                case "datetime" : {
                    if(!preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s",$val)){
                        return array('error'=>"参数[$note]类型不正确,日期时间必须为1978-01-01 00:00:00的格式",'error_code'=>10011);
                    }
                    break;
                }
                case "array" : {
                    if(is_array($val)==false){
                        return array('error'=>"参数[$note]类型不正确,必须为数组",'error_code'=>10011);
                    }
                    break;
                }
                case "tel" : {
                    if(!LGUtils::is_phone_num($val)){
                        //return array('error'=>"参数[$note]类型不正确,必须为正确手机号",'error_code'=>10011);
                        return array('error'=>"{$note}格式不正确,必须为正确手机号",'error_code'=>10011);
                    }
                    break;
                }
                case "fax" : {
                    if(!LGUtils::is_telephone_num($val)){
                        //return array('error'=>"参数[$note]类型不正确,必须为正确传真或电话",'error_code'=>10011);
                        return array('error'=>"{$note}格式不正确,如：010-88888888",'error_code'=>10011);
                    }
                    break;
                }
                default:;
            }
        }
        return $val;

    }
}

