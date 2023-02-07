<?php
/**
 * 系统配置文件
 * 
 */

define("LG_MYSQL_MODE",'multi'); //数据库模式：single-单数据库模式;multi-主从，多数据模式
if(LG_MYSQL_MODE=="multi"){
    //mysql数据主库配置文件(Master)
    define("LG_MYSQL_MASTERS",[
        [
            'host'=>'127.0.0.1',
            'username'=>'root',
            'password'=>'123',
            'db'=>'lyx_urls',
            'port'=>'3306',
            'charset'=>'utf8'
        ]
    ]);

    //mysql数据从配置文件(Slave)
    define("LG_MYSQL_SLAVES",[
        [
            'host'=>'127.0.0.1',
            'username'=>'root',
            'password'=>'123',
            'db'=>'lyx_urls',
            'port'=>'3306',
            'charset'=>'utf8'
        ],
    ]);
}else{
    //mysql数据库配置文件，可修改
    define("LG_MYSQL_HOST","127.0.0.1");
    define("LG_MYSQL_USER","root");
    define("LG_MYSQL_PASS","123");
    define("LG_MYSQL_DBNAME","lyx_urls");
    define("LG_MYSQL_PORT","3306");
    define("LG_MYSQL_CHARSET","utf8");
}



//定义Memcache配置
define('LG_MEMCACHE_HOST', 'localhost');
define('LG_MEMCACHE_PORT', 11211);
define('LG_MEMCACHE_EXPIRATION', 0);
define('LG_MEMCACHE_PREFIX', 'iliangcang');
define('LG_MEMCACHE_COMPRESSION', FALSE);


//定义Redis配置
define('LG_REDIS_HOST', "127.0.0.1");
define('LG_REDIS_PORT', 6379);
define('LG_REDIS_AUTH', null);



//定义MongoDB配置
define('LG_MONGODB_URI', "mongodb://127.0.0.1:27017");
define('LG_MONGODB_URIOPTIONS', []);
define('LG_MONGODB_DRIVEROPTIONS', []);
define('LG_MONGODB_NAME', 'xbam');



//用户中心JAVA的URL
define('LG_UCENTER_URL', 'http://dev-ucenter.51lick.cn:18880');
//智慧运营Java接口的URL
define('LG_ZSERVER_URL', 'http://dev-zserver.51lick.cn:18880');

