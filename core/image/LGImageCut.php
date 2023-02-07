<?php
/**
 * LGImageCut.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 *        图片剪切类：缩略，裁剪，圆角，倾斜
 *        image_cut("原始图片地址","目标图片地址","处理后的宽度", "处理后的高度","压缩品质", "是否裁剪","背景颜色","圆角度数", "倾斜度");
 * @author: goen<goen88@163.com>
 * @date: 2019/6/13
 * @version: v2.0.0
 * @since: 2019/6/13 3:30 PM
 *
 * @example
 *    $img_file = 'src.png';
 *    $dest_file = "dest.png";
 *    $image = new LGImageCut($img_file,$dest_file,"200","200",1);
 *
 */


namespace LGCore\image;


class LGImageCut
{
    //图片类型
    protected $type;
    //实际宽度
    protected $width;
    //实际高度
    protected $height;
    //改变后的宽度
    protected $resize_width;
    //改变后的高度
    protected $resize_height;
    //图片背景
    protected $backcolor;
    //圆角度数
    protected $corner_radius;
    //是否裁图
    protected $cut;
    //源图象
    protected $srcimg;
    //目标图象地址
    protected $dstimg;
    //图片质量
    protected $quality;
    //图片对象
    protected $im;
    //旋转角度
    protected $angle;

    /**
     * LGImageCut constructor.
     * @param string    $img            原图像
     * @param string    $dstimg         目标地址
     * @param int       $wid            图像目标宽度
     * @param int       $hei            图像目标高度
     * @param int       $quality
     * @param int       $cut            是否裁图
     * @param string    $backcolor      背景颜色
     * @param int       $corner_radius  边角弧度
     * @param int       $angle          旋转角度
     */
    public function __construct($img, $dstimg, $wid, $hei,$quality=90,$cut=1,$backcolor="ffffff",$corner_radius=3, $angle=0)
    {

        $this->quality = $quality;
        $this->srcimg = $img;
        $this->resize_width = $wid;
        $this->resize_height = $hei;
        $this->cut = $cut;
        $this->corner_radius = $corner_radius;
        $this->angle = $angle;
        $this->backcolor = $backcolor;
        //图片的类型
        //$this->type = substr(strrchr($this->srcimg,"."),1);

        //初始化图象
        $this->initImg();
        //目标图象地址
        $this ->dstimg = $dstimg;
        //--
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);

        //生成图象
        $this->createNewimg();
        ImageDestroy ($this->im);
    }


    /**
     *
     * 生成新的图像
     *
     * @date 2019/6/13 4:06 PM
     * @author goen<goen88@163.com>
     */
    private function createNewimg()
    {
        //改变后的图象的比例
        $resize_ratio = ($this->resize_width)/($this->resize_height);
        //实际图象的比例
        $ratio = ($this->width)/($this->height);
        if(($this->cut)=="1")
            //裁图
        {
            if($ratio>=$resize_ratio) //高度优先
            {
                $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                ImageCopyResized($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
                $tmp = $this->roundedCorner($newimg);
                ImageJpeg($tmp,$this->dstimg,$this->quality);
            }
            if($ratio<$resize_ratio)//宽度优先
            {
                $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                ImageCopyResized($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
                $tmp = $this->roundedCorner($newimg,$this->resize_width);
                ImageJpeg ($tmp,$this->dstimg,$this->quality);
            }
        }
        else{ //不裁图
            if($ratio>=$resize_ratio)
            {
                $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
                ImageCopyResized($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
                ImageJpeg($newimg,$this->dstimg);
            }
            if($ratio<$resize_ratio)
            {
                $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
                ImageCopyResized($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
                ImageJpeg($newimg,$this->dstimg,$this->quality);
            }
        }
    }

    /**
     *
     * 根据图片类型不同生成图像
     *
     * @date 2019/6/13 4:07 PM
     * @author goen<goen88@163.com>
     */
    public function initImg()
    {
        $data = GetImageSize($this->srcimg);
        switch($data[2])
        {
            case 1:
                $this->im=@ImageCreateFromGIF($this->srcimg);
                break;
            case 2:
                $this->im=@ImageCreateFromJPEG($this->srcimg);
                break;
            case 3:
                $this->im=@ImageCreateFromPNG($this->srcimg);
                break;
        }
    }

    /**
     *
     * 处理圆角
     * @param $image
     * @date ${dt}
     * @author goen<goen88@163.com>
     * @return mixed
     */
    public  function roundedCorner($image)
    {
        //$image_file = "C:/wamp/www/test/1.jpg";//$_GET['src'];
        $corner_radius =  $this->corner_radius; // 圆角的大小默认为10
        $topleft =  true; // 左上角
        $bottomleft = true; // 左下角
        $bottomright = true; // 右下角
        $topright = true; // 左上角
        $backcolor= "ffffff";//背景
        $forecolor= "ffffff";//前景
        $endsize=$corner_radius;
        $startsize=$endsize*3-1;
        $arcsize=$startsize*2+1;
        $size[0] = imagesx($image);
        $size[1] = imagesy($image);
        $white = 255;

        // Top-left corner
        $background = imagecreatetruecolor($size[0],$size[1]);
        imagecopymerge($background, $image, 0, 0, 0, 0, $size[0], $size[1], 100);
        $startx=$size[0]*2-1;
        $starty=$size[1]*2-1;
        $im_temp = imagecreatetruecolor($startx,$starty);
        ImageCopyResized($im_temp, $background, 0, 0, 0, 0, $startx, $starty, $size[0], $size[1]);
        $bg = imagecolorallocate($im_temp, hexdec(substr($backcolor,0,2)),hexdec(substr($backcolor,2,2)),hexdec(substr($backcolor,4,2)));
        $fg = imagecolorallocate($im_temp, hexdec(substr($forecolor,0,2)),hexdec(substr($forecolor,2,2)),hexdec(substr($forecolor,4,2)));

        if ($topleft == true) {
            imagearc($im_temp, $startsize, $startsize, $arcsize, $arcsize, 180,270,$bg);
            imagefilltoborder($im_temp,0,0,$bg,$bg);
        }

        // Bottom-left corner
        if ($bottomleft == true) {
            imagearc($im_temp, $startsize, $starty-$startsize,$arcsize, $arcsize, 90,180,$bg);
            imagefilltoborder($im_temp,0,$starty,$bg,$bg);
        }

        // Bottom-right corner
        if ($bottomright == true) {
            imagearc($im_temp, $startx-$startsize, $starty-$startsize,$arcsize, $arcsize, 0,90,$bg);
            imagefilltoborder($im_temp,$startx,$starty,$bg,$bg);
        }

        // Top-right corner
        if ($topright == true) {
            imagearc($im_temp, $startx-$startsize, $startsize,$arcsize, $arcsize, 270,360,$bg);
            imagefilltoborder($im_temp,$startx,0,$bg,$bg);
        }
        //$newimage = imagecreatetruecolor($size[0],$size[1]);
        ImageCopyResized($image, $im_temp, 0, 0, 0, 0, $size[0],$size[1],$startx, $starty);

        //图片旋转
        //$image = imagerotate($image, $this->angle, 0);
        return $image;
    }
}