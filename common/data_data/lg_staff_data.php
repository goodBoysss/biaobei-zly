<?php

namespace LGCommon\data_data;

class lg_staff_data extends lg_base_data {
	/**
	 * 表名称
	 * @var string
	 */
	protected $table = 'lg_staff';

	public function __construct(){

		parent::__construct();
	}
	

	public function select_a_row_by_staff_id($staff_id){

		$this->link->where ("staff_id", $staff_id);

		$rlt = $this->link->getOne ($this->table);
		return $rlt;
	}
	
	
	public function select_a_row_by_username($username){

		$this->link->where ("username", $username);

		$rlt = $this->link->getOne ($this->table);
		return $rlt;
	}

	//根据staff_id修改信息
	public function update_a_row_by_staff_id($row_rec,$staff_id){
	    $this->link->where ('staff_id', $staff_id);
	    if ($this->link->update ($this->table, $row_rec)){
	        return $this->link->count;
	    }
	}
	//根据staff_id删除信息
	public function delete_a_row_by_staff_id($staff_id){
	    $count=$this->select_a_sum(array('staff_id'=>$staff_id));
	    $this->link->where('staff_id', $staff_id);
	    if($this->link->delete($this->table)) {
	        return  $count;
	    }
	}
	//根据group_id删除信息
	public function delete_by_group_id($group_id){
	    $this->link->where('group_id', $group_id);
	    if($this->link->delete($this->table)) {
	        return  $this->link->count;
	    }
	}

}

