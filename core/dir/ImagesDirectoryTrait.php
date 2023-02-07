<?php
/**
 * ImagesDirectoryTrait.php
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

trait ImagesDirectoryTrait{

    //用户原始图片地址
    private  function get_images_orig()
    {
        return "images/orig";
    }

    //用户大图片地址
    private function get_images_big()
    {
        return "images/big";
    }

    //用户中图片地址
    private function get_images_mid()
    {
        return "images/mid";
    }

    //用户小图图片地址
    private function get_images_tmb()
    {
        return "images/tmb";
    }

    public function get_full_images_orig($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_images_orig($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_images_big($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_images_big($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_images_mid($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_images_mid($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    function get_full_images_tmb($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_images_tmb($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }
}