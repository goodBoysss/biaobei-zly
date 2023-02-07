<?php
/**
 * LGLog.php
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 21:06
 */
namespace LGCore\log;

use Logger;

class LGLog{
	private static $log_path;
	private static $name;
	public  function __construct($name,$path=null){
		self::$name = $name;
		self::$log_path = $path!=null?$path:(defined("LG_RUNTIME_LOG")?LG_RUNTIME_LOG:'');
		$this->setConfigure();
	}
	
	private  function setConfigure(){
		//echo self::$log_path;exit;
		Logger::configure(array(
			    'rootLogger' => array(
			        'appenders' => array('default'),
			    ),
			    'appenders' => array(
			        'default' => array(
			            'class' => 'LoggerAppenderFile',
			            'layout' => array(
			                'class' => 'LoggerLayoutPattern',
			                'params' => array(
			                    'conversionPattern' => '%date{Y-m-d H:i:s,u} %logger %-5level %msg%n'
			                )
			            ),
			            'params' => array(
			            	'file' => self::$log_path,
			            	'append' => true
			            )
			        )
			    )
		));
	}
	
	public function getLogger():Logger{
		return Logger::getLogger(self::$name);
	}
}