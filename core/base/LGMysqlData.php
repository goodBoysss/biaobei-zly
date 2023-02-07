<?php
/**
 * LGMysqlData.php
 *
 * ==============================================
 * Copy right 2014-2017  by Gaorunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 数据库调用基类
 *
 * @author: goen<goen88@163.com>
 * @date: 2020/5/21
 * @version: v2.0.0
 * @since: 2020/5/21 3:13 PM
 */
namespace LGCore\base;

use LGCore\db\mysqli\LGMysqli;
use LGCore\db\mysqli\MysqliDb;
use LGCore\log\LGDBException;

abstract class LGMysqlData{
    /**
     * Mysql主库对象
     * @var MysqliDb
     */
	protected $link;

    /**
     * mysql从库对象
     * @var MysqliDb
     */
	protected $linkSlave;


    /**
     * 表名称
     * @var string
     */
    protected $table;


    public function __construct()
    {
        //初始化PHP对象
        $this->_initDB();
    }


    /**
     * 初始化对象
     *
     * @date 2020/5/21 3:21 PM
     * @author goen<goen88@163.com>
     */
    private function _initDB(){
        $dbIns = LGMysqli::getInstance();
        $this->link = $dbIns->getLink();
        $this->linkSlave = $dbIns->getSlaveLink();
    }

    /**
     *
     * 设置表名
     *
     * @date 2020/5/19 1:24 PM
     * @author goen<goen88@163.com>
     */
    public function setTable($table){
        $this->table = $table;
    }

    /**
     *
     * 获取数据库名称
     *
     * @date 2020/5/23 11:53 AM
     * @author goen<goen88@163.com>
     */
    public function getDBName(){
        return  LG_MYSQL_MODE=='multi'?LG_MYSQL_MASTERS[0]['db']:LG_MYSQL_DBNAME;
    }


    /**
     *
     * 获取当前表的指定字段最大ID
     *
     * @date 2020/5/27 12:28 PM
     * @author goen<goen88@163.com>
     * return int
     */
    public function getMaxId($id='id'){
       return  (int)$this->link->getValue($this->table,"max({$id})");
    }


    /**
     *
     * 批量插入
     *
     * @param array $insertDatas 批量插入数据
     * @param string $column 字段
     * @param bool $ignore 是否暴力插入，默认true
     * @date 2020/5/27 2:51 PM
     * @author goen<goen88@163.com>
     * @return bool
     * @throws LGDBException
     */
    public function insertMulti(array $insertDatas,$column="",$ignore=true){
        if(empty($insertDatas)||!is_array($insertDatas)){
            return false;
        }

        $insSql = "insert ".($ignore?'ignore ':'')." into `".$this->table."`  ";
        if(!empty($column)){
            $insSql .= " ({$column}) ";
        }
        $insSql .= " values ";

        $valArr = [];
        foreach ($insertDatas as $ik=>$iv){
            $_vals = [];
            foreach ($iv as $iiv){
                $_vals[] = "'{$iiv}'";
            }
            $valArr[] = " (".implode(',',$_vals).") ";
        }

        $insSql .= implode(',',$valArr);

        $this->link->rawQuery($insSql);

        if(empty($this->link->getLastError())){
            LG::log('debug','/tmp/multi_insert.log')->info($this->link->getLastQuery());
            return true;
        }else{
            LG::log('debug','/tmp/multi_insert_err.log')->info($this->link->getLastQuery()."======Error info:".$this->link->getLastError());
            return false;
        }
    }


    /**
     *
     * 检查表是否存在
     *
     * @param $table
     * @date 2020/5/19 1:26 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function checkTable($table){
        $dbName = $this->getDBName();
        $chkSql = "select `TABLE_NAME` from `INFORMATION_SCHEMA`.`TABLES` ".
            " where `TABLE_SCHEMA`='{$dbName}' and `TABLE_NAME`='{$table}' ";
        $rlt = $this->link->query($chkSql);
        return $rlt;
    }

}
