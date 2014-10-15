<?php

  error_reporting(E_ALL & ~E_NOTICE);

  // Устанавливаем соединение с базой данных
  require_once("../../config/config.php");
  // Подключаем блок авторизации
  require_once("../authorize.php");
  // Подключаем классы формы
  require_once("../../config/class.config.dmn.php");
  
  require_once("../utils/utils.resizeimg.php");
  
  if(empty($_POST))
  {
    // Отмечаем флажок hide
    $_REQUEST['hide'] = true;
  }
  try
  {
	
	
	$query = "SELECT * FROM $tbl_razdel";
	$adr = mysql_query($query);
        if(!$adr)
        {
          exit ($query);
        }
	$arr_razdels = array();
	while ($razdels = mysql_fetch_array($adr)){
		$arr_razdels[$razdels['id']] = $razdels['title'];
	}
	
	
    $name        = new field_text("name",
                                  "Название",
                                  true,
                                  $_POST['name']);
	$editor1        = new field_textarea("editor1",
                                  "Содержание",
                                  true,
                                  $_POST['editor1']);
    $hide        = new field_checkbox("hide",
                                      "Отображать",
                                      $_REQUEST['hide']);
	$price       = new field_text("price",
                                  "Цена",
                                  true,
                                  $_POST['price']);
	$urlpict     = new field_file("urlpict",
                                  "Изображение",
                                  false,
                                  $_FILES,
								  "../../media/images");
	$code        = new field_text("code",
                                  "Код продукта",
                                  true,
                                  $_POST['code']);							  
	$razdelID      = new field_select("razdelID",
                                  "Раздел",
                                  $arr_razdels,
                                  $_POST['razdelID']);
								  
    $form = new form(array("name" => $name,
						   "price" => $price,
						   "code" => $code,
						   "razdelID" => $razdelID,
						   "urlpict" => $urlpict,
                           "editor1" => $editor1,
                           "hide" => $hide), 
                     "Добавить",
                     "field");

    // Обработчик HTML-формы
    if(!empty($_POST))
    {
      // Проверяем корректность заполнения HTML-формы
      // и обрабатываем текстовые поля
      $error = $form->check();
      if(empty($error))
      {
	  $var = $form->fields['urlpict']->get_filename();
		if (!empty($var)){
		$picture= date("y_m_d_h_i_").$var;
		$picturesmall= 's_'.$picture;
		resizeimg("../../media/images/".$picture,
				  "../../media/images/".$picturesmall,
				  200,
				  200);
		}else{$picture= "";
		$picturesmall= "";}
        // Скрытая или открытая директория
        if($form->fields['hide']->value) $showhide = "show";
        else $showhide = "hide";
        // Формируем SQL-запрос на добавление
        // новостного сообщения
        $query = "INSERT INTO $tbl_tovar
                  VALUES (NULL,
                          '{$form->fields['razdelID']->value}',
						  '{$form->fields['name']->value}',
                          '{$form->fields['editor1']->value}',
                          '{$form->fields['price']->value}',
						  '{$form->fields['code']->value}',
                          '$picture',
                          '$picturesmall',
						  '$showhide',
						  NOW())";
        if(!mysql_query($query))
        {
          throw new ExceptionMySQL(mysql_error(), 
                                   $query,
                                  "Ошибка добавления товара");
        }
        // Осуществляем перенаправление
        // на главную страницу администрирования
        ?>
		<script>
		 document.location.href="index.php";
		</script>
		<?
      }
    }
    // Начало страницы
    $title     = 'Добавление товара';
    $pageinfo  = '<p class=help></p>';
    // Включаем заголовок страницы
    require_once("../utils/top.php");
?>
<div align=left>
<FORM>
<INPUT class="button" TYPE="button" VALUE="На предыдущую страницу" 
onClick="history.back()">
</FORM> 
</div>
<?
    // Выводим сообщения об ошибках, если они имеются
    if(!empty($error))
    {
      foreach($error as $err)
      {
        echo "<span style=\"color:red\">$err</span><br>";
      }
    }
?>
<div class="table_user">
<?
    // Выводим HTML-форму 
    $form->print_form();
?>
</div>
<?
  }
  catch(ExceptionObject $exc) 
  {
    require("../utils/exception_object.php"); 
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(ExceptionMember $exc)
  {
    require("../utils/exception_member.php"); 
  }

  // Включаем завершение страницы
  require_once("../utils/bottom.php");
?>
