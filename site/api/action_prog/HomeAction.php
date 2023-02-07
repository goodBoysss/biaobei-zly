<?php

/**
 * homeActionphp
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

use Comments\ApiAction;
use Models\StaffModel;
use LGCore\base\LG;
use Utils\ApiUtils;

class HomeAction extends ApiAction
{

    private $staffModel = null;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @methodName: goAction
     *
     * Enter description here ...
     *
     * @since File available since Version 1.0 ${DATE}
     * @author goen<goen88@163.com>
     * @return string
     */
    public function goAction() {
        //获取用户追踪ID
        if(!isset($_COOKIE['_trace'])){
            $_trace = sha1(time().ApiUtils::real_remote_addr().$_SERVER["HTTP_USER_AGENT"]);
            header("Set-Cookie:_trace={$_trace};path=/");
        }
        LG::rest(10032, array('alert_msg'=>'Error:['.str_ireplace('_action', '',__CLASS__).'->'.str_replace( 'Action', '',__FUNCTION__).']不支持访问'));
    }
}