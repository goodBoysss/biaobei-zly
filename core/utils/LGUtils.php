<?php

/**
 * 系统工具类
 * 
 * @author goen
 *
 */
namespace LGCore\utils;
class LGUtils{
	public static function is_image($nopathfile)
	{
		     $arr_imgs=array("jpg","bmp","tif","tiff","png","jpeg");
		     
			 $arrtype=explode(".",$nopathfile);
			 $fileext=strtolower($arrtype[sizeof($arrtype)-1]); 
			 //$fileext=substr($nopathfile,-3);
			 //$fileext=strtolower($fileext);
			 if (in_array($fileext,$arr_imgs))
		     {
				   return 1;
			 }else{
				   return 0;
			 }
	}
	
	
	public static function get_size_auto($size){
		$size = intval($size);
		if($size<1024){
			return $size.'B';
		}else if($size>=1024&&$size<1048576){
			return round($size/1024,2).'KB';
		}else if($size>=1048576&&$size<1024*1024*1024){
			return round($size/(1024*1024),2).'MB';
		}else{
			return round($size/(1024*1024*1024),2).'GB';
		}
	}
	
	
	
	public static function digit2image($digit)
	{
		  $img_str = "";
		  $bai = ($digit-($digit % 100)) / 100;
		  if ($bai != 0)
		  {
			    $img_str.="<img src='/images/".$bai.".png'>";
		  }
		  
		  $shi_1 = $digit-($bai*100);
		  
		  $shi = ($shi_1-($shi_1 % 10)) / 10;
		  if ($shi != 0)
		  {
			    $img_str.="<img src='/images/".$shi.".png'>";
		  }
		  
		  $ge = $digit-($bai*100)-($shi*10);
		  //$ge = ($shi_1-($shi_1 % 10)) / 10;
	
		  $img_str.="<img src='/images/".$ge.".png'>";
	
	
	      return $img_str;
		  
	}
	
	public static function get_base_channel_by_url()
	{
		  $req_url = $_SERVER['REQUEST_URI'];
		  $arr_req = explode("/",$req_url);
		  return $arr_req['1'];
	}
	
	public static function get_a_new_password()
	{
		    $rand = rand(0,1000);
			$time = time();
			$modlinkstr = md5($time."_".$rand);
			$pass = substr($modlinkstr,0,6);
			return $pass;
	}
	
	
	public static function get_random_string_with_chars($len)
	{
	     $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k","l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v","w","x","y","z");
	     $charsLen = count($chars) - 1;
	     shuffle($chars);// 将数组打乱
	     $output = "";
	     for ($i=0; $i<$len; $i++)
	     {
	          $output .= $chars[mt_rand(0, $charsLen)];
	     }
	     return $output;
	}
	
	
	public static function get_random_string_with_digital($len)
	{
	     $chars = array("0","1","2","3","4","5","6","7","8","9");
	     $charsLen = count($chars) - 1;
	     shuffle($chars);// 将数组打乱
	     $output = "";
	     for ($i=0; $i<$len; $i++)
	     {
	          $output .= $chars[mt_rand(0, $charsLen)];
	     }
	     return $output;
	}
	
	//加密算法
	public static function get_pass($passstr)
	{
		  return md5(md5($passstr).MBLOG_PWD_SALT);
	}
	
	public static function get_length_str($lein)
	{
		  $hour = $lein / 3600;
		  $hour = floor($hour);
		  if ($hour< 10)
		  {
			    $h_str = "0".$hour;
		  }
		  else
		  {
			    $h_str = $hour; 
		  }
		  
		  $min = ($lein - ($hour*3600)) / 60;
		  $min = floor($min);
		  if ($min< 10)
		  {
			    $m_str = "0".$min;
		  }
		  else
		  {
			    $m_str = $min; 
		  }
		  
		  $sec = $lein - ($hour*3600)-$min*60;
		  if ($sec< 10)
		  {
			    $s_str = "0".$sec;
		  }
		  else
		  {
			    $s_str = $sec; 
		  }
		  
		  return $h_str.":".$m_str.":".$s_str;
	}
	
