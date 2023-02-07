<?php
/**
 * LGRouter.php
 * ==============================================
 * Copy right 2014-2017  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : WEB请求路由类
 * @author: goen<goen88@163.com>
 * @date: 2017/6/16
 * @version: v2.0.0
 * @since: 2017/6/16 10:39
 */

namespace  LGCore\router;

use LGCore\base\LG;

class LGRouter{

    /**
     * 默认controller名称
     * @var string
     */
    private $default_c = '';

    /**
     * 默认controller文件后缀
     * @var string
     */
    private $subfix = '';

    /**
     * 默认controller 方法名称
     * @var string
     */
    private $default_a = '';

    /**
     * 默认controller 方法名称后缀
     * @var string
     */
    private $default_a_subfix = '';

    /**
     * controller路径
     * @var string
     */
    private $path = '';

    /**
     * 当前controller
     * @var string
     */
    private $controller = '';

    /**
     * 当前入口函数
     * @var string
     */
    private $function = '';


    /**
     * LGRouter constructor.
     */
    public function __construct(){
        $this->default_c = LG_ACTION_NAME;
        $this->default_a = LG_ACTION_FUNC;
        $this->path = LG_WEB_ROOT.DIRECTORY_SEPARATOR.LG_ACTION_DIR_NAME.DIRECTORY_SEPARATOR;
        $this->subfix = LG_ACTION_SUBFIX;
        $this->default_a_subfix = LG_ACTION_FUNC_SUBFIX;
    }



    public function run(){
        if(LG_ENABLE_EXCEPTION_HANDLER){
            set_exception_handler(array($this,'handleException'));
        }
        if(LG_ENABLE_ERROR_HANDLER){
            set_error_handler(array($this,'handleError'),error_reporting());
        }

        register_shutdown_function(array($this,'end'),0,false);


        try{
            $this->parsePath();			//解析URL
            $this->newAndRun();
        }catch (LGException $e){
            LG::displayException($e);
        }catch (LGDBException $e){

            LG::displayException($e);
        }catch (Exception $e){
            LG::displayException($e);
        }finally{
            //LG::rest(10034, array());
        }
    }

    /**
     * 解析URL路径
     * 获得控制器、控制器中函数、参数
     */
    private function parsePath(){
        if(isset($_GET['uri'])){
            //index.php?uri=/home/index/1/2/3
            $_SERVER['REQUEST_URI'] = preg_replace('/(.*)\.php/','',$_GET['uri']);
        }else{
            //index.php/home/index/1/2/3
            $_SERVER['REQUEST_URI'] = preg_replace('/(.*)\.php/','',$_SERVER['REQUEST_URI']);
        }



        if(isset($_SERVER['REQUEST_URI'])){
            $tmb = $_SERVER['REQUEST_URI'];
            if(stripos($tmb,'?')){
                $tmb = substr($tmb, 0,stripos($tmb,'?'));
            }
            $url_param = explode('/',$tmb);
            $this->controller 	= (isset($url_param[1]) && $url_param[1]!=''&& strpos($url_param[1], '?')===false)?$url_param[1]:$this->default_c;
            $this->function		= (isset($url_param[2]) && $url_param[2]!='')?$url_param[2]:$this->default_a;
        }else{
            $this->controller 	= $this->default_c;
            $this->function		= $this->default_a;
        }


        $this->controller = ucfirst($this->controller);
        $this->function = $this->function;

    }

    private function newAndRun(){
        if($this->controller=="favicon.ico") {
            return false;
        }

        if(LG_ACTION_MODE==1) {
            $crtlClass = "\\Controllers\\".$this->controller."\\" . $this->controller .str_replace(".php",'',$this->subfix);
        }else{
            $crtlClass = "\\Controllers\\" . $this->controller .str_replace(".php",'',$this->subfix);
        }


        //如果类不存在，则是走默认路由
        if (!class_exists($crtlClass)) {
            $this->controller 	= $this->default_c;
            $this->function		= $this->default_a;
            $this->controller = ucfirst($this->controller);
            if(LG_ACTION_MODE==1) {
                $crtlClass = "\\Controllers\\".$this->controller."\\" . $this->controller .str_replace(".php",'',$this->subfix);
            }else{
                $crtlClass = "\\Controllers\\" . $this->controller .str_replace(".php",'',$this->subfix);
            }
        }


        $_classObj = new $crtlClass();
        $fun = $this->function.$this->default_a_subfix;

        $_classObj->$fun();

    }




    /**
     *
     * 抛出一个错误
     * @param  $message 内容
     * @copyright 2015 by gaorunqiao.ltd
     * @since File available since Version 1.0 2015-12-28
     * @author goen<goen88@163.com>
     * @return the bare_field_name
     */
    function throwException($message){
//			if($this->config['is_bug']===false){
//				return;
//			}
        throw new LGException($message);
    }


    public function handleError($code,$message,$file,$line)
    {
        if($code & error_reporting())
        {
            // disable error capturing to avoid recursive errors
            restore_error_handler();
            restore_exception_handler();
            $log="$message ($file:$line)\nStack trace:\n";
            $trace=debug_backtrace();
            // skip the first 3 stacks as they do not tell the error position
            if(count($trace)>3)
                $trace=array_slice($trace,3);
            foreach($trace as $i=>$t)
            {
                if(!isset($t['file']))
                    $t['file']='unknown';
                if(!isset($t['line']))
                    $t['line']=0;
                if(!isset($t['function']))
                    $t['function']='unknown';
                $log.="#$i {$t['file']}({$t['line']}): ";
                if(isset($t['object']) && is_object($t['object']))
                    $log.=get_class($t['object']).'->';
                $log.="{$t['function']}()\n";
            }
            if(isset($_SERVER['REQUEST_URI']))
                $log.='REQUEST_URI='.$_SERVER['REQUEST_URI'];
            //Yii::log($log,CLogger::LEVEL_ERROR,'php');
            LG::log('HandleError')->error($log);
        }
    }



    public function handleException($exception)
    {
        // disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();
        $message=$exception->__toString();
        if(isset($_SERVER['REQUEST_URI']))
            $message.="\nREQUEST_URI=".$_SERVER['REQUEST_URI'];
        if(isset($_SERVER['HTTP_REFERER']))
            $message.="\nHTTP_REFERER=".$_SERVER['HTTP_REFERER'];
        $message.="\n---";
        LG::log('HandleEeception')->error($message);
    }

    public function end($status=0,$exit=true)
    {
        exit($status);
    }


}

