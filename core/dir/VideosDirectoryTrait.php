<?php
/**
 * VideosDirectoryTrait.php
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

trait VideosDirectoryTrait{

    //用户原始图片地址
    private  function get_video_orig()
    {
        return "video/orig";
    }

    //超高清
    private function get_video_hdr()
    {
        return "video/hdr";
    }

    //1080p（蓝光）
    private function get_video_1080p()
    {
        return "video/1080p";
    }

    //高清
    private function get_video_720p()
    {
        return "video/720p";
    }

    //标清
    private function get_video_480P()
    {
        return "video/480P";
    }

    public function get_full_video_orig($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_video_orig($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_video_hdr($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_video_hdr($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    public function get_full_video_1080p($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_video_1080p($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    function get_full_video_720p($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_video_720p($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }

    function get_full_video_540p($id,$pathtype,$ifcreate)
    {
        $basepath = $this->get_video_540p($id);
        $spd = new \LGCore\dir\LGDirectory();
        $picdir = $spd->get_full_path($basepath,$id,$pathtype,$ifcreate,$this->disk_base,$this->web_base);
        return $picdir;
    }
}