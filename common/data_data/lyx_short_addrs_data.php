<?php
/**
 * lyx_short_addrs_data.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/5/19
 * @version: v2.0.0
 * @since: 2020/5/19 12:01 PM
 */


namespace LGCommon\data_data;


class lyx_short_addrs_data extends lg_base_data
{
    /**
     * 表名称
     * @var string
     */
    protected $table = 'lyx_short_addrs';


    public function __construct(){
        parent::__construct();
    }

    //根据url的sha1值获取数据
    public function select_row_by_sha1($sha1,$clumns="*"){
        $this->link->where ("sha1", $sha1);
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }

    //根据id值获取数据
    public function select_row_by_id( $id,$clumns="*") {
        $this->link->where("id", $id);
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }

    //根据name值获取数据
    public function select_row_by_name( $name,$clumns="*") {
        $this->link->where("name", $name);
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }

    public function update_a_row_by_id($row_rec,$id){
  	    $this->link->where ('id', $id);
  	    if ($this->link->update ($this->table, $row_rec)){
  	        return $this->link->count;
  	    }
  	}
}
