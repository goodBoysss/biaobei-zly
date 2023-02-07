<?php
/**
 * lg_base_data.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 数据库基类
 * @author: goen<goen88@163.com>
 * @date: 2019/5/31
 * @version: v2.0.0
 * @since: 2019/5/31 4:40 PM
 */

namespace LGCommon\data_data;


use LGCore\base\LG;
use LGCore\base\LGMysqlData;
class lg_base_data extends LGMysqlData {

	public function __construct(){
        parent::__construct();
	}
	
	public function insert_a_row($row_rec){		
		$id = $this->link->insert ($this->table, $row_rec);
		return $id;
	}
	public function select_a_sum($where=null){
		if($where){
			foreach ($where as $filed=>$value){
				$this->link->where ($filed, $value);
			}
		}
		$count = $this->link->getValue ($this->table, "count(*)");
		return $count;
	}

	public function select_muti_rows($where=null,$fileds='*',$offset=0,$count=10,$order=null){
		if(is_array($where)){
			foreach ($where as $filed=>$value){
				$this->link->where ($filed, $value);
			}
		}
		if(is_array($order)){
			foreach ($order as $filed=>$value){
				$this->link->orderBy($filed,$value);
			}
		}
		$rlt = $this->link->get($this->table,array($offset,$count),$fileds);
		return $rlt;
	}
	
	public function select_muti_num_and_rows($where=null,$fileds="*",$offset=0,$count=10,$order=null){
		if(is_array($where)){
			foreach ($where as $filed=>$value){
				$this->link->where ($filed, $value);
			}
		}
		if(is_array($order)){
			foreach ($order as $filed=>$value){
				$this->link->orderBy($filed,$value);
			}
		}
		$rlt = $this->link->withTotalCount()->get($this->table, Array ($offset, $count),$fileds);
		LG::log()->info("=======".$this->link->getLastQuery());
		return array(
			'totalCount'=>$this->link->totalCount,
			'items'=>$rlt
		);
	}
	
	//检测表中是否存在特定字段
	public function check_tab_field($filed_name){
		$rlt = $this->link->rawQuery('desc '.$this->table);
		if($rlt){
			foreach ($rlt as $k=>$v){
				if($filed_name==$v['Field']){
					return true;
				}
			}
		}
		return false;
	}
	
	//查询单条记录
	public function select_a_row($where, $fields="*",$order=null){
	    if(is_array($where)){
	        foreach ($where as $filed=>$value){
	            $this->link->where ($filed, $value);
	        }
	    }
	    if(is_array($order)){
	        foreach ($order as $filed=>$value){
	            $this->link->orderBy($filed,$value);
	        }
	    }
	    $row = $this->link->getOne($this->table, $fields);
	    return $row;
	}


    //根据id值获取数据
    public function select_row_by_id( $id,$clumns="*") {
        $this->link->where("id", $id,'=');
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }

    public function update_a_row_by_id($row_rec,$id){
        $this->link->where ('id', $id);
        if ($this->link->update($this->table, $row_rec)) {
            return $this->link->count;
        }else{
            return 0;
        }
    }

    /**
     *
     * 根据ID删除
     *
     * @date 2020/6/11 1:36 下午
     * @author goen<goen88@163.com>
     */
    public function delete_a_row_by_id($id){
        $this->link->where('id', $id);
        if($this->link->delete($this->table)) {
            return  $this->link->count;
        }
    }

}

