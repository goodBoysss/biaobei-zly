<?php
/**
 * 
 * php计时器类
 * 
 * @author goen
 * @since 2014-02-28 00:00:01
 * 
 */
namespace LGCore\utils;

class LGTimer {
  private $StartTime = 0;
  private $StopTime = 0;
  private $TimeSpent = 0;
 
  public function start(){
   		$this->StartTime= microtime(true);
  }

  public function stop(){
  		 $this->StopTime= microtime(true);
  }


  public function spent()
  {
	    if($this->TimeSpent) {
	       return $this->TimeSpent;
	    } else{
	      $this->TimeSpent = $this->StopTime - $this->StartTime;
	      return  $this->TimeSpent."秒";
	    }
  }

}