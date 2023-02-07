<?php
/**
 * LGDirectory.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 系统目录生成规则类
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 11:38 AM
 */


namespace LGCore\dir;


class LGDirectory
{

    public function __construct()
    {

    }

    /**
     * 根据数字ID自动分割目录
     *
     * @param $id int
     * @date 2019/6/13 12:04 PM
     * @author goen<goen88@163.com>
     * @return int|string
     *
     * @example
     *   $dir = new LGDirectory();
     *   $str = $dir->get_sub_path(10000901); // 输出：3/10/000
     *
     */
    public function get_sub_path($id)
    {
        $arr = str_split(strrev($id), 3);
        $path = sizeof($arr);
        array_shift($arr);
        $str = implode("/",$arr);
        if ($id<1000){
            $path = '1';
        } else{
            $path = $path."/".strrev($str);
        }
        return $path;
    }


    /**
     *
     * 设置实体目录，不存在自动创建
     * @param $dir string
     * @date ${dt}
     * @author goen<goen88@163.com>
     */
    function set_sub_path($dir)
    {
        if (!is_dir($dir))
        {
            mkdir($dir,0777,true);
        }
    }

    /**
     * 获取系统目录全路径
     *
     * @param $basepath string 基础路径
     * @param $id int  数字ID
     * @param $pathtype string 路径类型：sys-系统路径;web-网络路径
     * @param $ifcreate int  是否自动分割
     * @param $diskbase string 磁盘目录
     * @param $webbase string 网路路径
     * @date 2019/6/13 12:16 PM
     * @author goen<goen88@163.com>
     * @return string
     */
    public function get_full_path($basepath,$id,$pathtype,$ifcreate,$diskbase,$webbase)
    {
        if ($ifcreate == 1) //是否根据ID自动分割文件夹
        {
            $subpath = $this->get_sub_path($id);
            $full_path = $basepath."/".$subpath;
            $this->set_sub_path($diskbase."/".$full_path);
        }else{
            $full_path = $basepath;
        }

        $path = $full_path."/";

        //根据返回类型作返回
        if($pathtype=="sys")
        {
            return $diskbase."/".$path;
        }
        else
        {
            return $webbase."/".$path;
        }
    }
}