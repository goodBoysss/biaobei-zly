<?php
/**
 * Config.php
 * ==============================================
 * Copy right 2014-2017  by Gaorunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 系统配置文件
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 18:15
 */


if(!defined("LG_MYSQL_MODE")){
    define("LG_MYSQL_MODE",'single'); //数据库模式：single-实例模式;multi-主从，多实例模式
}

//mysql数据库配置文件，可修改
if(!defined("LG_MYSQL_HOST"))define("LG_MYSQL_HOST","localhost");
if(!defined("LG_MYSQL_USER"))define("LG_MYSQL_USER","user");
if(!defined("LG_MYSQL_PASS"))define("LG_MYSQL_PASS","pwd");
if(!defined("LG_MYSQL_DBNAME"))define("LG_MYSQL_DBNAME","db_name");
if(!defined("LG_MYSQL_PORT"))define("LG_MYSQL_PORT","3306");
if(!defined("LG_MYSQL_CHARSET"))define("LG_MYSQL_CHARSET","utf8");


//系统工程目录，不可修改
if(!defined("LG_ROOT")){
    define("LG_ROOT", dirname(dirname(__FILE__)));
}

//是否开启调试模式，上线后关闭
if(!defined("LG_DEBUG")){
    define("LG_DEBUG",false);
}

//默认时区,上海
if(!defined("LG_TIMEZONE")){
    define("LG_TIMEZONE",   'Asia/Shanghai');
}

if (defined("LG_DEBUG") && LG_DEBUG)
{
    @ini_set("error_reporting", E_ALL);
    @ini_set("display_errors", TRUE);
}

//是否开启调试模式，默认关闭
if(!defined("LG_WEB_ROOT")){
    define("LG_WEB_ROOT",LG_ROOT.'/site/backend');
}


//控制器认证，默认关闭
if(!defined("LG_AUTHENTICATION")){
    define("LG_AUTHENTICATION",false);
}

//控制器路径
if(!defined("LG_STRUCTS_PATH")){
    define("LG_STRUCTS_PATH", LG_WEB_ROOT.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.'config_structs.php');
}

//控制器模式：0->共享模式，controller文件都放action_prog根目录；
//1-分离模式，controller文件放在action_prog和类名相同的目录，建议和LG_TEMPLATES_ENGINE_MODE同时使用
if(!defined("LG_ACTION_MODE")){
    define("LG_ACTION_MODE",0);
}


//默认actin类名称
if(!defined("LG_ACTION_NAME")){
    define("LG_ACTION_NAME",'home');
}
//默认actin类入口函数名称
if(!defined("LG_ACTION_FUNC")){
    define("LG_ACTION_FUNC",'go');
}

//默认actin类入口函数名称
if(!defined("LG_ACTION_FUNC_SUBFIX")){
    define("LG_ACTION_FUNC_SUBFIX",'Action');
}

//默认acting目录名称
if(!defined("LG_ACTION_DIR_NAME")){
    define("LG_ACTION_DIR_NAME",'action_prog');
}
//默认action类型后缀
if(!defined("LG_ACTION_SUBFIX")){
    define("LG_ACTION_SUBFIX",'Action.php');
}

//是否开启myql数据库，默认开启
if(!defined("LG_DB_MYSQL")){
    define("LG_DB_MYSQL",true);
}

//是否开启redis，默认关闭
if(!defined("LG_DB_REDIS")){
    define("LG_DB_REDIS",false);
}

//是否开启memcache，默认关闭
if(!defined("LG_DB_MEMCACHE")){
    define("LG_DB_MEMCACHE",false);
}

//是否开启MongoDB，默认关闭
if(!defined("LG_DB_MONGODB")){
    define("LG_DB_MONGODB",false);
}

//是否开启smarty，默认关闭
if(!defined("LG_TEMPLATES_ENGINE")){
    define("LG_TEMPLATES_ENGINE",false);
}

//模板引擎模式：0->共享模式，模板文件放在LG_TEMPLATES_DIR配置中；
//1-分离模式，模板文件和controller同目录,建议和LG_ACTION_MODE同时使用
if(!defined("LG_TEMPLATES_ENGINE_MODE")){
    define("LG_TEMPLATES_ENGINE_MODE",0);
}

//模板文件目录，在LG_TEMPLATES_ENGINE_MODE1时失效
if(!defined("LG_TEMPLATES_DIR")){
    define("LG_TEMPLATES_DIR",LG_WEB_ROOT.DIRECTORY_SEPARATOR.'action_templates');
}
//模板编译文件目录
if(!defined("LG_TEMPLATES_DIR_C")){
    define("LG_TEMPLATES_DIR_C",LG_WEB_ROOT.DIRECTORY_SEPARATOR.'action_templates_c');
}

//定义日志目录
if(!defined("LG_RUNTIME_LOG")){
    define("LG_RUNTIME_LOG", LG_WEB_ROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'app.log' );
}

//定义日志目录,单位M（兆）,默认64M
if(!defined("LG_RUNTIME_LOG_SIZE")){
    define("LG_RUNTIME_LOG_SIZE", 64);
}


//框架异常处理函数，默认开启
if(!defined("LG_ENABLE_EXCEPTION_HANDLER")){
    define("LG_ENABLE_EXCEPTION_HANDLER", true);
}

//框架错误处理函数,默认开启,一般用于捕捉  E_NOTICE 、E_USER_ERROR、E_USER_WARNING、E_USER_NOTICE
//不能捕捉：E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR and E_COMPILE_WARNING
if(!defined("LG_ENABLE_ERROR_HANDLER")){
    define("LG_ENABLE_ERROR_HANDLER", true);
}

//定义session存储模式：0->存在服务器；1-数据库
if(!defined("LG_SESSION_MODE")){
    define("LG_SESSION_MODE", 0);
}

//是否开启全局HTTP参数AES加密
if(!defined("LG_AES_HTTP_PARAMERS_ENCODE")){
    define("LG_AES_HTTP_PARAMERS_ENCODE", false);
}

//是否开启全局HTTP参数AES解密
if(!defined("LG_AES_HTTP_PARAMERS_DECODE")){
    define("LG_AES_HTTP_PARAMERS_DECODE", false);
}

//HTTP参数AES盐
if(!defined("LG_AES_SALT")){
    define("LG_AES_SALT", 'LC.E23EFB7D76F17');
}
