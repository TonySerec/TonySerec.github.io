<?php
	function enter($name, $pass){
		global $tbl_user;
		$query="SELECT * FROM $tbl_user WHERE login='$name' AND password='$pass' AND blockunblock='unblock' LIMIT 1";
		$usr=mysql_query($query);
		if(!$usr){
			exit ($query);
		}
		if(mysql_num_rows($usr)){
			$user=mysql_fetch_array($usr);
			$_SESSION['id_user_position']=$user['id'];
			$query="UPDATE $tbl_user SET lastvisit=NOW() WHERE id=".$user['id'];
			$usr=mysql_query($query);
			if(!$usr){
				exit ($query);
			}
			return true;
		}else{return false;}
	}
?>