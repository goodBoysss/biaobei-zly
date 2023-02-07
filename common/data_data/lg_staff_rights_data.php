<?php
/**
 * 后台用户权限
 * 
 */

namespace LGCommon\data_data;

class lg_staff_rights_data extends lg_base_data {
	/**
	 * 表名称
	 * @var string
	 */
	protected $table = 'lg_staff_rights';
	
	public function __construct(){
        parent::__construct();
	}
	

	public function select_a_sum_integral($where=null){
		if($where){
			foreach ($where as $filed=>$value){
				$this->link->where ($filed, $value);
			}
		}
		$sum = $this->link->getValue ($this->table, "sum(integral_amount)");
		return $sum;
	}
	

	//根据staff_id删除信息
	public function delete_row_by_staff_id($staff_id){
	    $count=$this->select_a_sum(array('staff_id'=>$staff_id));
	    $this->link->where('staff_id', $staff_id);
	    if($this->link->delete($this->table)) {
	        return  $count;
	    }
	}

	//根据right_id删除信息
	public function delete_row_by_right_id($right_id){
	    $count=0;
	    $count=$this->select_a_sum(array('right_id'=>$right_id));
	    $this->link->where('right_id', $right_id);
	    if($this->link->delete($this->table)) {
	        return  $count;
	    }
	}
}

