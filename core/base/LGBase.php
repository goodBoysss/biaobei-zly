<?php
/**
 * LGBase.php
 * ==============================================
 * Copy right 2014-2017  by Gaorunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 框架核心基类
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 21:06
 */
namespace LGCore\base;

use LGCore\log\LGLog;
use LGCore\router\LGRouter;
use LGCore\log\LGError;
use LGCore\utils\LGContext;
use LGCore\db\redis\LGRedis;
use LGCore\db\memcache\LGMemcache;

class LGBase{
	private static  $_logger;
	private static $_app;

	public static $LG_start_time=0;
	public static $params=array(); //系统自定义参数

    /**
     * @var \Redis
     */
	public static $redis;

	public static $memcache;

	public static  function createAppliaction(){

		self::$LG_start_time = microtime();

		/**
		 * init user self paramas
		 */
		if(file_exists(LG_ROOT."/common/config/Params.php")){
			self::$params = require_once(LG_ROOT."/common/config/Params.php");
		}

		/**
		 * init redis and memcache Cache DB,if is needed
		 */
		self::getRedis();
		self::getMemcache();

		/**
		 * start application now
		 */
		self::$_app =  new LGRouter();
		return self::$_app;
	}


	public static function log($name='Application',$path=null){
		self::$_logger = new LGLog($name,$path);
		self::$_logger = self::$_logger->getLogger();
		return self::$_logger;
	}

	/**
	 * 获取请求数据
	 *
	 * @since File available since Version 1.0 2016-1-4
	 * @author goen<goen88@163.com>
	 * @return LGContext
     *
	 */
	public static function reqeust(){
		return  new LGContext;
	}


	/**
	 *
	 * API返回数据结果集接口
	 * @param  $status 状态
	 * @param  $datas 数据
	 * @param  $account_id 账户
	 * @since File available since Version 1.0 2015-12-29
	 * @author goen<goen88@163.com>
	 * @return json
	 */
	public static function rest($status,$datas,$account_id=0){
        $start_time = explode(' ', self::$LG_start_time);
        $end_time = explode(' ', microtime());
        $cost = $end_time[0] + $end_time[1] - ($start_time[0] + $start_time[1]);
        $ret = array();
        if($status===null) $status=10034;
        $ret['meta'] = array(
            'status'=>$status,
            'server_time'=>date("Y-m-d H:i:s"),
            'account_id'=>$account_id,
            'cost'=> $cost,
            'errdata'=> "",
            'errmsg'=> ""
        );
        $ret['version'] = 1;
        if($status==0){
            $ret['data']['has_more'] =  isset($datas['has_more'])?$datas['has_more']:false;
            $ret['data']['num_items'] =   isset($datas['num_items'])?$datas['num_items']:0;
            $ret['data']['items'] = isset($datas['items'])?$datas['items']:array();
            if(isset($datas['order_items'])) $ret['data']['order_items']  = $datas['order_items'];
        }else{
            $ret['meta']['errmsg'] =  isset(LGError::$RROR_MESSAGES[$status])?LGError::$RROR_MESSAGES[$status]:'';
            $ret['meta']['errdata'] = isset($datas['errdata'])?$datas['errdata']:null;
            $ret['data']['alert_msg'] = isset($datas['alert_msg'])?$datas['alert_msg']:LGError::$RROR_MESSAGES[$status];
        }
        $jsonData = json_encode($ret);
        $jsonData = str_replace(array(':null'), array(':""'), $jsonData);
        if($status==0){
            echo $jsonData ;
        }else{
            exit ( $jsonData );
        }
	}


	/**
	 *
	 * 输出异常信息
	 *
	 * @param Exception $e
	 * @copyright 2015 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2015-12-30
	 * @author goen<goen88@163.com>
	 * @return null
	 */
	public static function displayException($e){
		if($e instanceof LGDBException){
			$e->displayException();
		}else if($e instanceof  LGException){
			$e->displayException();
		}else{
			$msg = get_class($e).': '.$e->getMessage().' ('.$e->getFile().':'.$e->getLine().")\n";
			$msg .= $e->getTraceAsString()."\n";
			LG::log()->error($msg);
		}
	}


	/**
	 * 权限认证
	 * string[控制器名称] $actionPath
	 * @copyright 2015 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2015-12-31
	 * @author goen<goen88@163.com>
	 * @return 返回可访问用户权限
	 */
	public static function authentication($actionPath){
		$authObj = new LGAuthentication();
		$accessArr = $authObj->get_stuct_info($actionPath);
		return $accessArr;
	}


	/**
	 *
	 * 框架退出
	 *
	 * @copyright 2015 by gaorunqiao.ltd
	 * @author goen<goen88@163.com>
	 * @return none
	 */
	public static function end(){
		exit(1);
	}




    /**
	 * 获取redis数据库句柄
	 *
	 * @since File available since Version 1.0 2016-1-13
	 * @author goen<goen88@163.com>
	 * @return \Redis
	 */
	public static function getRedis(){
		if(LG_DB_REDIS==true){
			self::$redis = LGRedis::getInstance();
		}
	}

	/**
	 * 获取Memcace数据库句柄
	 *
	 * @since File available since Version 1.0 2016-1-13
	 * @author goen<goen88@163.com>
	 * @return null
	 */
	public static function getMemcache(){
		if(LG_DB_MEMCACHE==true){
			self::$memcache = LGMemcache::getInstance();
		}
	}


    /**
     *
     * 获取MongoDB对象句柄
     *
     * @date  2019/6/19 3:31 PM
     * @author goen<goen88@163.com>
     * @return \MongoDB\Client|null
     */
	public static function getMongoDB(){
        //mongodb://rs1.example.com
        $mongodb = null;
        if(LG_DB_MONGODB==true){
            $mongodb = new \MongoDB\Client(LG_MONGODB_URI,LG_MONGODB_URIOPTIONS,LG_MONGODB_DRIVEROPTIONS);
        }
        return $mongodb;
    }
}
