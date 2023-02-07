<?php
/**
 * 数据访访问基础类
 *
 * @author goen
 *
 */

namespace  LGCore\db\mysqli;

use LGCore\log\LGDBException;
use mysqli;

class LGMysqli
{

	/**
	 * 当前对象实例
	 * @var object
	 */
	 private static $instance;

	/**
	 * MysqliDb主库（或者单库）实例
	 * @var MysqliDb
	 */
	 private $link;

    /**
     * MysqliDb主库（或者单库）实例
     * @var MysqliDb
     */
	 private $linkSlave;


	 private function __construct()
	 {
		$this->_init(); //初始化对象
     }


    /**
     *
     * 获取对象实例
     *
     * @date 2020/5/21 2:47 PM
     * @author goen<goen88@163.com>
     * @return LGMysqli|object
     */
     public static  function getInstance(){
     	if(!self::$instance instanceof  self){
     		self::$instance = new self();
     	}
     	return self::$instance;
     }


    /**
     *
     * 初始化MYSQL数据库
     *
     * @date 2020/5/21 1:56 PM
     * @author goen<goen88@163.com>
     */
     private function _init(){

		if(defined("LG_MYSQL_MODE")&&LG_MYSQL_MODE=='multi'){
            $_mysqliLink = $this->_dealMasterLink();
            $this->link = new MysqliDb($_mysqliLink);

            $_slaveLink = $this->_dealSlaveLink();
            $this->linkSlave = new MysqliDb($_slaveLink);

        }else{
            $_mysqliLink = $this->_dealSingleLink();
            $this->link = new MysqliDb($_mysqliLink);
		}
	 }

    /**
     *
     * 获取主数据库连接
     *
     * @date 2020/5/21 1:27 PM
     * @author goen<goen88@163.com>
     *
     */
    private function _dealSingleLink(){
        try{

            $dbHost = LG_MYSQL_HOST;
            $dbUser = LG_MYSQL_USER;
            $dbPass = LG_MYSQL_PASS;
            $dbName = LG_MYSQL_DBNAME;
            $dbPort = intval( LG_MYSQL_PORT );
            $dbCharset = LG_MYSQL_CHARSET;

            $mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName, (int)$dbPort ) or die("Mysql connect single failed");
            if (mysqli_connect_errno()) {
                throw new LGDBException("Connect Mysql Single failed: ".mysqli_connect_error(),'');
            }
            $mysqli->set_charset($dbCharset);
            return $mysqli;
        }catch (LGDBException $e){
            $e->displayException();
        }
    }



    /**
     *
     * 获取主数据库连接
     *
     * @date 2020/5/21 1:27 PM
     * @author goen<goen88@163.com>
	 *
     */
	 private function _dealMasterLink(){
         try{
         	 $masterDBS = LG_MYSQL_MASTERS;
         	 $masterNum = count($masterDBS); //主库个数
			 $dbNum = mt_rand(0,$masterNum-1); //获取一个主库
             $dbHost = $masterDBS[$dbNum]['host'];
             $dbUser = $masterDBS[$dbNum]['username'];
             $dbPass = $masterDBS[$dbNum]['password'];
             $dbName = $masterDBS[$dbNum]['db'];
             $dbPort = $masterDBS[$dbNum]['port'];
             $dbCharset = $masterDBS[$dbNum]['charset'];
             $mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName, (int)$dbPort ) or die("Mysql connect Master[{$dbNum}] failed");
             if (mysqli_connect_errno()) {
                 throw new LGDBException("Connect Mysql Master[{$dbNum}] failed: ".mysqli_connect_error(),'');
             }
             $mysqli->set_charset($dbCharset);
             return $mysqli;
         }catch (LGDBException $e){
             $e->displayException();
         }
	 }

    /**
     *
     * 获取从数据库链接
     *
     * @date 2020/5/21 1:27 PM
     * @author goen<goen88@163.com>
     */
     private function _dealSlaveLink(){
         try{
             $slaveDBS = LG_MYSQL_SLAVES;
             $masterNum = count($slaveDBS); //主库个数
             $dbNum = mt_rand(0,$masterNum-1); //获取一个主库
             $dbHost = $slaveDBS[$dbNum]['host'];
             $dbUser = $slaveDBS[$dbNum]['username'];
             $dbPass = $slaveDBS[$dbNum]['password'];
             $dbName = $slaveDBS[$dbNum]['db'];
             $dbPort = $slaveDBS[$dbNum]['port'];
             $dbCharset = $slaveDBS[$dbNum]['charset'];
             $mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName, (int)$dbPort ) or die("Mysql connect Slave[{$dbNum}] failed");
             if (mysqli_connect_errno()) {
                 throw new LGDBException("Connect Mysql Slave[{$dbNum}] failed: ".mysqli_connect_error(),'');
             }
             $mysqli->set_charset($dbCharset);
             return $mysqli;
         }catch (LGDBException $e){
             $e->displayException();
         }
     }


    /**
     *
     * 创建一个自定义链接
	 *
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param int $dbPort
     * @param string $dbCharset
     * @date 2020/5/21 1:54 PM
     * @author goen<goen88@163.com>
     * @return mysqli
     */
    public function newConnect(string $dbHost,
                                    string $dbUser,
                                    string $dbPass,
                                    string $dbName,
                                    int $dbPort=3306,
                                    string $dbCharset='utf8'
    ){
        try{
            $mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName, (int)$dbPort ) or die('mysql connect self failed');

            if (mysqli_connect_errno()) {
                throw new LGDBException("Connect self mysql failed: ".mysqli_connect_error(),'');
            }
            $mysqli->set_charset($dbCharset);
            return $mysqli;
        }catch (LGDBException $e){
            $e->displayException();
        }
    }


    /**
     *
     * 获取主库链接实例
     *
     * @date 2020/5/21 1:14 PM
     * @author goen<goen88@163.com>
     * @return MysqliDb
     */
	 public function getLink():MysqliDb{
	 	return $this->link;
	 }

    /**
     *
     * 获取从库实例
     *
     * @date 2020/5/21 1:17 PM
     * @author goen<goen88@163.com>
     */
	public function getSlaveLink():MysqliDb{
		return $this->linkSlave;
	}
}

?>
