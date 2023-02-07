<?php
/**
 * AudiosDirectoryTrait.php
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

trait AudiosDirectoryTrait{

    //用户原始图片地址
    private  function get_audio_orig()
    {
        return "audio/orig";
    }

    //无损品质（sq）
    private function get_audio_sq()
    {
        return "audio/sq";
    }

    //高品质（hq）
    private function get_audio_hq()
    {
        return "audio/hq";
    }

    //标准品质(stq)
    private function get_audio_stq()
    {
        return "audio/stq";
    }

    public function get_full_audio_orig($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_audio_orig($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_audio_sq($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_audio_sq($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_audio_hq($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_audio_hq($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    function get_full_audio_stq($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_audio_stq($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

}