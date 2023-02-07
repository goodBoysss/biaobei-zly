<?php
/**
 * 后台用户组
 * 
 */

namespace LGCommon\data_data;

class lg_staff_group_data extends lg_base_data{
	/**
	 * 表名称
	 * @var string
	 */
	protected $table="lg_staff_group";

	public function __construct(){
        parent::__construct();
	}

	
	public function select_a_sum_integral($where=null)
    {
        if ($where) {
            foreach ($where as $filed => $value) {
                $this->link->where($filed, $value);
            }
        }
        $sum = $this->link->getValue($this->table, "sum(integral_amount)");
        return $sum;
    }

	//根据group_id修改信息
	public function update_a_row_by_group_id($row_rec,$group_id){
	    $this->link->where ('group_id', $group_id);
	    if ($this->link->update ($this->table, $row_rec)){
	        //$db->count . ' records were updated';
	        return $this->link->count;
	    }
	}
	//根据group_id删除信息
	public function delete_a_row_by_group_id($group_id){
	    $this->link->where('group_id', $group_id);
	    if($this->link->delete($this->table)) {
	        return  $this->link->count;
	    }
	}
	//根据用户组id获取用户组名称
	public function select_row_by_group_id($group_id,$fieldName='*'){
	    $this->link->where('group_id', $group_id);
	    $rlt=$this->link->getOne($this->table,$fieldName);
	    return $rlt;
	}
	//根据用户组名称获取信息
	public function select_a_row_by_group_name($group_name,$fieldName='*'){
	    $this->link->where('group_name', $group_name);
	    $rlt=$this->link->getOne($this->table,$fieldName);
	    return $rlt;
	}

	
}