	public static function get_size_str($size)
	{
		  $int_s = ceil($size / 1048576);
		  return $int_s;
	}
	
	public static function get_size_str_tok($size)
	{
		  $int_s = ceil($size / 1024);
		  return $int_s;
	}
	   //截取中文字符串
	   public static function cn_substr($str,$strlen=12,$other=true) 
	   {
		    $j = 0;
	        for($i=0;$i<$strlen;$i++)
	           if(ord(substr($str,$i,1))>0xa0)
			        $j++;
	        if($j%2!=0)
			       $strlen++;
	        $rstr=substr($str,0,$strlen);
	        if (strlen($str)>$strlen && $other) 
				{$rstr.='...';}
	        return $rstr;
	   }
	
	   public static function if_user_can_access_page($page_r,$user_r)
	   {
		     $arr_p = explode(",",$page_r);
		     //print_r($arr_p);
		     $arr_p = arr_nonull($arr_p);
		     //print_r($arr_p);
		     $arr_u = explode(",",$user_r);
		      $arr_u = arr_nonull($arr_u);
		     //print_r($arr_u);
		     $arr_i = array_intersect($arr_p,$arr_u);
		     //print_r($arr_i);
		     if (sizeof($arr_i) > 0)
		     {
				   return 1;
			 }
			 else
			 {
				   return 0;
			 }
	   }
	
	   public static function arr_nonull($arr)
	   {
		     $arr_p = array_unique($arr);
		     foreach ($arr_p as $kp => $vp)
		     {
				   if ($vp == '')
				   {
					     unset($arr_p[$kp]);
				   }
			 }
			 return $arr_p;
	   }
	   
	public static function loginf($log)
	{
		//
		$ftime = date("Y-m-d H:i:s");
		$log = $ftime."---".$log."\n";
		//
		$waterlog="/bank/log/".date('Y').date('m').date('d')."_e.txt";
		//echo $waterlog."----".$log."\n";
		if (is_file($waterlog))    //
		{
			$_fp = fopen($waterlog,"a+");
			$_action = fwrite($_fp,$log);
			fclose($_fp);
		}
		else
		{
			$_fp = fopen($waterlog,"w+");
			chmod($waterlog,0777);
			$_action = fwrite($_fp,$log);
			fclose($_fp);              	
		}  
	}
	
	public static function get_ftp_username($username)
	{
		  $username =str_replace("@","",$username);
		  $username =str_replace(".","",$username);
		  $username =str_replace(":","",$username);
		  $username =str_replace(";","",$username);
		  $username =str_replace("*","",$username);
		  $username =str_replace("-","",$username);
		  $username =str_replace(" ","",$username);
		   $username =str_replace("'","",$username);
		   $username =str_replace('"',"",$username);
		  $username = strtolower($username);
		  $first = substr($username,0,1);
		  if (is_numeric($first))
		  {
			    $username = "v".$username;
		  }
		  return $username;
	}
	
	public static function if_ftp($username)
	{
		  $username = get_ftp_username($username);
		  $dir1="/bank/ftpdir/".$username;
		  $dir2="/bank/ftpdir/".$username.".bak";
		  if (is_dir($dir1) && is_dir($dir2))
		  {
			    return 1;
		  }
		  else
		  {
			    return 0;
		  }
	}
	
