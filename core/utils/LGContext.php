<?php
/**
 * 获取http参数、判断请求类型
 * 
 * @author goen<goen88@163.com>
 */

namespace LGCore\utils;
class LGContext{
	
	/**
	 * 
	 * 判断key是否存在
	 * 
	 * @param string $var
	 * @since File available since Version 1.0 2016-1-4
	 * @author goen<goen88@163.com>
	 * @return bool
	 */
	public static function hasKey($var){
		return isset($_REQUEST[$var])?true:false;
	}
	
	
	public static function getInt($var,$is_aes=null)
	{
		if ($var==''||self::hasKey($var)==false) {
			return '';
		}else{
			$val = $_REQUEST[$var];
			if(!empty($val)&&$is_aes!==null){ //如果采用AES加密，需要参数解密
				if($is_aes===true){
					$aesObj = new LGMCrypt();
					$val = $aesObj->decrypt($val);
				}
			}else if(!empty($val)&&defined('LG_AES_HTTP_PARAMERS_DECODE')&&LG_AES_HTTP_PARAMERS_DECODE==true){ //开启全局解密
				$aesObj = new LGMCrypt();
				$val = $aesObj->decrypt($val);
			}
			return intval($val);
		}
	}
	
	public static function getString($var,$is_aes=null)
	{
		if ($var==''||self::hasKey($var)==false) {
			return '';
		}else{
			//return htmlentities($_REQUEST[$var],ENT_QUOTES,"utf-8");
			$val =  htmlspecialchars($_REQUEST[$var],ENT_QUOTES,"utf-8");
			
			if(!empty($val)&&$is_aes!==null){ //如果采用AES加密，需要参数解密
				if($is_aes===true){
					$aesObj = new LGMCrypt();
					$val = $aesObj->decrypt($val);
				}
			}else if(!empty($val)&&defined('LG_AES_HTTP_PARAMERS_DECODE')&&LG_AES_HTTP_PARAMERS_DECODE==true){ //开启全局解密
				$aesObj = new LGMCrypt();
				$val = $aesObj->decrypt($val);
			}
			return trim(strval($val));
		}
	}
	
	public static function getArray($var){
	if ($var==''||self::hasKey($var)==false) {
			return array();
		}else{
			return $_REQUEST[$var];
		} 
	}
	
	/**
	 * 
	 * 是否ajax请求
	 * @copyright 2016 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2016-1-4
	 * @author goen<goen88@163.com>
	 * @return boolean
	 */
	public static function isAjax(){
	  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	    return true;
	  }else{
	    return false;
	  }
	}	
	
	/**
	 * 
	 * 是否是GET提交的
	 * @since File available since Version 1.0 2016-1-4
	 * @author goen<goen88@163.com>
	 * @return boolean
	 */
	public static function  isGet(){
	  return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
	}
	
	/**
	 * 
	 * 是否是POST提交的
	 * @since File available since Version 1.0 2016-1-4
	 * @author goen<goen88@163.com>
	 * @return boolean
	 */
	public static function isPost() {
	  return $_SERVER['REQUEST_METHOD'] == 'POST'  ? true : false;
	}
}