<?php
/**
 * backend action基类
 * 
 * @author goen
 *
 */

namespace  Comments;
use LGCore\base\LG;

class WebAction extends \LGCore\base\LGAction {
	
	/**
	 * 检测action是否需要开启登陆验证
	 * @var boolean
	 */
	protected $needLogin = true;
	
	public function __construct($son_action_name='',$tpl_dir=''){
		//检测当前页面是否需要登陆访问
		$this->checkLogin();
		
		parent::__construct($son_action_name,$tpl_dir);
	}
	
	
	public function checkLogin(){
		if($this->needLogin==true){ //已经登陆
			if(isset($_SESSION['web_user']['ifu'])&&$_SESSION['web_user']['ifu']=="1"){

			}else{
				echo "<script>parent.window.location.href='/';</script>";
	    		LG::end();
			}
		}
	}
	
	/**
	 * 校验 http参数
	 * 
	 * @param string[参数键值] $key
	 * @param string[参数类型:int、float、string、bool、double、array] $type
	 * @param string[参数含义] $note
	 * @param bool[是否必须，默认必须] $required
	 * @copyright 2016 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2016-5-5
	 * @author goen<goen88@163.com>
	 * @return mixed
	 */
	public  function webParamCheck($key,$type,$note,$required=true){
		$rlt = $this->paramCheck($key, $type, $note,$required);
		if(is_array($rlt)&&array_key_exists('error', $rlt)) {
			return $rlt;
		}
		if($type!='array'){
		    return htmlspecialchars_decode($rlt,ENT_QUOTES);
		}else{
		    foreach($rlt as $key =>$r){
		        $rlt[$key] = htmlspecialchars_decode($r,ENT_QUOTES);
		    }
		    return $rlt;
		}
	}
	
	
    /**
     * 
     * 检查是否POST请求
     * 
     * @since File available since Version 1.0 2016-1-4
     * @author goen<goen88@163.com>
     * @return null
        */ 
    protected function check_post_method(){
    	if(LG::reqeust()->isPost()){ 
        	return true;
    	}else{
    		return false;
    	}
    }


    /**
     *
     * 获取当前请求的真实地址
     *
     * @date 2020/6/9 8:47 下午
     * @return string
     * @author goen<goen88@163.com>
     */
    protected function getRequestUri(){
        return $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
    }
    
}