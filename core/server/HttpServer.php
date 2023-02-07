<?php
/**
 * HttpServer.php
 * ==============================================
 * Copy right 2015-2017  by http://www.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :  基于swoole创建的httpServer
 * @author: goen
 * @date: 2017年4月18日
 * @version: v1.0.0
 * @since: 2017年4月18日 下午5:11:23
 */
namespace LGCore\server;

use LGCore\base\LG;


class HttpServer{
    /**  超全局变量
     *  $GLOBALS
     * $_SERVER
     *  $_REQUEST
     *  $_POST
     *  $_GET
     *  $_FILES
     *  $_ENV
     *  $_COOKIE
     *  $_SESSION
     */

    private $rootPath;

    private $httpConf = null; //http服务配置文件

    public function __construct(){
        $this->rootPath = LG_WEB_ROOT ?? dirname(dirname(dirname(__DIR__)));

        $_conf = parse_ini_file($this->rootPath."/conf/Swoole.ini",true);
        $this->httpConf = $_conf['http'];

    }

    public function run(){
        $_svr_host = isset($this->httpConf['server_host'])?$this->httpConf['server_host']:'0.0.0.0';
        $_svr_port = isset($this->httpConf['server_port'])?$this->httpConf['server_port']:'9501';
        $serv = new \Swoole\Http\Server($_svr_host, $_svr_port);


        //设置运行时参数
        $setArr = array(
            'worker_num' => 2,
            'daemonize' => isset($this->httpConf['daemonize'])?$this->httpConf['daemonize']:0,
            'backlog' => isset($this->httpConf['backlog'])?$this->httpConf['backlog']:128,
            'log_file' => isset($this->httpConf['log_file'])?$this->rootPath."/".$this->httpConf['log_file']:'',
            'log_level' => isset($this->httpConf['log_level'])?$this->httpConf['log_level']:0,
        );
        if(isset($this->httpConf['worker_num'])) {
            $setArr['worker_num']=$this->httpConf['worker_num'];
        }
        if(isset($this->httpConf['reactor_num'])){
            $setArr['reactor_num']=$this->httpConf['reactor_num'];
        }
        $serv->set($setArr);

        //注册事件回调函数
        $serv->on('Request', array($this,"onRequest"));
        $serv->on('Connect', array($this,"onConnect"));

        //启动服务
        $serv->start();
    }

    public function onRequest($request, $response){
        //echo "[".__METHOD__."] called \r\n";
        //var_export($request);
        $code = 200;

        //$_GET = self::$_GET = $request->get ?? null;


        $this->_setHttpEnv($request);
        ob_start();
        ob_flush();
        LG::createAppliaction()->run();
        $body = ob_get_contents();
//         var_dump($request->get);
//         var_dump($request->post);
//         var_dump($request->cookie);
//         var_dump($request->files);
//         var_dump($request->header);
//         var_dump($request->server);


        ob_end_clean();

        $body = $body ?? '<h1>Hello Swoole!</h1>';
//      header("HTTP/1.1 ".$code." server error");
        $response->cookie("GSCOOKIEID", md5(uniqid()));
        $response->header("LG-Server", "BySW1.9.5");
//        $response->header("HTTP/1.1 ".$code." server error");
        $response->header("Server", "GRQ-SW");
        $response->end($body);

    }

    public function onConnect($server,  $fd,  $from_id){
        //热启动
        $server->reload();
    }


    private function _setHttpEnv(\Swoole\Http\Request $request){
        $_server = $request->server ?? array();
        $_header = $request->header ?? array();
        $_get = $request->get ?? array();
        $_post = $request->get ?? array();
        $_files = $request->files ?? array();
        $_cookie = $request->cookie ?? array();

        $_server = array_merge($_header,$_server);
        foreach ($_server as $k=>$v){
            $_SERVER[strtoupper($k)] = $v;
        }
        $_GET = $_get;
        $_POST = $_post;
        $_FILES = $_files;
        $_COOKIE =$_cookie;
    }

}
