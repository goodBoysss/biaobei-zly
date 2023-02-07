<?php
/**
 * app.php
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 19:29
 */

require_once(dirname(__DIR__) . '/conf/conf_const_var.php');


use LGCore\server\HttpServer;


$svr = new HttpServer();
$svr->run();


