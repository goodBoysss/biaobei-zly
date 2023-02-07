<?php
/**
 * LGImage.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 图片基础处理类
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 4:33 PM
 */


namespace LGCore\image;


class LGImage
{

    /**
     *
     * 获取图片信息
     * @param strting $file
     * @date 2019/6/13 5:09 PM
     * @author goen<goen88@163.com>
     * @return array
     */
    public function imageInfo($file)
    {
        //文件大小
        $size=filesize($file);

        //原始文件名
        $filename=basename($file);

        //图片信息
        $imgsize = GetImageSize($file);

       return  [
            'width'=>$imgsize[0],
            'height'=>$imgsize[1],
            'type'=>$imgsize[2],
            'bits'=>$imgsize['bit1'],
            'mime'=>$imgsize['mime'],
            'size'=>$size,
            'filename'=>$filename,
        ];
    }


    /**
     * 下载文件
     *
     * @param string $down_name 下载文件名字
     * @param string $file  下载文件路径
     * @date 2019/6/13 5:22 PM
     * @author goen<goen88@163.com>
     * @return int
     * @throws \Exception
     */
    function dowload($down_name,$file)
    {
        $file_path = $file;

        //判断要下载的文件是否存在
        if(!is_file($file_path))
        {
            throw new \Exception("对不起,你要下载的文件不存在。");
        }

        $file_size=filesize($file_path);

        header("Pragma: no-cache");
        header("Expires: -1" ); // set expiration time
        header( "Cache-Component: must-revalidate, post-check=0, pre-check=0" );
        header( "Cache-Control: no-cache, must-revalidate");
        header( "Content-type:application/download");
        header( "Content-Length: $file_size"  );
        header( "Content-Disposition: attachment; filename=\"image_".$down_name."\"");
        header( "Content-Transfer-Encoding: binary" );
        readfile( $file_path );

        return true;
    }


    /**
     *
     * 通过命令方式剪切图片
     * @param string $origpic 源文件地址
     * @param string $destpic 目标文件地址
     * @param int $width    宽度
     * @param int $height   高度
     * @param int $waterflag 水印标标识
     * @param string $waterstr 水印字符
     * @date 2019/6/13 6:34 PM
     * @author goen<goen88@163.com>
     */
    public function cutByShell($origpic,$destpic,$width,$height,$waterflag=0,$waterstr='LGFramework2')
    {

        $cmdtmb = "/usr/bin/convert -size ".$width."x".$height;
        $cmdtmb .= " -resize ".$width."x".$height." +profile '*'  ";
        //$cmdtmb .= " -border 60x60 -bordercolor '#000000' ".
        $cmdtmb .= $origpic." ".$destpic." 2>&1";
        shell_exec($cmdtmb);

        //添加水印
        if($waterflag==1){
            $picture_info = getimagesize($destpic);
            $WIDTH =  intval($picture_info[0]);
            $HEIGHT = intval($picture_info[1]);
            $WIDTH =  $WIDTH/2-100;
            $HEIGHT = $HEIGHT/2+10;
            $cmdtmb = "/usr/bin/convert -font helvetica -fill '#f0f0f0' -pointsize 36 ";
            $cmdtmb .= " -draw 'text $WIDTH,$HEIGHT \" $waterstr \"' ";
            $cmdtmb .= $destpic." ".$destpic." 2>&1";
            shell_exec($cmdtmb);
        }
    }


    /**
     *
     * 通过命令把图片剪切成方形
     * @param string $origpic 原始图片地址
     * @param string $destpic 目标图片地址
     * @param int $size 目标大小
     * @date 2019/6/13 6:36 PM
     * @author goen<goen88@163.com>
     */
    public function cutToSquareByShell($origpic,$destpic,$size)
    {
        $imgInfo = $this->imageInfo($origpic);
        $width = $imgInfo['width'];
        $height = $imgInfo['height'];

        if ($width > $height)
        {
            $max = $width;
            $crop=($height*$max)/$width;
            $left=($max-$crop)/2;
            $top=0;
            $syssqu="/usr/bin/convert -crop ".$crop."x".$crop."+".$left."+".$top." ".$origpic." ".$destpic." 2>&1";
        }
        else if ($height > $width)
        {
            $max = $height;
            $crop=($width*$max)/$height;
            $left=0;
            $top=($max-$crop)/2;
            $syssqu="/usr/bin/convert -crop ".$crop."x".$crop."+".$left."+".$top." ".$origpic." ".$destpic." 2>&1";
        }
        else
        {
            $syssqu="/usr/bin/convert -size ".$size."x".$size." -resize ".$size."x".$size." ".$origpic." ".$destpic." 2>&1";
        }

        $retrs5=shell_exec($syssqu);
        if ($width<>$height) {
            $syssiz="/usr/bin/mogrify -size ".$size."x".$size." -resize ".$size."x".$size." ".$destpic;
            $retrs6=shell_exec($syssiz);
        }
    }

    /**
     * 通过命令方式剪切图片
     * @param string $origpic  原始图片地址
     * @param string $destpic 目标图片地址
     * @param $width 目标宽度
     * @date 2019/6/13 6:39 PM
     * @author goen<goen88@163.com>
     */
    public function cutWithWidthByShell($origpic,$destpic,$width)
    {
        $cmdtmb="/usr/bin/convert -resize ".$width." +profile '*' ".$origpic." ".$destpic." 2>&1";
        shell_exec($cmdtmb);
    }



