<?php
/**
 * LGCommonDirectory.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 系统目录基类
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 11:11 AM
 */


namespace LGCore\dir;


class LGCommonDirectory
{

    /**
     * 硬盘实体目录
     * @var string
     */
    protected $disk_base;

    /**
     * web地址
     * @var string
     */
    protected $web_base;

    public function __construct($diskBase='',$webBase='')
    {
        $this->disk_base = !empty($diskBase)?$diskBase:LG_WEB_ROOT.'/ware';
        $this->web_base = !empty($webBase)?$webBase:'';
    }



    use ImagesDirectoryTrait,VideosDirectoryTrait,AudiosDirectoryTrait,MultiDirectoryTrait;

    //

    /**
     * 根据时间获取上传APP文件目录
     *
     * @param $pathname
     * @param string $pathtype
     * @date ${dt}
     * @author goen<goen88@163.com>
     * @return string
     */
    public function get_full_upload_date_path($pathname,$pathtype='sys'){
        $save_path = $this->disk_base."/upload" . "/";
        $save_url = $this->web_base."/upload" . "/";
        if (!file_exists($save_path)) {
            mkdir($save_path,0777,true);
            chmod($save_path, 0777);
        }

        $save_path .= $pathname."/" ;
        $save_url .= $pathname."/" ;
        if (!file_exists($save_path)) {
            mkdir($save_path,0777,true);
            chmod($save_path, 0777);
        }

        $ymd = date("Ymd");
        $save_path .= $ymd."/" ;
        $save_url .= $ymd."/" ;
        if (!file_exists($save_path)) {
            mkdir($save_path,0777,true);
            chmod($save_path, 0777);
        }
        if($pathtype=='web'){
            return $save_url;
        }else{
            return  $save_path;
        }
    }


}