<?php
/**
 * conf_const_var.php
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 19:27
 */

//系统工程目录
if(!defined("LG_ROOT")){
    define("LG_ROOT", dirname(dirname(dirname(dirname(__FILE__)))) );
}
//web根目录
define("LG_WEB_ROOT", dirname(dirname(__FILE__)) );



define("LG_DEBUG",true);

define("LG_TEMPLATES_ENGINE",true);

//是否开启myql数据库，默认开启】
define("LG_DB_MYSQL",true);

//开启Redis
define("LG_DB_REDIS",true);

#define("LG_ACTION_SUBFIX",'Controller.php');


require_once(LG_ROOT.'/common/config/Bootstrap.php');

require_once(LG_WEB_ROOT.'/vendor/autoload.php');