<?php
	error_reporting(E_ALL & ~E_NOTICE);
	require_once("../../config/config.php");
	require_once("../authorize.php");
	require_once("../../config/class.config.dmn.php");
	require_once("../utils/utils.resizeimg.php");
	
		$_GET['id'] = intval($_GET['id']);
	
	try{
		$query1 = "SELECT * FROM $tbl_tovar
              WHERE id='".$_GET['id']."'";
		$tov = mysql_query($query1);
		if(!$tov){
		  throw new ExceptionMySQL(mysql_error(), 
								   $query1,
								  "Ошибка при обращении
								   к таблице");
		}
		$tovar = mysql_fetch_array($tov);
		
		$urlpict = new field_file("urlpict",
                                  "Изображение",
                                  false,
                                  $_FILES,
								  "../../media/images");
		$form = new form(array("urlpict" => $urlpict), "Сохранить", "field");
		if(!empty($_FILES)){
			$error = $form->check();
			if(empty($error)){
				$var = $form->fields['urlpict']->get_filename();
				if (!empty($var)){
					$picture= date("y_m_d_h_i_").$var;
					$picturesmall= 's_'.$picture;
					resizeimg("../../media/images/".$picture,
							  "../../media/images/".$picturesmall,
							  200,
							  200);
				}else{$picture= "";
					$picturesmall= "";
				}
				$query="UPDATE $tbl_tovar SET picture='$picture', picturesmall='$picturesmall' WHERE id='".$_GET['id']."'";
				if(!mysql_query($query)){
					throw new ExceptionMySQL(mysql_error(), $query, "Ошибка при добавлении фото");
				}
				?>
				<script>
				 document.location.href="index.php?page=<?php echo $_GET['page'] ?>";
				</script>
				<?php
			}
		}
		$title     = 'Добавление фото';
		$pageinfo  = '<p class=help></p>';
		require_once("../utils/top.php");
		?>
		<div align=left>
		<FORM>
		<INPUT class="button" TYPE="button" VALUE="На предыдущую страницу" 
		onClick="history.back()">
		</FORM> 
		</div>
		<?
		if(!empty($error))
		{
		  foreach($error as $err)
		  {
			echo "<span style=\"color:red\">$err</span><br>";
		  }
		}
		echo"<div class='table_user'>";
		echo "<h2>".$tovar['name']."</h2>";
		$form->print_form();
		echo "</div>";
	}catch(ExceptionObject $exc){
		require("../utils/exception_object.php");
	}catch(ExceotionMySQL $exc){
		require("../utils/exception_mysql.php");
	}catch(ExceptionMember $exc){
		require("../utils/excepyion_member.php");
	}
	require_once('../utils/bottom.php');
?>