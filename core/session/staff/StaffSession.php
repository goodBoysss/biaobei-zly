<?php
/*
 *     后台session系统
 *         by garq
 *         2019.05.08
*/

namespace LGCore\session\staff;

class StaffSession
{
		
	function __construct ($obj)
	{
		   //$uc = new staff_cookie($link);
		   $_SESSION['adm_user']['ifu'] = "-1";


		   if (!isset($_POST['username']) || !isset($_POST['password']))
		   {
				 return false ;
				 //echo "begin to check:";
				 //$uc->if_cookie_right();

		   }else{
			   $username = trim($_POST['username']);
			   $password = $_POST['password'];

			   $rlt = $obj->checkUsername($username);
//	               echo "<pre>";
//	               print_r($rlt);
//	               exit;

			   if (is_array($rlt)&&!array_key_exists('error', $rlt))
			   {
					$row_u = isset($rlt['items'])?$rlt['items']:$rlt;
					//核对密码
					 $curpass = md5($password);
					 //$curpass = $password;
//					     echo $curpass."___".$row_u['password']."___".$row_u['ifmod'];
//					     exit;
					 if (($curpass != $row_u['password']) || ($row_u['ifmod'] != '1'))
					 {
						  //$if_v_u = 0;
						  $_SESSION['adm_user']['ifu']  = "0";
					 }else{
						  $_SESSION['adm_user']['uid'] = $row_u['staff_id'];
						  $_SESSION['adm_user']['username'] = $row_u['username'];
						  $_SESSION['adm_user']['truename']  = $row_u['truename'];
						  $_SESSION['adm_user']['group_id']  = $row_u['group_id'];
						  $_SESSION['adm_user']['is_super']  = $row_u['is_super'];
						  //头像是地址
						  $_SESSION['adm_user']['headlogo_url']=isset($row_u['headlogo_url']) && $row_u['headlogo_url']!=""?LG_IMG_URL."/".$row_u['headlogo_url']:'';
						  $_SESSION['adm_user']['ifu']  = "1";
						  //-----------------------------------------保存ip和brow

						  //$md5brow = $uc->get_md5_brow();

						  //更新
						  //$ui->set_md5_brow_by_uid($md5brow,$row_u['uid']);

						  //-----------------------------------------保存cookie
						  //$uc->set_cookie($row_u['uid'],$row_u['nickname'],md5($row_u['password']));
						  //-----------------------------------------记录登录情况


						  //print_r($_COOKIE);

						  //echo "set session end<br/>";
						  //exit;

//							  $uid = $row_u['uid'];
//							  $ip = $_SERVER['REMOTE_ADDR'];
//							  $lld = new system_log_staff_login_data($link);
//							  $lld->add_one_login($uid,$ip);

						  /*
						  $arr_p = array("u"=>$row_u['u'],
						  "d"=>date("Y-m-d H:i:s"),
						  "i"=>$_SERVER['REMOTE_ADDR']
						  );
						  $l_i = new user_login_info($link);
						  $l_i->rec_log($arr_p);
						  */
						  //session_register("adm_user");
						  //$if_v_u = 1;

					}
			   }else{
					$_SESSION['adm_user']['ifu']  = "0";
			   }
	   		}
	   //$this->if_v_u = $if_v_u;
		return ;
	}
}

?>
