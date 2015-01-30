<?php
if(isset($_POST['email'],$_POST['password']))
{
	$user = $_POST['email'];
	$pass = $_POST['password'];
	if(_post_404($user) && _post_404($pass) && $_SESSION['encoded_admin']==$_POST['picture'])
	{		
		$select_admin_user = mysql_query("SELECT * FROM panel_admins WHERE user='"._post_404($user)."' AND pass='".md5(_post_404($pass))."' AND `blocked`!=1 AND `status`!=1 ");
		$nums = mysql_num_rows($select_admin_user);
		if($nums>0)
		{
			$row=mysql_fetch_array($select_admin_user);
			$_SESSION['admin_id']=$row['id'];
			$_SESSION['admin_user']=$row['user'];
			$_SESSION['admin_name']=$row['name'];
			$_SESSION['phone']=$row['phone'];
			$_SESSION['email']=$row['email'];
			$_SESSION['permition']=$row['permition'];

			if($_SESSION['admin_user']!="")
			{
				$insert_logs = mysql_query("INSERT INTO system_logs SET 
																`date`='".time()."', 
																`ip`='".$_SERVER['REMOTE_ADDR']."', 
																`os`='".getOS()."', 
																`browser`='".getBrowser()."', 
																`user_id`='".$_SESSION['admin_id']."', 
																`status`=0
																");
				$updateLogged = mysql_query("UPDATE panel_admins SET `logged`=logged+1 WHERE id='".(int)$_SESSION['admin_id']."' ");
				$selectLogged = mysql_query("SELECT logged FROM panel_admins WHERE id='".(int)$_SESSION['admin_id']."' ");
				$rowLogged = mysql_fetch_array($selectLogged);
				$_SESSION['logged']=$rowLogged['logged'];
				$_SESSION['lastLogged']=time();
				unset($_SESSION["try"]);
				_refresh_404('/'.ADMIN_FOLDER.'/'.$_GET['lang'].'/home');
				exit();
			}
		}
		else
		{
			if(!$_SESSION["try"]){
				$_SESSION["try"] = 1;
				$_msg = l("erroroccurred");
			}else{
				$_msg = l("erroroccurred");
				$_SESSION["try"]++;
				if($_SESSION["try"]>=3){
					$check_username = mysql_query("SELECT `blocked` FROM `panel_admins` WHERE `user`='".mysql_real_escape_string($_POST['email'])."' AND `status`!=1 ");
					if(mysql_num_rows($check_username)){
						$c = mysql_fetch_array($check_username);
						if($c["blocked"]){
							$_msg = $_POST['email']." ".l("UserBlocked");
						}
						else
						{
							$updateLogged = mysql_query("UPDATE `panel_admins` SET `blocked`=1, `try_time`='".time()."' WHERE `user`='".mysql_real_escape_string($_POST['email'])."' AND `status`!=1 AND `blocked`!=1 ");
							unset($_SESSION["try"]);
							if($updateLogged){
								$_msg = $_POST['email']." ".l("UserBlocked");
							}else{
								$_msg = l("erroroccurred");
							}
						}
					}else{
						$_msg = l("erroroccurred");
					}
				}
			}
			
		}
	}
	else
	{
		$_msg = l("erroroccurred");
	}
}
?>