    /**
     *
     * 通过GD库方式剪切图片，支持区域剪切
     *
     * @param string $srcFile 原始图片路径
     * @param string $dstFile 保存图片路径
     * @param int $dstW 存储图片宽度
     * @param int $dstH 存储图片的高度
     * @param int $webW 图片在网页中的宽度
     * @param int $webH 图片在网页中的高度
     * @param int $selectW 选择框的宽度
     * @param int $selectH 选择框的高度
     * @param int $x 选择点的X坐标
     * @param int $y 选择点的Y坐标
     * @param int $quaity
     * @date ${dt}
     * @author goen<goen88@163.com>
     * @return bool
     */
    function imageCropper($srcFile,$dstFile,$dstW,$dstH,$webW=0,$webH=0,$selectW=0,$selectH=0,$x=0,$y=0,$quaity=92)
    {
        $data = GetImageSize($srcFile);
        switch($data[2])
        {
            case 1:
                $im=@ImageCreateFromGIF($srcFile);
                break;
            case 2:
                $im=@ImageCreateFromJPEG($srcFile);
                break;
            case 3:
                $im=@ImageCreateFromPNG($srcFile);
                break;
        }

        if(!$im) return False;
        $srcW=ImageSX($im)?ImageSX($im):0;
        $srcH=ImageSY($im)?ImageSY($im):0;

        //如果原图小于当前要截图的大小，直接拷贝
        if($srcW<$dstW&&$srcH<$dstH){
            $dstW = $srcW;
            $dstH = $srcH;
        }


        if(!empty($selectW)&&intval($selectW)!=0){
            $ratioWSW = doubleval($srcW/$webW); //原图宽和web中宽比率
            $ratioHSH = doubleval($srcH/$webH); //原图高和web中高比率

            $realX = round($ratioWSW*$x); //相对原图的X坐标
            $realY = round($ratioHSH*$y); //真是图片的Y坐标
            $realW = round($ratioWSW*$selectW); //相对原图长度
            $realH = round($ratioHSH*$selectH); //真是图片宽度
            if($realX+$realW>$srcW){
                $realX = ($srcW-$realW)>0?($srcW-$realW):0;
            }
            if($realY+$realH>$srcH){
                $realY = ($srcH-$realH)>0?$srcH-$realH:0;
            }
        }else{
            $realX= 0;
            $realY = 0;
            $realW = $srcW;
            $realH = $srcH;
        }

        //改变后的图象的比例
        if($dstH!=0)$resize_ratio = $dstW/$dstH; else $resize_ratio =1;
        //实际图象的比例
        if($realH!=0)$ratio = $realW/$realH; else $ratio=1;

        if($ratio==$resize_ratio)
        {
            $newimg = imagecreatetruecolor($dstW,$dstH);
            $white = ImageColorAllocate($newimg,255,255,255);
            imagefill($newimg, 0, 0, $white); //填充背景色
            //ImageCopyResized($newimg, $im, 0, 0, $realX, $realY, $dstW,$dstH/$resize_ratio,$realW,$realH);
            imagecopyresampled($newimg, $im, 0, 0, $realX, $realY, $dstW,$dstH,$realW,$realH);
            ImageJpeg($newimg,$dstFile,$quaity);
            imagedestroy($newimg);
        }
        if($ratio>$resize_ratio)
        {
            $newimg = imagecreatetruecolor($dstW,$realH*$dstW/$realW);
            $white = ImageColorAllocate($newimg,255,255,255);
            imagefill($newimg, 0, 0, $white); //填充背景色
            //ImageCopyResized($newimg, $im, 0, 0, $realX, $realY, $dstW,$dstH/$resize_ratio,$realW,$realH);
            imagecopyresampled($newimg, $im, 0, 0, $realX, $realY, $dstW,$realH*$dstW/$realW,$realW,$realH);
            ImageJpeg($newimg,$dstFile,$quaity);
            imagedestroy($newimg);
        }
        if($ratio<$resize_ratio)
        {
            $newimg = imagecreatetruecolor($realW*$dstH/$realH,$dstH);
            $white = ImageColorAllocate($newimg,255,255,255);
            imagefill($newimg, 0, 0, $white); //填充背景色
            //ImageCopyResized($newimg, $im, 0, 0, $realX, $realY, $dstW*$resize_ratio,$dstH,$realW,$realH);
            imagecopyresampled($newimg, $im, 0, 0, $realX, $realY, $realW*$dstH/$realH,$dstH,$realW,$realH);
            ImageJpeg($newimg,$dstFile,$quaity);
            imagedestroy($newimg);
        }
    }

    /**
     *
     * GD方式通过宽度缩放
     * @param string  $src_img 源路径
     * @param string  $dst_w 目标宽度
     * @param null|string $dst_img 目标路径（不存在则直接输出）
     * @param int $quality 图片品质
     * @date 2019/6/13 6:44 PM
     * @author goen<goen88@163.com>
     */
    public function imgResizedByWidth($src_img,$dst_w,$dst_img=null,$quality=100){
        ob_clean();
        // 缩略图尺寸
        list($width, $height) = getimagesize($src_img);
        // 缩略图比例
        $percent = $dst_w/$width;
        $newwidth = intval($width * $percent);
        $newheight = intval($height * $percent);
        // 加载图像
        $data = GetImageSize($src_img);
        switch($data[2])
        {
            case 1:
                $src_im = @ImageCreateFromGIF($src_img);
                break;
            case 2:
                $src_im=@ImageCreateFromJPEG($src_img);
                break;
            case 3:
                $src_im=@ImageCreateFromPNG($src_img);
                break;
        }
        $dst_im = imagecreatetruecolor($newwidth, $newheight);
        $ret = imagecopyresampled($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if($dst_img){
            //输出缩小后的图像
            header("Content-type:image/jpeg");
            imagejpeg($dst_im,null,$quality);
        }else{
            ImageJpeg($dst_im,$dst_img,$quality);
        }
        imagedestroy($dst_im);
    }
}