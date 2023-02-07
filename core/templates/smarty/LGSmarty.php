<?php
/**
 * LGSmarty.php
 * ==============================================
 * Copy right 2014-2017  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : smarty模板引擎,基于smarty3.x
 * @author: goen<goen88@163.com>
 * @date: 2017/6/16
 * @version: v2.0.0
 * @since: 2017/6/16 17:33
 */
namespace LGCore\templates\smarty;

use LGCore\base\LG;
use LGCore\log\LGException;
use Smarty;
class LGSmarty{

    /**
     * 模版目录
     * @var string
     */
    private $template_dir = '';

    /**
     * 模板编译文件目录
     * @var string
     */
    private $compile_dir = '';

    /**
     * 模版缓存目录
     * @var string
     */
    private $cache_dir = '';

    /**
     * 是否开启缓存
     * @var bool
     */
    private $is_caching = false;

    /**
     * smarty左边界符号
     * @var string
     */
    private $left_delimiter = '<{';

    /**
     * smarty右边界符号
     * @var string
     */
    private $right_delimiter = '}>';

    /**
     * smarty 对象
     * @var null
     */
    private $smarty = null;


    /**
     * LGSmarty constructor.
     */
    public function __construct(){

    }


    public function getInstance():Smarty{
        $this->_init();
        return $this->smarty;
    }



    private function _init(){
        if(LG_TEMPLATES_ENGINE==true){
            $this->smarty = new Smarty();
            if(defined("LG_TEMPLATES_DIR_C")){
                $this->smarty->compile_dir  = LG_TEMPLATES_DIR_C;
            }
            //模板共享模式
            if(LG_TEMPLATES_ENGINE_MODE==0){
                $this->smarty->template_dir  = LG_TEMPLATES_DIR;
            }else if(LG_TEMPLATES_ENGINE_MODE==1){
                if($this->template_dir==null){
                    throw new LGException('template_dir is null','');
                }else{
                    $this->smarty->template_dir  = $this->template_dir;
                }
            }
        }else{
            $this->smarty = null;
        }
    }


    /**
     * @return string
     */
    public function getTemplateDir(): string
    {
        return $this->template_dir;
    }

    /**
     * @param string $template_dir
     */
    public function setTemplateDir(string $template_dir)
    {
        $this->template_dir = $template_dir;
    }

    /**
     * @return string
     */
    public function getCompileDir(): string
    {
        return $this->compile_dir;
    }

    /**
     * @param string $compile_dir
     */
    public function setCompileDir(string $compile_dir)
    {
        $this->compile_dir = $compile_dir;
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->cache_dir;
    }

    /**
     * @param string $cache_dir
     */
    public function setCacheDir(string $cache_dir)
    {
        $this->cache_dir = $cache_dir;
    }

}