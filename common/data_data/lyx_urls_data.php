<?php
/**
 * lyx_urls_data.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/5/19
 * @version: v2.0.0
 * @since: 2020/5/19 8:47 AM
 */

namespace LGCommon\data_data;


use LGCore\base\LG;

class lyx_urls_data extends  lg_base_data{


    /**
     * 表名称
     * @var string
     */
    protected $table = 'lyx_urls';


    public function __construct()
    {
        parent::__construct();
    }


    //根据url的sha1值获取数据
    public function select_row_by_sha1($sha1,$clumns="*"){
        $this->link->where ("sha1", $sha1);
        $rlt = $this->link->getOne ($this->table,$clumns);
        return $rlt;
    }


    /**
     *
     * 根据表名创建表
     *
     * @param $table
     * @date 2020/5/19 1:25 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function createTable($table){
        $tabSql = "
            CREATE TABLE  IF NOT exists `{$table}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `sha1` char(40) COLLATE utf8_unicode_ci NOT NULL,
              `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `create_at` int(11) NOT NULL,
              `creator` int(11) unsigned NOT NULL DEFAULT '0',
              `count` int(11) NOT NULL DEFAULT '0',
              `status` tinyint(1) NOT NULL DEFAULT '1',
              `expire` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `sha1` (`sha1`),
              KEY `create_at` (`create_at`),
              KEY `creator` (`creator`),
              KEY `count` (`count`),
              KEY `status` (`status`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='URL地址映射表';
        ";
        try{
            $this->link->rawQuery($tabSql);
            return true;
        }catch (\Exception $e){
            //LG::log('debug','/tmp/table_create.log')->info("======Error info:".$this->link->getLastError());
            return false;
        }
    }


    /**
     *
     * 更新点击访问计数
     * @param $id
     * @date 2020/6/28 3:51 下午
     * @return int|string
     * @throws \Exception
     * @author goen<goen88@163.com>
     */
    public function update_hits_by_id($id){
        $this->link->where ('id', $id);
        $row_rec = [
            'count' => $this->link->inc(1),
        ];
        if ($this->link->update($this->table, $row_rec)) {
            return $this->link->count;
        }else{
            return 0;
        }
    }



}