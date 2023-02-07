<?php
/*
 *     后台的Cookie系统
 *         by grq
 *         2019.05.08
*/

namespace LGCore\session\staff;

class StaffCookie
{
	    var $link;
        function __construct ($link)
        {
			 $this->link = $link;
        }
        
        function get_md5_brow()
        {
				$theip = $_SERVER['REMOTE_ADDR'];
				$browser = $_SERVER['HTTP_USER_AGENT'];
				$md5brow = md5($theip."--".$browser);
				return $md5brow;
		}
        
        function set_cookie($uid,$nickname,$md5pass)
        {
                @setcookie( "user_id" , $uid ,time()+2592000, "/","", NULL, TRUE);
                @setcookie( "user_nick" , $nickname ,time()+2592000, "/","",NULL,  TRUE);
                @setcookie( "user_name" , $md5pass ,time()+2592000, "/","", NULL, TRUE);
                $md5brow = $this->get_md5_brow();
                @setcookie( "md5brow" , $md5brow ,time()+2592000, "/","", NULL, TRUE);
                @setcookie( "whyclean" , "" ,time()+2592000, "/","", NULL, TRUE);
	    }
	    
	    function clean_cookie($why)
	    {
			
                @setcookie( "user_id" , "0" ,time()+2592000, "/","", NULL, TRUE);
                @setcookie( "user_nick" , "0" ,time()+2592000, "/","",NULL,  TRUE);
                @setcookie( "user_name" , "0" ,time()+2592000, "/","", NULL, TRUE);
                @setcookie( "md5brow" , "0" ,time()+2592000, "/","", NULL, TRUE);
                @setcookie( "whyclean" , $why ,time()+2592000, "/","", NULL, TRUE);
		}
		
		function set_session($row_u)
		{
						  $_SESSION['newa_user']['uid'] = $row_u['uid'];
						  $_SESSION['newa_user']['username'] = $row_u['username'];
						  $_SESSION['newa_user']['nickname']  = $row_u['truename'];
						  $_SESSION['newa_user']['password']  = $row_u['password'];
						  $_SESSION['newa_user']['role']  = $row_u['userrole'];
						  $_SESSION['newa_user']['ifu']  = "1";
		}
		
		function clean_session()
		{
			    //session_unregister("newa_user");
			    $_SESSION["newa_user"] = null;
		}
		
		function if_cookie_right()
		{
			    if(isset($_COOKIE['user_id']) && ($_COOKIE['user_id']!=0))
                {
					    $uid = $_COOKIE['user_id'];
					    $ui = new v_staff_info_data($this->link);
                        $row_u = $ui->get_one_user_by_uid($uid);
                        //print_r($row_u);
                        //exit;
                        if ($row_u == 0)
                        {
								    $this->clean_session();
								    $this->clean_cookie("no user rec");
						}
						else
						{
							  $md5brow = $this->get_md5_brow();
							  $md5pass = md5($row_u['password']);
							  
							  //echo $_COOKIE['user_name']."<br/>";
							  //echo $md5pass."<br/>";
							  
							  //exit;
							  if ($_COOKIE['user_name'] == $md5pass)
							  //if (($_COOKIE['user_name'] == $md5pass) && ($md5brow == $row_u['md5brow']) && ($md5brow == $_COOKIE['md5brow']))
							  {
								   //echo "set<br/>";
								   $this->set_session($row_u); 
								   //print _r($_SESSION);
							  }
							  else
							  {
								    $this->clean_session();
								    $this->clean_cookie("brow is not right");
							  }
						}
			    }
			    else
			    {
					  	$this->clean_session();
						$this->clean_cookie("no user id or id=0");
				}
		}
}

?>
