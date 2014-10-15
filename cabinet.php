<?php
require_once("templates/top.php");
?>
<div class="mntxt">
<div class="maintext">
<?php
if($_SESSION['id_user_position']){
	$query="SELECT * FROM $tbl_user WHERE id=".$_SESSION['id_user_position'];
	$usr=mysql_query($query);
		if(!$usr){
			exit ($query);
		}
	$user=mysql_fetch_array($usr);
	echo "<h2>Мой кабинет:</h2>";
	echo "Логин: ".$user['login']."<br/>",
		"Пароль: ".$user['password']."<br/>",
		"email: ".$user['email']."<br/>",
		"Дата регистрации: ".$user['datereg']."<br/>",
		"Последнее посещение: ".$user['lastvisit']."<br/>";
} else {
?>
<a href='login.php'>Авторизируйтесь</a>
<?php
}
?>
</div>
</div>	
<?php	
require_once("templates/bottom.php"); 
?>