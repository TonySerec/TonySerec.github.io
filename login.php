<?php
	require_once("templates/top.php");
	require_once("utils/utils.users.php");
	
?>
<div class="mntxt">
<div class='maintext'>	
<?php	
	$name=new field_text("name", "Логин", true, $_POST['name']);
	$pass=new field_password("pass", "Пароль", true, $_POST['pass']);
	$form=new form(array('name'=>$name, 'pass'=>$pass), 'Вход', 'field');
	
	if($_POST){
		$error=$form->check();
		$query="SELECT COUNT(*) FROM $tbl_user WHERE login='{$form->fields['name']->value}'";
		$usr=mysql_query($query);
		if(!$usr){
			exit ($query);
		}
		if(!mysql_result($usr,0)){
			$error[]='Пользователь с таким именем не существует';
		}
		if(!$error){
			enter($form->fields['name']->value, $form->fields['pass']->value);
?>
 <script>
	document.location.href="index.php";
</script>
<?php
		}
	
		if($error){
			foreach($error as $err){
				echo '<span style="color:red">';
				echo $err;
				echo '</span><br/>';
			}
		}
	}
	$form->print_form();
?>
</div>
</div>	
<?php	
	require_once("templates/bottom.php");
?>	
