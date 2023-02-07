<?php
/**
* LGHttp
*/

namespace LGCore\utils;
class LGHttp
{
    private static function request($method, $url, $pem, $params,$header=null){
        if (!in_array($method, array('GET', 'POST'))){
            throw new Exception('Method not allowed');
        }
        $ch = curl_init();
        if($header){//头信息
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }else{
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        
        if ($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        if ($pem) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); 
            curl_setopt($ch, CURLOPT_CAINFO, $pem);
        }
        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        // $file = fopen("/tmp/curl.log","a");
        // curl_setopt($ch, CURLOPT_STDERR, $file);
        // fclose($file);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
    }

    static function POST($url, $pem, $params=array(),$header=null)
    {
        return LGHttp::request('POST', $url, $pem, $params,$header);
    }
    
    static function GET($url, $pem, $params=array(),$header=null)
    {
        if($params){
            $url = $url . '?' . http_build_query($params);
        }
        return LGHttp::request('GET', $url, $pem, array(),$header);
    }
    
    /**
     * 文件上传请求(HTPP POST上传方式)
     * 
     * @param string[文件上传请求URL] $url
     * @param string[$_FILES的名称] $files_name
     * @param array[参数] $params
     * @param string[证书地址] $pem
     * @since File available since Version 1.0 2016-5-12
     * @author goen<goen88@163.com>
     * @return Array
     */
	static  function UPLOAD_FILES($url,$files_name, $params=array(),$pem=null){
		if(empty($url)||empty($files_name)){
			LG::rest(10030, array('alert_msg'=>'文件上传失败:缺少参数'));
			//return array('error'=>'文件上传失败:缺少参数','error_code'=>10009);
		}
        $data = array(
            //'upfile'=>'@'.realpath($path).";type=".$type.";filename=".$filename
        );
        $num = 1;
        $fileArr = $_FILES[$files_name];
        if(is_array($fileArr['name'])){
            $num = 0;
        	foreach ($fileArr['name'] as $ik=>$iv){
        		if(empty($fileArr['name'][$ik])) continue;
	        	if($fileArr['error'][$ik]>0){
	        		LG::rest(10030, array('alert_msg'=>'文件上传失败:上传文件有误或不完整'));
	        		//return array('error'=>'文件上传失败:上传文件有误或不完整','error_code'=>10030); 
	        	}
	        	$num++;
	        	//youyj:解决The usage of the @filename API for file uploading is deprecated问题
                //$data['upfile'.$num] = '@'.realpath($fileArr['tmp_name'][$ik]).";type=".$fileArr['type'][$ik].";filename=".$fileArr['name'][$ik];
        		$data['upfile'.$num] = new CURLFile(realpath($fileArr['tmp_name'][$ik]), $fileArr['type'][$ik], $fileArr['name'][$ik]);
        		
        	}
        }else{
        	if($fileArr['error']>0){
        		LG::rest(10030, array('alert_msg'=>'文件上传失败:上传文件有误或不完整'));
        		//return array('error'=>'文件上传失败:上传文件有误或不完整','error_code'=>10030); 
        	}
        	//youyj:解决The usage of the @filename API for file uploading is deprecated问题
            //$data['upfile'.$num] = '@'.realpath($fileArr['tmp_name']).";type=".$fileArr['type'].";filename=".$fileArr['name'];
        	$data['upfile'.$num] = new CURLFile(realpath($fileArr['tmp_name']), $fileArr['type'], $fileArr['name']);
        }
        if(!empty($params)){
        	$data = array_merge($data,$params);
        }
        $data['file_num'] = $num;
        $rlt =  LGHttp::request('POST', $url, $pem, $data);
        return $rlt;
   }
   
   
   /**
     * 单文件流上传请求（本地文件上传方式）
     * 
     * @param string[文件上传请求URL] $url
     * @param string[$_FILES的名称] $files_name
     * @param array[参数] $params
     * @param string[证书地址] $pem
     * @since File available since Version 1.0 2016-5-12
     * @author goen<goen88@163.com>
     * @return Array
     */
	static  function UPLOAD_FILE($url,$path,$params=null,$pem=null){
		if(empty($url)||empty($path)){
			LG::rest(10030, array('alert_msg'=>'文件上传失败:缺少参数'));
		}
		$type = mime_content_type($path);
    	$filename = basename($path);
    	//youyj:解决The usage of the @filename API for file uploading is deprecated问题
    	/**
        $data = array(
            'upfile1'=>'@'.realpath($path).";type=".$type.";filename=".$filename
        );
    	 */
        $data = array(
            'upfile1' => new CURLFile(realpath($path), $type, $filename)
        );
	 	if(!empty($params)){
        	$data = array_merge($data,$params);
        }
        $rlt =  LGHttp::request('POST', $url, $pem, $data);
        return $rlt;
   }
   
   /**
    * 文件上传请求(HTPP POST上传方式)
    *
    * @param string[文件上传请求URL] $url
    * @param string[$_FILES的名称] $files_name_arr
    * @param array[参数] $params
    * @param string[证书地址] $pem
    * @since File available since Version 1.0 2017-3-2
    * @author zhanglx<zhanglx@163.com>
    * @return Array
    */
   static  function API_UPLOAD_FILES($url,$file_name_arr, $params=array(),$pem=null){
       if(empty($url)||empty($file_name_arr)){
           LG::rest(10030, array('alert_msg'=>'文件上传失败:缺少参数'));
           //return array('error'=>'文件上传失败:缺少参数','error_code'=>10009);
       }
       $data = array(
           //'upfile'=>'@'.realpath($path).";type=".$type.";filename=".$filename
       );
       if(is_array($file_name_arr)){//需要上传的文件名称数组
           foreach ($file_name_arr as $key=>$val){
               if ($_FILES[$val]['error']>0)continue;
               $data[$val]=new CURLFile(realpath($_FILES[$val]['tmp_name']), $_FILES[$val]['type'], $_FILES[$val]['name']);
           }
       }else {//$file_name_arr不为数组时传所有$_FILES
           foreach ($_FILES as $key=>$val){
               
               if(is_array($val['error'])){//一个name包含图片
                   foreach ($val['error'] as $k1=>$v1){
                       if($v1>0) continue;
                       $data[$key."[{$k1}]"]=new CURLFile(realpath($val['tmp_name'][$k1]), $val['type'][$k1], $val['name'][$k1]);   
                   }
               }else {
                   if ($val['error']>0)continue;
                   $data[$key]=new CURLFile(realpath($val['tmp_name']), $val['type'], $val['name']);
               } 
           };
       }
       if(!empty($params)){
           $data = array_merge($data,$params);
       }
       $rlt =  LGHttp::request('POST', $url, $pem, $data);
       return $rlt;
   }
   
}

?>
