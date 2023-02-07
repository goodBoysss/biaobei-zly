<?php
 /**
 * 七牛云储存操作类(这里基于老API的操作，此类需要重新基于Composer重新对接)
 * 
 * @copyright 2014 by gaorunqiao.ltd
 * @since File available since Version 1.0 2014-10-7
 * @author goen<goen88@163.com>
 *
 */

namespace LGCommon\comments;


/**
 * Class QiniuStorage
 * @package LGCommon\comments
 * @deprecated
 */
class QiniuStorage {
   
	var $bucket; //品牌店铺用户ID
	var $domain; //图片外链地址
	public function __construct($bucket=null,$domain=null){
	   if($bucket!=null){
	   		$this->bucket = $bucket;
	   }else{
	   		$this->bucket = QINIU_BUCKET;
	   }
	   if($domain!=null){
	   		$this->domain = $domain;
	   }else{
	   		$this->domain = QINIU_DOMAIN;
	   }
    }
    
   /**
    * 
    * 获取单个文件信息
    * @param String $file_path
    * @return array
    * @copyright 2014 by gaorunqiao.ltd
    * @since File available since Version 1.0 2014-10-8
    * @author goen<goen88@163.com>
    */
    public function info($file_path){
		$client = new Qiniu_MacHttpClient(null);
		list($ret, $err) = Qiniu_RS_Stat($client, $this->bucket, $file_path);
		//echo "\n\n====> Qiniu_RS_Stat result: \n";
		if ($err !== null) {
		    return  null;
		} else {
		   return $ret;
		}
    }
    
    /**
     * 文件复制
     * 
     * @param String $src_file_name
     * @param String $dest_file_name
     * @copyright 2014 by gaorunqiao.ltd
     * @since File available since Version 1.0 2014-10-8
     * @author goen<goen88@163.com>
     * @return boolean
     */
    public function copy($src_file_name,$dest_file_name){
		$client = new Qiniu_MacHttpClient(null);
		$err = Qiniu_RS_Copy($client, $this->bucket, $src_file_name, $this->bucket, $dest_file_name);
		//echo "\n\n====> Qiniu_RS_Copy result: \n";
		if ($err !== null) {
		    //var_dump($err);
		    return false;
		} else {
		    //echo "Success! \n";
		    return true;
		}
    }
    
    /**
     * 
     * 单个文件移动
     * 
     * @param String $src_file_name
     * @param String $dest_file_name
     * @copyright 2014 by gaorunqiao.ltd
     * @since File available since Version 1.0 2014-10-8
     * @author goen<goen88@163.com>
     * @return Boolean
     */
    public function move($src_file_name,$dest_file_name){
    	
		
    	$client = new Qiniu_MacHttpClient(null);
		$err = Qiniu_RS_Move($client, $this->bucket, $src_file_name, $this->bucket, $dest_file_name);
		//echo "\n\n====> Qiniu_RS_Move result: \n";
		if ($err !== null) {
		    //var_dump($err);
		    return false;
		} else {
		    //echo "Success! \n";
		    return true;
		}
    }
    
	/**
	 * 
	 * 删除单个文件
	 * 
	 * @param String $file_name
	 * @copyright 2014 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2014-10-8
	 * @author goen<goen88@163.com>
	 * @return Boolean
	 */
    public function delete($file_name){
    	$client = new Qiniu_MacHttpClient(null);
		$err = Qiniu_RS_Delete($client, $this->bucket, $file_name);
		//echo "\n\n====> Qiniu_RS_Delete result: \n";
		if ($err !== null) {
		    //var_dump($err);
		    return false;
		} else {
		    //echo "Success! \n";
		    return true;
		}
    }
    
    

    /**
     * 上传单个文件
     * @param $src_file 上传文件
     * @param $save_path 文件存储路径
     * @return Boolean
     */
    public function uploadFile($file,$save_path){
    	
		$putPolicy = new Qiniu_RS_PutPolicy($this->bucket);
		$upToken = $putPolicy->Token(null);
		$putExtra = new Qiniu_PutExtra();
		$putExtra->Crc32 = 1;
		list($ret, $err) = Qiniu_PutFile($upToken, $save_path, $file, $putExtra);
		//echo "\n\n====> Qiniu_PutFile result: \n";
		if ($err !== null) {
			//var_dump($err);
			return false;
		}else {
			//var_dump($ret);
			return true;
		}
    }
    
     /**
     * 上传文本内容
     * @param $txt 上传文件
     * @param $save_path 文件存储路径
     * @return Boolean
     */
    public function uploadTxt($txt,$save_path){
	    	
			$putPolicy = new Qiniu_RS_PutPolicy($this->bucket);
			$upToken = $putPolicy->Token(null);
			list($ret, $err) = Qiniu_Put($upToken, $save_path, $txt, null);
			//echo "\n\n====> Qiniu_Put result: \n";
			if ($err !== null) {
			    //var_dump($err);
			    return false;
			}else {
			    //var_dump($ret);
			    return true;
			}
    }
    
    /**
     * 
     * 获取图片EXIF信息
     * @param $file_path 文件路径（文件存储的相对路径）
     * 
     * @copyright 2014 by gaorunqiao.ltd
     * @since File available since Version 1.0 2014-10-8
     * @author goen88<goen88@163.com>
     * @return multipe
     */
    public function exif($file_path,$type=null){
		//生成baseUrl
		$baseUrl = Qiniu_RS_MakeBaseUrl($this->domain, $file_path);
		
		//生成fopUrl
		$imgExif = new Qiniu_Exif;
		$imgExifUrl = $imgExif->MakeRequest($baseUrl);
		
		//对fopUrl 进行签名，生成privateUrl。 公有bucket 此步可以省去。
		$getPolicy = new Qiniu_RS_GetPolicy();
		$imgExifPrivateUrl = $getPolicy->MakeRequest($imgExifUrl, null);
		//echo "====> imageView privateUrl: \n";
		//echo $imgExifPrivateUrl . "\n";
		if($type=='json'){
			$exif = ILCHttp::GET($imgExifPrivateUrl);
			return json_encode($exif);
		}else if($type=='array'){
			$exif = ILCHttp::GET($imgExifPrivateUrl);
			$exif = json_encode($exif);
			return json_decode($exif,true);
		}else{ //返回链接
			return $imgExifPrivateUrl;
		}
    }
 
    /**
     * 
     * 
     * 
     * @param string $file_name
     * @param int $width
     * @param int $height
     * @copyright 2014 by gaorunqiao.ltd
     * @since File available since Version 1.0 2014-10-8
     * @author goen<goen88@163.com>
     * @return String
     */
    public function view($file_name,$width=null,$height=null){
		//$baseUrl 就是您要访问资源的地址
		$baseUrl = Qiniu_RS_MakeBaseUrl($this->domain, $file_name);
		$getPolicy = new Qiniu_RS_GetPolicy();
		$imgView = new Qiniu_ImageView;
		$imgView->Mode = 1;
		$imgView->Width = $width?$width:60;
		$imgView->Height = $height?$height:60;
		
		//生成fopUrl
		$imgViewUrl = $imgView->MakeRequest($baseUrl);
		
		//对fopUrl 进行签名，生成privateUrl。 公有bucket 此步可以省去。
		$imgViewPrivateUrl = $getPolicy->MakeRequest($imgViewUrl, null);
		return $imgViewPrivateUrl;
    }
}
?>
