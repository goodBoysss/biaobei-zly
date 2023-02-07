<?php

/**
 * indexActionphp
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/5/7
 * @version: v2.0.0
 * @since: 2019/5/7 15:39
 */
namespace Controllers;

use Comments\BackendAction;
use Comments\WebAction;
use LGCore\utils\LGUtils;
use Models\StaffModel;
class IndexAction extends BackendAction
{

    private $staffModel = null;
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
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
        $this->smarty->assign('name',"LGFramework2");
        $this->smarty->display('index/index.htm');

    }

    public function mainAction(){
        $diskFreeSpace = LGUtils::get_size_auto(disk_free_space('/'));
        $this->smarty->assign('diskFreeSpace',$diskFreeSpace);
        $this->smarty->display('index/main.htm');
    }

    public function listAction(){
        $rlt = $this->staffModel->staffLists(array(),"*",0,100);


        $this->smarty->assign('staffLists', $rlt['items'] ?? null );
        $this->smarty->display('staffs.htm');

    }
}