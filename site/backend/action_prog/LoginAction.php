<?php

/**
 * HomeAction.php * ==============================================
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

use Comments\BackendAction;
use Comments\WebAction;
use LGCore\base\LG;
use LGCore\session\staff\StaffSession;
use Models\StaffModel;
class LoginAction extends BackendAction
{

    private $staffModel = null;



    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->needLogin = false; //不开启登录验证

        parent::__construct();

        $this->staffModel = new StaffModel();
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
        new StaffSession($this->staffModel);

        if(isset($_SESSION['adm_user']['ifu'])&&$_SESSION['adm_user']['ifu']=="1"){
            //var_export($_SESSION);exit;
            header('Location:/index',301);
            LG::end();
        }
        $this->smarty->assign('name',"小宝短网址管理后台V1.0");
        $this->smarty->display('login.htm');
    }


}