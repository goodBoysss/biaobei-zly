<?php

/**
 * HomeAction
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
use Models\UrlsModel;

class HomeAction extends WebAction
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->needLogin = false; //不开启登录验证
        parent::__construct();

    }

    /**
     * 首页
     *
     * @since 2020/5/23 1:35 PM
     * @author goen<goen88@163.com>
     * @return string
     */
    public function goAction() {
        $this->smarty->display('home/home.htm');
    }

}