<?php
/**
 * HomeAction
 * ==============================================
 * Copy right 2015-2020  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/3
 * @version: v2.0.0
 * @since: 2019/6/3 19:34
 */
namespace Controllers;

use Comments\UploadAction;
use LGCore\base\LG;
class HomeAction extends UploadAction
{

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
        LG::rest(10032, array('alert_msg'=>'Error:['.str_ireplace('_action', '',__CLASS__).'->'.str_replace( 'Action', '',__FUNCTION__).']不支持访问'));
    }


}
