<?php

/**
 * UrlsAction
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 19:34
 */
namespace Controllers;

use Comments\WebAction;
use LGCore\base\LG;
use Models\UrlsModel;

class UrlsAction extends WebAction
{

    private $urlsModel = null;

    /**
     * UrlsAction constructor.
     */
    public function __construct()
    {
        $this->needLogin = false; //不开启登录验证

        parent::__construct();
        $this->urlsModel = new UrlsModel();

    }

    /**
     * @methodName: goAction
     *
     * @since 2020/6/19 1:06 下午
     * @author goen<goen88@163.com>
     * @return string
     */
    public function goAction() {
        //短链接跳转
        $urlsModel = new UrlsModel();
        $url = $this->getRequestUri();
        $rlt = $urlsModel->urlOne(['url'=>$url]);
        if(!array_key_exists('error',$rlt)){

            //增加点击计数
            $hitsRlt = $urlsModel->urlHits(['url'=>$url]);
            //TODO 还需要加入请求日志。暂未实现
            if($rlt['items']['status']==1){
                ob_clean();
                header("Location:".$rlt['items']['url'],true,301);
                return true;
            }else{
                echo "页面已被禁用，如有疑问请联系服务商。";
            }
        }else{
            echo "页面不存在，如有疑问请联系服务商。";
        }
        LG::end();
    }
}
