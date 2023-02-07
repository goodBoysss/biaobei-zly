<?php
/**
 * 
 * DB Exception Class
 * 
 * @author    goen <goen88@163.com>
 * 
 */
namespace LGCore\log;

use LGCore\base\LG;

class LGDBException extends \Exception {
	public function __construct($message, $code){
		//parent::__construct($message, $code);
		//$this->displayException();
	}
	
	public function displayException(){	
		$msg = get_class($this).': '.$this->getMessage().' ('.$this->getFile().':'.$this->getLine().")\n";
		$msg .= $this->getTraceAsString()."\n";
		LG::log("DataBase")->error($msg);
	}
}