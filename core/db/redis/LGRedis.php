<?php
/**
 * Redis 操作类
 *
 * 需要在全局配置文件中加入 
   相应配置(可扩展为多memcache server)
     define('LG_REDIS_HOST', "127.0.0.1");
	 define('LG_REDIS_PORT', 6379);
    调用方式:
 		LGRedis::getInstance()->lpush('keyName','this is value');
 		LGRedis::getInstance()->lpop('keyName');
	    exit;
 * @access  public
 * @return  object
 * @author gaorunqiao<goen88@163.com>
 * @since 2016-01-13
 */

namespace LGCore\db\redis;

use LGCore\base\LG;

class LGRedis {
    private static $instance;

    private function __construct() {
    }

    /**
     *
     * 获取redis对象
     *
     * @date 2020/5/18 8:34 PM
     * @author goen<goen88@163.com>
     * @return \Redis
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new \Redis();
            try {
                if (self::$instance->connect(LG_REDIS_HOST, LG_REDIS_PORT) == false) {
                    LG::rest(10022, ['alert_msg' => 'Redis数据库存连接失败']);
                }
                if(defined('LG_REDIS_AUTH')&&LG_REDIS_AUTH){
                    self::$instance->auth(LG_REDIS_AUTH);
                }
            } catch (\Exception $e) {
                LG::rest(10022, ['alert_msg' => 'redis服务不可用']);
            }
        }
        return self::$instance;
    }


}
?>