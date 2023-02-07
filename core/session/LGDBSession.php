<?php
/**
 * LGDBSession 获取和取得session到数据库表中
 * Session 的值采用base64加密
 * 
 *  @author goen
 *  @example 
 *  	$session = new LGDBSession($link);
 */

namespace LGCore\session;

use LGCore\base\LGMysqlData;

class LGDBSession extends LGMysqlData
{

    private $session_lifetime;
    
    /**
     * 
     * 创建一个数据库session并开启session
     * @param Object $link
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return object
     */
    public function __construct($table="system_session_data",$session_lifetime='')
    {
        // Instantiate new Database object
        
        $this->table = $table; 
        
         if ($session_lifetime != '' && is_integer($session_lifetime))
             // set the new value
             ini_set('session.gc_maxlifetime', (int)$session_lifetime);
        
        // Set handler to overide SESSION
        session_set_save_handler(
                array($this, "open"), 
                array($this, "close"), 
                array($this, "read"), 
                array($this, "write"), 
                array($this, "destroy"), 
                array($this, "gc")
        );

        $this->session_lifetime = ini_get('session.gc_maxlifetime');
        
        // Start the session
        session_start();
    }


    /**
     * 
     * Open session storage.
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return boolean
     */
    public function open()
    {
        // If successful
        if ($this->link) {
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    /**
     * 
     * Close session storage.
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return boolean
     */
    public function close()
    {
        return true;
    }
   
    
    /**
     * 
     * Read payload from session.
     * @param int $session_id
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public function read($session_id)
    {
    	$this->link->where("session_id", $session_id);
    	$this->link->where("session_expire", time(),'>');
		$rlt = $this->link->getOne($this->table);
    	if($rlt){
    		 return $rlt['session_data'];
    	}else{
    		 return '';
    	}
    }
    
     /**
     * 
     * Write to session.
     * @param int $id
     * @param mixed $payload
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public function write($session_id, $session_data)
    {
    	$data = array(
    				'session_id'=>$session_id,
                    'hash'=>md5(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:''.$_SERVER['REMOTE_ADDR']),
                    'session_data'=>$session_data,
                    'session_expire'=>time()+$this->session_lifetime
    	);
    	
        $id = $this->link->insert($this->table, $data);
        
        if($id){
        	return true;
        }else{
        	return false;
        }
    }
   
    
    /**
     * 
     * Destroy session.
     * @param int $id
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return boolean
     */
    public function destroy($session_id)
    {
        $this->link->where('session_id', $session_id);
		if($this->link->delete($this->table)) {
			return true;
		}else{
			return false;
		}
    }
  
    
    /**
     * 
     * Garbage Collection
     * @param int $max
     * @since File available since Version 1.0 2015-12-30
     * @author goen<goen88@163.com>
     * @return boolean
     */
    public function gc()
    {
     	$this->link->where('session_expire', time(),'<');
		if($this->link->delete($this->table)) {
			return true;
		}else{
			return false;
		}
    }
}