<?php
/**
 * MultiDirectoryTrait.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 12:27 PM
 */

namespace LGCore\dir;

trait MultiDirectoryTrait{

    //用户原始图片地址
    private  function get_multi_orig()
    {
        return "multi";
    }

    public function get_full_multi($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_multi_orig($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }
}