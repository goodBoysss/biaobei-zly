<?php
/**
 * StaffModel.php
 * ==============================================
 * Copy right 2014-2017  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 后台用户model
 * @author: goen<goen88@163.com>
 * @date: 2017/6/19
 * @version: v2.0.0
 * @since: 2017/6/19 18:35
 */
namespace Models;

use LGCommon\data_data\lg_staff_data;

class StaffModel{



    private $staffObj = null;

    public function __construct()
    {
        $this->staffObj = new lg_staff_data();
    }

    /**
     * @methodName: staffLists
     *
     * 职员列表
     *
     * @param array $where
     * @param string $fileds
     * @param int $offset
     * @param int $count
     * @since File available since Version 1.0 ${DATE}
     * @author goen<goen88@163.com>
     * @return array
     */
    public function staffLists(array $where = array(),
                               string $fileds = "*",
                               int $offset = 0,
                               int $count = 10) :array {
        $rlt =  $this->staffObj->select_muti_num_and_rows($where,$fileds,$offset,$count);

        return $rlt;
    }

}