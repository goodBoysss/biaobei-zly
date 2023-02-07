<?php
/**
 * CommonImageMake.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 图片剪切默认组件
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 6:54 PM
 */


namespace LGCommon\comments;


use LGCore\image\LGImage;

class CommonImageMake
{
    const  IMG_BIG=1024;
    const  IMG_MID=640;
    const  IMG_TMB=320;
    const  IMG_ICON=98;

    public function __construct()
    {
    }


    /**
     * 生成通用图片缩略图
     * @param $img_path 图片地址
     * @param $pid 图片ID，在create=1有效
     * @param int $ow 原始图宽度
     * @param int $oh 原始图高度
     * @param int $w  目标宽度
     * @param int $h  目标高度
     * @param int $x1 剪切起始X坐标
     * @param int $y1 剪切起始Y坐标
     * @date 2019/6/13 7:07 PM
     * @author goen<goen88@163.com>
     */
    public  function imagesCropper($img_path,$pid,$ow=0,$oh=0,$w=0,$h=0,$x1=0,$y1=0){
        $dir = new CommonDirectory();
        $filename = uniqid().'.jpg';
        $bigpic=$dir->get_full_images_big($pid,'sys',"1").$filename;
        $midpic=$dir->get_full_images_mid($pid,'sys',"1").$filename;
        $tmbpic=$dir->get_full_images_tmb($pid,'sys',"1").$filename;

        $imgModObj = new LGImage();
        $imgModObj->imageCropper($img_path,$bigpic,self::IMG_BIG,self::IMG_BIG,$ow,$oh,$w,$h,$x1,$y1);
        $imgModObj->imageCropper($img_path,$midpic,self::IMG_MID,self::IMG_MID,$ow,$oh,$w,$h,$x1,$y1);
        $imgModObj->imageCropper($img_path,$tmbpic,self::IMG_TMB,self::IMG_TMB,$ow,$oh,$w,$h,$x1,$y1);

//		    //=======七牛云存储：上传图到七牛========
//	      $QNSObj = new QiniuStorage();
//		  $QNSObj->delete(ltrim($hpd->get_full_orig($pid,'web',"1"),'/'));
//		  $QNSObj->delete(ltrim($hpd->get_full_big($pid,'web',"1"),'/'));
//		  $QNSObj->delete(ltrim($hpd->get_full_mid($pid,'web',"1"),'/'));
//		  $QNSObj->delete(ltrim($hpd->get_full_tmb($pid,'web',"1"),'/'));
//
//		  $QNSObj->uploadFile($img_path,ltrim($hpd->get_full_orig($pid,'web',"1"),'/'));
//		  $QNSObj->uploadFile($bigpic,ltrim($hpd->get_full_big($pid,'web',"1"),'/'));
//		  $QNSObj->uploadFile($midpic,ltrim($hpd->get_full_mid($pid,'web',"1"),'/'));
//		  $QNSObj->uploadFile($tmbpic,ltrim($hpd->get_full_tmb($pid,'web',"1"),'/'));
    }


}