<?php
/**
 * 后台权限菜单
 * 
 */

namespace LGCommon\data_data;


class lg_staff_right_menus_data extends lg_base_data {
	/**
	 * 表名称
	 * @var string
	 */
	protected $table='lg_staff_right_menus';

	
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
	

	//根据$sr_menu_id修改信息
	public function update_a_row_by_right_id($row_rec,$sr_menu_id){
	    $this->link->where ('sr_menu_id', $sr_menu_id);
	    if ($this->link->update ($this->table, $row_rec)){
	        return $this->link->count;
	    }
	}
    
	//根据$sr_menu_id删除信息
	public function delete_a_row_by_sr_menu_id($sr_menu_id){
	    $this->link->where('sr_menu_id', $sr_menu_id);
	    if($this->link->delete($this->table)) {
	        return  $this->link->count;
	    }
	}
	//根据$right_name查询信息
	public function select_a_row_by_right_name($right_name){
	   
	    $this->link->where ("right_name", $right_name);
		$rlt = $this->link->getOne ($this->table);
		return $rlt;
	}
	//根据$parent_id查询信息
	public function select_a_row_by_parent_id($parent_id){
	    $this->link->where ("parent_id", $parent_id);
	    $rlt = $this->link->getOne ($this->table);
	    return $rlt;
	}
	//根据权限ID查询信息
	public function select_a_row_by_sr_menu_id($sr_menu_id){
	    $this->link->where ("sr_menu_id", $sr_menu_id);
	    $rlt = $this->link->getOne ($this->table);
	    return $rlt;
	}


}

