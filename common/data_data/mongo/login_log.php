<?php
/**
 * login_log.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/6/19
 * @version: v2.0.0
 * @since: 2019/6/19 2:40 PM
 */


namespace LGCommon\data_data\mongo;


class login_log extends base
{

    protected $collection = 'login_log';

    public function __construct()
    {
        parent::__construct();
    }

}