	public static function get_tmb_width($wh)
	{
		  $arr_w = explode("x",$wh);
		  if (isset($arr_w[0]) && isset($arr_w[1]) && is_numeric($arr_w[0]) && is_numeric($arr_w[1]) && ($arr_w[0]>0) && ($arr_w[1]>0))
		  {
			  
			    if ($arr_w[0] > $arr_w[1])
			    {
					  //得到等比例的宽度，如果宽度多于222,则返回222,否则，返回真实宽度
					  $truewidth = (int)((144*$arr_w[0]) / $arr_w[1]);
					  if ($truewidth > 222)
					  {
						   return "222";
					  }
					  else
					  {
						    return $truewidth;
					  }
					  
				}
				else
				{
					  return (int)((144*$arr_w[0]) / $arr_w[1]);
				}
		  }
		  else
		  {
			    return "222";
		  }
	}
	 
	 
	public static function get_pre_size($w,$h,$max)
	{
		  if ($w > $h)
		  {
			    $neww = $max;
			    $newh = (int)(($neww*$h)/$w);
		  }
		  else if ($w == $h)
		  {
			    $neww = $max;
			    $newh = $max;
		  }
		  else
		  {
			    $newh=$max;
			    $neww=(int)(($newh*$w) / $h);
		  }
		  $arr_pre['width'] = $neww;
		  $arr_pre['height'] = $newh;
		  return $arr_pre;
	}
	
	
	
	
	public static function how_long_ago($timestamp)
	{
		    $y = date("Y",$timestamp);
		    $m = date("m",$timestamp);
		    $d = date("d",$timestamp);
		    $h = date("H",$timestamp);
		    $i = date("i",$timestamp);
		    
		    $nowd = date("d");
			$now = time();
			$timespan = $now - $timestamp;
			$days = floor($timespan/86400);
			if($days != 0) 
			{
				if($days == 1) 
				return "昨天 ".$h.":".$i;
				else if ($days == 2)
				return "前天 ".$h.":".$i;
				else
				{
				   //echo "<br/>days:".$days."<br/>";
				   $date = $m."月".$d."日  ".$h.":".$i;
				   return $date;
				}
			}
	
			$hours = floor($timespan/3600);
			if($hours != 0) 
			{
				//echo "<br/>hours:".$hours."<br/>";
				//if($hours == 1)
				if ($d == $nowd)
				{
				       return "今天 ".$h.":".$i;
				}
				else
				{
					   return "昨天 ".$h.":".$i;
				}
				
				//else 
				//return "$hours "."小时前";
			}
	
			$minutes = floor($timespan/60);
			$secs = $timespan - ($minutes * 60);
			if($minutes != 0 && $secs != 0) 
			{
				if($minutes != 1 && $secs != 1) 
				return "$minutes "."分"." $secs "."秒前";
				else if($minutes == 1 && $secs != 1) 
				return "$minutes "."分"." $secs "."秒前";
				else if($minutes == 1 && $secs == 1) 
				return "$minutes "."分"." $sec "."秒前";
			}
			else if($minutes != 0 && $secs == 0)
			{ 
			    return "$minutes "."分钟前";
			}
			else if($minutes == 0 && $secs != 0)
			{
			    return "$secs "."秒前";
		    }
		    else
		    {
				 return "0秒前"; 
			}
	}
	
	
	
	
	
	public static function num_tihuan_with_pic($num)
	{
		$c="";
		$arr_pic = array();
		if($num >= 1000)
		{
			$fn = round($num/1000);
			$len = strlen($fn);
			for ($i=0;$i<$len;$i++)
			{
				$b = substr($fn,$i,1);
				$arr_pic[] = "/images/".$b.".png";
			}
			$arr_pic[] = "/images/k.png";
	
		}
		else
		{
			$len = strlen($num);
			for ($i=0;$i<$len;$i++)
			{
				$b = substr($num,$i,1);
				$arr_pic[] = "/images/".$b.".png";
			}
		}
		return $arr_pic;
	}
	
	public static function wordscut($string, $sublen,$start = 0,$laststr="...", $code = 'UTF-8'){
		return self::get_word($string,$sublen*2,$laststr,$code);
	}
	
