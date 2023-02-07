<?php
/**
 * lyx_api_authorize_data.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11 9:16
 * @version: v2.0.0
 * @since: 2020/6/11 12:01 PM
 */


namespace LGCommon\data_data;


class lyx_api_authorize_data extends lg_base_data
{
    /**
     * 表名称
     * @var string
     */
    protected $table = 'lyx_api_authorize';


    public function __construct(){
        parent::__construct();
    }


    //根据access_key值获取数据
    public function select_row_by_access_key( $access_key,$clumns="*") {
        $this->link->where("access_key", $access_key);
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }

}
