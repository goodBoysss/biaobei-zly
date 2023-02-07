<?php
/**
 * 
 * 控制器认证类
 * 
 * @author goen
 * 
 */

namespace LGCore\base;

class LGAuthentication
{
	  private $structs_path;
	  private $actions;
	  
	  public function LGAuthentication()
	  {
		    $this->structs_path = LG_STRUCTS_PATH;
		    
	  		if(!file_exists($this->structs_path)){
	  		 	 throw new LGException("LG_STRUCTS_PATH[".$this->structs_path."]文件不存在");
	  		}
	  		$this->actions = require($this->structs_path);
	  }

	  public function get_stuct_info($action_path)
	  {
		     if (!array_key_exists($action_path,$this->actions))
		     {
				   return null;
			 }
			 else
			 {
			 	   $row_action = $this->actions[$action_path];
				   $arr_who_can_access = $this->get_who_can_access($row_action);
				   $arr_res = array(
	                       "act" => $row_action['action_class'],
	                       "who" => $arr_who_can_access,
	                       "comm"=> $row_action['action_comment']
	                       );
	               return $arr_res;
			 }
	  }
	 
	  
	  private function get_who_can_access($row_action)
	  {
		     $arr_who_can_access = array();
		     if ($row_action['group_admin'] == 1)
		     {
				   $arr_who_can_access[] = "admin";
		     }
	  
		     if ($row_action['group_user'] == 1)
		     {
				   $arr_who_can_access[] = "user";
		     }
		     
		     if ($row_action['group_guest'] == 1)
		     {
				   $arr_who_can_access[] = "guest";
		     }
		     return $arr_who_can_access;
	  }
	  
}
?>