	//截图字符字符串，utf8 中文按照2个字符，英文算1个字符
	public static function get_word($string, $length, $dot = '..',$charset='utf-8') { 
		if(strlen($string) <= $length) { 
			return $string; 
		} 
		$string = str_replace(array('　',' ', '&', '"', '<', '>'), array(' ',' ','&', '"', '<', '>'), $string); 
		$strcut = ''; 
		if(strtolower($charset) == 'utf-8') { 
			$n = $tn = $noc = 0; 
			while($n < strlen($string)){ 
				$t = ord($string[$n]); 
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) { 
					$tn = 1; $n++; $noc++; 
				} elseif(194 <= $t && $t <= 223) { 
					$tn = 2; $n += 2; $noc += 2; 
				} elseif(224 <= $t && $t < 239) { 
					$tn = 3; $n += 3; $noc += 2; 
				} elseif(240 <= $t && $t <= 247) { 
					$tn = 4; $n += 4; $noc += 2; 
				} elseif(248 <= $t && $t <= 251) { 
					$tn = 5; $n += 5; $noc += 2; 
				} elseif($t == 252 || $t == 253) { 
					$tn = 6; $n += 6; $noc += 2; 
				} else { 
					$n++; 
				}
				if($noc >= $length) { 
					break; 
				}
			} 
			if($noc > $length) { 
				$n -= $tn; 
			} 
			$strcut = substr($string, 0, $n); 
		} else { 
			for($i = 0; $i < $length; $i++) { 
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i]; 
			} 
		} 
		return $strcut.$dot;
	}
	
	
	//获取html的select标签的 option数据
	public static function html_option($dataArr,$curVal,$valKey,$txtKey,$attr=''){
		$options = '';
		if(empty($dataArr)||$dataArr==-1) return $options;
		foreach ($dataArr as $dVal){
			if($dVal[$valKey]==$curVal){
				
				if(isset($dVal[$attr])){
					$options .= '<option value="'.$dVal[$valKey].'" selected '.$attr.'='.$dVal[$attr].'>'.$dVal[$txtKey].'</option>';
				}else{
					$options .= '<option value="'.$dVal[$valKey].'" selected >'.$dVal[$txtKey].'</option>';
				}
			}else {
				if(isset($dVal[$attr])){
					$options .= '<option value="'.$dVal[$valKey].'" '.$attr.'='.$dVal[$attr].'>'.$dVal[$txtKey].'</option>';
				}else{
					$options .= '<option value="'.$dVal[$valKey].'">'.$dVal[$txtKey].'</option>';
				}
				
			}
		}
		return $options;
	}
	
	
	//分页的信息加入条件的数组 
	public static function page_and_size($filter)
	{
	    if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
	    {
	        $filter['page_size'] = intval($_REQUEST['page_size']);
	    }
	    else
	    {
	        $filter['page_size'] = 10;
	    }
	
	    /* 当前页 */
	    $filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
	
	    /* page 总数 */
	    $filter['page_count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['page_size']) : 1;
	
	    /* 边界处理 */
	    if ($filter['page'] > $filter['page_count'])
	    {
	        $filter['page'] = $filter['page_count'];
	    }
	
	    $filter['start'] = ($filter['page'] - 1) * $filter['page_size'];
	
	    return $filter;
	}
	
	//良品货号标识
	public static function getGoodsNumber($goods_id){
		return 'ILC'.date('ymdhis').$goods_id;
	}
	
	/**
	 * 定义商品SKU码的规则（一个64位置的串）
	 * 
	 * V1  版本号（2） ｜ 状态（2） ｜ 预留（2） ｜   商品ID（16）   ｜ 类型1（4） ｜ 属性1（4） ｜ 类型2（4） ｜ 属性2（4） ｜ 礼品（4）｜礼品属性（4） ｜ 保留（18）
	 *     01          01         00          0000000000000123   0001        0002        0003        0005        0001    0003       000000000000000000
	 */
	public static function goodsSkuSN_encode($goods_id,$type_ids,$attr_ids,$gift=0,$gift_attr=0,$state=1,$version=1,$reserve1=0,$reserve2=0){
		$skuSN = '';//'0000000000000000000000000000000000000000000000000000000000000000';
		if($version==1){
			$version = str_pad($version,2,'0',STR_PAD_LEFT);
			$state = str_pad($state,2,'0',STR_PAD_LEFT);
			$reserve1 = str_pad($reserve1,2,'0',STR_PAD_LEFT);
			$goods_id = str_pad($goods_id,16,'0',STR_PAD_LEFT);
			
			$typeidArr = explode(',',$type_ids);
			$attridArr = explode(',',$attr_ids);
			
			if( count($typeidArr)==2 ){
				$type_id1 = $typeidArr[0];
				$type_id2 = $typeidArr[1];
				$attr_id1 = $attridArr[0];
				$attr_id2 = $attridArr[1];
			}else{
				$type_id1 = $typeidArr[0];
				$type_id2 = 0;
				$attr_id1 = $attridArr[0];
				$attr_id2 = 0;
			}
			
			$type_id1 = str_pad($type_id1,4,'0',STR_PAD_LEFT);
			$type_id2 = str_pad($type_id2,4,'0',STR_PAD_LEFT);
			$attr_id1 = str_pad($attr_id1,4,'0',STR_PAD_LEFT);
			$attr_id2 = str_pad($attr_id2,4,'0',STR_PAD_LEFT);
			
			$gift =  str_pad($gift,4,'0',STR_PAD_LEFT);
			$gift_attr =  str_pad($gift_attr,4,'0',STR_PAD_LEFT);
			$reserve2 = str_pad($reserve2,18,'0',STR_PAD_LEFT);
			
			$skuSN =$version.$state.$reserve1.$goods_id.$type_id1.$attr_id1.$type_id2.$attr_id2.$gift.$gift_attr.$reserve2;
		}else{
			$skuSN = false;
		}
		return $skuSN;
	}
	
	
	/**
	 * sku码反解析
	 */
	public static function goodsSkuSN_decode($goods_sku_sn){
		$skuArr = array();
		$version  = intval( substr($goods_sku_sn,0,2) ) ; //sku版本号
		if($version==1){ //版本01
			$skuArr['version'] = $version;
			$skuArr['state'] = intval( substr($goods_sku_sn,2,2) ) ;;
			$skuArr['reserve1'] = intval( substr($goods_sku_sn,4,2) ) ;
			$skuArr['goods_id'] = intval( substr($goods_sku_sn,6,16) ) ;
			
			$type_id1 = intval( substr($goods_sku_sn,22,4) );
			$attr_id1 = intval( substr($goods_sku_sn,26,4) );
			$type_id2 = intval( substr($goods_sku_sn,30,4) );
			$attr_id2 = intval( substr($goods_sku_sn,34,4) );
			if($type_id1!=0&&$type_id2!=0){
				$skuArr['type_ids'] = $type_id1.",".$type_id2;
				$skuArr['attr_ids'] = $attr_id1.",".$attr_id2;
			}else{
				$skuArr['type_ids'] = $type_id1;
				$skuArr['attr_ids'] = $attr_id1;
			}
			$skuArr['gift'] = intval( substr($goods_sku_sn,38,4) );
			$skuArr['gift_attr'] = intval( substr($goods_sku_sn,42,4) );
			$skuArr['reserve2'] = intval( substr($goods_sku_sn,46,18) );
		}else{
			$skuArr = false;
		}
		return $skuArr;
	}
	
	
	//根据指定URL获取当前模块值
	public static function getCurrMode($url){
		$strUri = trim(str_replace($url, '',$_SERVER['REQUEST_URI']),"/");  
		
		$arr = explode('?', $strUri);
		$model = trim($arr[0],'/');
		return  $model;
	}
	
	
	//敏感词汇过滤
	public static function wordsFilter($str){
		$keywords= array(
						'SB' => '**','sb' => '**','Sb' => '**','sB' => '**','傻逼' => '**','傻屄' => '**',
						'TMD' => '**','tmd' => '**','他妈的' => '**','他妈得' => '**','他妈滴' => '**',
						' 逼' => '**',' 屄' => '**','逼 ' => '**',
						' 干' => '**','干 ' => '**','搞 ' => '**',' 搞' => '**',
						'你妈比' => '**','你妈逼' => '**',
						'强奸' => '**',
						'JB' => '**','jb' => '**','鸡吧' => '**',
						'干你' => '**','插你' => '**','搞你' => '**',
						'NND' => '**','nnd' => '**','Nnd' => '**'
					);
	 	return strtr($str, $keywords);
	}
	
	
	//通过链接获取商品来源,如：taobao,tmall,paipai...
	public static function getGoodsFrom($goods_url){
		$url =  $goods_url;//"http://auction1.paipai.com/BDEA540000000000040100000F330080?PTAG=10048.2.55&qz_gdt=MxzoJ9yhzWPr1o6jPtni8j7BZego0uNNrEECnw8m8SzN7";
		$url = str_replace("//", "", $url);
		$urlArr = explode('/',$url);
		$start = stripos($urlArr[0], '.');
	    $end = stripos($urlArr[0], '.',$start+1);
	    return substr($urlArr[0], $start+1,$end-$start-1);
	}
	
	
	public static function showErr($msg,$code='404'){
		if($code=='404'){
			header('HTTP/1.1 404 Not Found');
		}else{
			header('HTTP/1.1 200 OK');
		}
		
		$url = (isset($_SERVER["HTTP_REFERER"]) && ''!=$_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"]:'/'.MBLOG_SCRIPT_NAME.'/home/';
		if(is_mobile()){
			global $smarty;
			$smarty->assign('headUrl',$url);
			$smarty->assign('msg',$msg);
			$smarty->assign('code',$code);
			$smarty->display('wap/mob_error.htm');
			exit;
		}else{
			echo '
				<body style="width:100%;height:100%;background:#f1f2f7;">
					<table style="width:500px;margin:100px auto 30px auto;">
						<tr>
							<td align="center"><a href="'.$url.'"><img src="'.NEWA_DVIMG_PATH.'/images/default/link_err.png" border="0" title="点击返回" /></a></td>
						</tr>
						<tr>
							<td  style="color:#495c81;font-size:18px;text-align:center;padding:30px 0px;">'.$msg.'</td>
						</tr>
					</table>
				</body>
			';
			exit;
		}
		
	}
	
	public static function  show_err($msg,$code='404'){
		showErr($msg,$code);
	}
	
	//获取文件后缀名
	public static function get_extension($file)
	{
		return substr(strrchr($file, '.'), 1);
	}
	
	
	//判断是否属手机
	public static function is_mobile(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","iphone","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
		$is_mobile = false;
		foreach ($mobile_agents as $device) {
			if (stristr($user_agent, $device)) {
				$is_mobile = true;
				break;
			}
		}
		return $is_mobile;
	}
	
	//判断是否是手机号码
	public static function is_phone_num($phonenum){
		if(strlen($phonenum)!=11) return false;
		if(preg_match("/13[0-9]{1}\d{8}|15[0-9]\d{8}|17[0-9]\d{8}|18[0-9]\d{8}/", $phonenum)){
			return true;
		}else{
			return false;
		}
	}
	
	//判断是否是电话／传真号码
	public static function is_telephone_num($phonenum){
	    if(preg_match("/^0\d{2,3}-?\d{7,8}$/", $phonenum)){
	        return true;
	    }else{
	        return false;
	    }
	}
	
	
	/**
	 * 写日志，方便测试
	 * 注意：服务器需要开通fopen配置
	 * @param $word 要写入日志里的文本内容 默认值：空值
	 * #param $dest 文件存放路径
	 */
	public static function logRs($word='',$dest='') {
		if(empty($dest)){
			$dest = MBLOG_LOCAL_PATH.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'systest.log';
		}
		$fp = fopen($dest,"a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"datetime:".strftime("%Y%m%d%H%M%S",time()).";request_method:".$_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI'].';'.'pid:'.getmypid().';sessionid:'.session_id().';'.$word.PHP_EOL);
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
	
	/**
	 *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
	 *
	 * @access  public
	 * @param   string       $str         待转换字串
	 *
	 * @return  string       $str         处理后字串
	 */
	public static function make_semiangle($str)
	{
	    $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
	                 '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
	                 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
	                 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
	                 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
	                 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
	                 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
	                 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
	                 'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
	                 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
	                 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
	                 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
	                 'ｙ' => 'y', 'ｚ' => 'z',
	                 '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[',
	                 '】' => ']', '〖' => '[', '〗' => ']', '“' => '[', '”' => ']',
	                 '‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<',
	                 '》' => '>',
	                 '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
	                 '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.',
	                 '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
	                 '”' => '"', '’' => '`', '‘' => '`', '｜' => '|', '〃' => '"',
	                 '　' => ' ');
	
	    return strtr($str, $arr);
	}
	
	public static function checkBehavior($db_link)
	{
		$uid = intval($_SESSION['newa_user']['uid']);
		if (empty($uid)) {
			return false;
		}
	
		$sid = new v_user_info_data($db_link);
		$userInfo = $sid->get_one_user_by_uid($uid);
		if ($userInfo == -1 || empty($userInfo)) {
			return false;
		}
		
		return $userInfo;
	}
	
	
	/**
	 * 
	 * 处理一些常规的特殊字符
	 * @param string 字符串 $str
	 * @copyright 2015 by gaorunqiao.ltd
	 * @since File available since Version 1.0 2015-9-21
	 * @author goen<goen88@163.com>
	 * @return string
	 */
	public static function rm_special_chars($str){
		$filter = array("'","‘","’",'"',"“","”","@","＠","!","！","#","＃","$","￥","%","％","......","。","&","＆","x","X","Ｘ","?","？",",","，","/","、","{","}","｛","｝","[","]","【","】","\\","＼","*","^","……","（","）","|","｜","~","～");
		return  str_replace($filter, '', $str);
	}
	
	/**
	 * 
	 * 生成唯一字符串
	 * 
	 * @since File available since Version 1.0 2016-5-12
	 * @author goen<goen88@163.com>
	 * @return string
	 */
	public static function mkUUID(){
		return strtolower( md5(uniqid('',true),false) );
	}
	
	/**
	 *
	 * 过滤掉emoji表情
	 *
	 * @since File available since Version 1.0 2016-8-29
	 * @author youyj<youyj@51lick.com>
	 * @return string
	 */
    public static function filterEmoji($str){
	    $str = preg_replace_callback('/./u', function (array $match) {
	        return strlen($match[0]) >= 4 ? '' : $match[0];
	    }, $str);
	    return $str;
	}
	
	/**
	 * 把用户输入的文本转义（主要针对特殊符号和emoji表情）
	 * @since File available since Version 1.0 2016-11-22
	 * @author youyj<youyj@51lick.com>
	 * @return string
	 */
	public static function userTextEncode($str){
	    if(!is_string($str))return $str;
	    if(!$str || $str=='undefined')return '';
	
	    $text = json_encode($str); //暴露出unicode
	    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
	        return addslashes($str[0]);
	    },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
	    return json_decode($text);
	}
	/**
	 * 解码上面的转义
	 * @since File available since Version 1.0 2016-11-22
	 * @author youyj<youyj@51lick.com>
	 * @return string
	 */
	public static function userTextDecode($str){
	    $text = json_encode($str); //暴露出unicode
	    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
	        return '\\';
	    },$text); //将两条斜杠变成一条，其他不动
	    return json_decode($text);
	}
	
	/**
	 * 根据新浪IP查询接口获取IP所在地
	 *
	 * @since File available since Version 1.0 2016-08-15
	 * @author youyj<youyj@51lick.com>
	 * @return mixed
	 */
	static function getIPLoc($queryIP){
	    $url = "http://api.map.baidu.com/location/ip?ak=sjYlqlip1FNoae6Q8GKLjd7k&ip={$queryIP}&coor=bd09ll";
	    $ch = curl_init($url);
	    curl_setopt($ch,CURLOPT_ENCODING ,'utf8');
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
	    $location = curl_exec($ch);
	    $location = json_decode($location, true);
	    curl_close($ch);
	    $province = !empty($location['content'])?$location['content']['address_detail']['province']:'';
        $city = !empty($location['content'])?$location['content']['address_detail']['city']:'';
        return array(
            'province' => isset($province) ? $province : '',
            'city' => isset($city) ? $city : '',
            'area' => ''
        );
	}
	
	/**
	 *数字金额转换成中文大写金额的函数
	 *String Int $num 要转换的小写数字或小写字符串
	 *return 大写字母
	 *小数位为两位
	 **/
	static function num_to_rmb($num){
	    $c1 = "零壹贰叁肆伍陆柒捌玖";
	    $c2 = "分角元拾佰仟万拾佰仟亿";
	    //精确到分后面就不要了，所以只留两个小数位
	    $num = round($num, 2);
	    //将数字转化为整数
	    $num = $num * 100;
	    if (strlen($num) > 10) {
	        return "金额太大，请检查";
	    }
	    $i = 0;
	    $c = "";
	    while (1) {
	        if ($i == 0) {
	            //获取最后一位数字
	            $n = substr($num, strlen($num)-1, 1);
	        } else {
	            $n = $num % 10;
	        }
	        //每次将最后一位数字转化为中文
	        $p1 = substr($c1, 3 * $n, 3);
	        $p2 = substr($c2, 3 * $i, 3);
	        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
	            $c = $p1 . $p2 . $c;
	        } else {
	            $c = $p1 . $c;
	        }
	        $i = $i + 1;
	        //去掉数字最后一位了
	        $num = $num / 10;
	        $num = (int)$num;
	        //结束循环
	        if ($num == 0) {
	            break;
	        }
	    }
	    $j = 0;
	    $slen = strlen($c);
	    while ($j < $slen) {
	        //utf8一个汉字相当3个字符
	        $m = substr($c, $j, 6);
	        //处理数字中很多0的情况,每次循环去掉一个汉字“零”
	        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
	            $left = substr($c, 0, $j);
	            $right = substr($c, $j + 3);
	            $c = $left . $right;
	            $j = $j-3;
	            $slen = $slen-3;
	        }
	        $j = $j + 3;
	    }
	    //这个是为了去掉类似23.0中最后一个“零”字
	    if (substr($c, strlen($c)-3, 3) == '零') {
	        $c = substr($c, 0, strlen($c)-3);
	    }
	    //将处理的汉字加上“整”
	    if (empty($c)) {
	        return "零元整";
	    }else{
	        return $c . "整";
	    }
	}


    /**
     *
     * 检验URL的合法性
     *
     * @param $url
     * @date 2020/5/19 10:27 AM
     * @author goen<goen88@163.com>
     * @return bool
     */
    public static function is_url_v2($url)
    {
        return preg_match('/^http[s]?:\/\/'.
                '(([0-9]{1,3}\.){3}[0-9]{1,3}'. // IP形式的URL- 199.194.52.184
                '|'. // 允许IP和DOMAIN（域名）
                '([0-9a-z_!~*\'()-]+\.)*'. // 三级域验证- www.
                '([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.'. // 二级域验证
                '[a-z]{2,6})'.  // 顶级域验证.com or .museum
                '(:[0-9]{1,4})?'.  // 端口- :80
                '((\/\?)|'.  // 如果含有文件对文件部分进行校验
                '(\/[0-9a-zA-Z_!~\*\'\(\)\.;\?:@&=\+\$,%#-\/]*)?)$/',
                $url) == 1;
    }

    /**
     *
     * 校验http（s）格式的域名
     * @param $url
     * @date 2020/5/27 11:27 AM
     * @author goen<goen88@163.com>
     * @return bool
     */
    public static function is_url($url)
    {
        $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
        if (preg_match($r, $url)) {
            return true;
        } else {
            return false;;
        }
    }
}