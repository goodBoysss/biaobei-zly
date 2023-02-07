<?php
/**
 * 
 * Exception Class
 * 
 * @author    goen <goen88@163.com>
 * 
 */
namespace LGCore\log;

use LGCore\base\LG;

class LGException extends Exception {
	public function __construct($message, $code){
		parent::__construct($message, $code);
		//$this->displayException();
	}
	
	public function displayException(){	
		$msg = '';
		if(isset($_SERVER['REQUEST_URI']))
		$msg.="\nREQUEST_URI=".$_SERVER['REQUEST_URI'];
		if(isset($_SERVER['HTTP_REFERER']))
			$msg.="\nHTTP_REFERER=".$_SERVER['HTTP_REFERER'];
		if(isset($_POST))
			$msg.="\n\$_POST=".var_export($_POST,true);
		if(isset($_GET))
			$msg.="\n\$_GET=".var_export($_GET,true);
		$msg.="\n---\n";
		$msg .= get_class($this).': '.$this->getMessage().' ('.$this->getFile().':'.$this->getLine().")\n";
		$msg .= $this->getTraceAsString()."\n";
		$msg .= '$_SERVER='.var_export($_SERVER,true);
		LG::log()->error($msg);
	}
}