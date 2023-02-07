<?php
/**
 * Bootstrap.php
 * ==============================================
 * Copy right 2017-2020  by Gaorunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 18:00
 */
declare(strict_types=1);

namespace common\config;

if(!defined("LG_ROOT")){
    define("LG_ROOT", dirname(dirname(__DIR__)));
}

require_once("DBConfig.php");
require_once("Config.php");

ini_set('date.timezone',LG_TIMEZONE);

require_once LG_ROOT."/vendor/autoload.php";
