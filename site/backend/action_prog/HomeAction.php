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

use Comments\BackendAction;
use Models\StaffModel;
class HomeAction extends BackendAction
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
//        $loginLog =  new \LGCommon\data_data\mongo\login_log();
//        $loginLog->insertOne([
//            'username' => 'admin',
//            'email' => 'admin@example.com',
//            'name' => 'Admin User',
//            'add_time'=>date('Y-m-d H:i:s')
//        ]);
        $loginCtrl = new LoginAction();
        $loginCtrl->goAction();
    }

    public function listAction(){

        $loginLog =  new \LGCommon\data_data\mongo\login_log();
        $rlt = $loginLog->findMany([],['limit'=>10,'skip'=>0]);
        foreach ($rlt as $doc){
            echo $doc['_id'],'|',$doc['name'],'|',$doc['add_time']."<br>";
        }

        echo '<pre>';
        var_export($rlt);
        exit;

        $rlt = $this->staffModel->staffLists(array(),"*",0,100);

        $this->smarty->assign('staffLists', $rlt['items'] ?? null );
        $this->smarty->display('staffs.htm');
    }
}