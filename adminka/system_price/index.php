<?php

  error_reporting(E_ALL & ~E_NOTICE);

  // Устанавливаем соединение с базой данных
  require_once("../../config/config.php");
  // Подключаем блок авторизации
  require_once("../authorize.php");
  // Подключаем SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // Подключаем блок отображения текста в окне браузера
  require_once("../utils/utils.print_page.php");

  // Данные переменные определяют название страницы и подсказку.
  $title = 'Управление блоком "Товары"';
  $pageinfo = '<p class=help>Здесь можно добавить
               товар, отредактировать или
               удалить уже существующий товар.</p>';

  // Включаем заголовок страницы
  require_once("../utils/top.php");
  
  try
  {
	
    $page_link = 3;
    
    $pnumber = 10;
    
    $obj = new pager_mysql($tbl_tovar,
                           "",
                           "ORDER BY id DESC",
                           $pnumber,
                           $page_link);	  
?>
<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr>
<td width=50% class='menu_right'>
<?
    // Добавить блок
    echo "<a href=newsadd.php?page=$_GET[page]
             title='Добавить товар'>
		<img border=0 src='../utils/img/add.gif' align='absmiddle' />
             Добавить товар</a>";
?>
</td>
<td><a href='#' class='search'>Поиск изображения</a></td>
<td width=50%>
<?
$urlfile = new field_file('urlfile', 'Прайс', false, $_FILES, '../../media/prices');
$form = new form(array('urlfile' => $urlfile), 'Добавить прайс.csv');
$form -> print_form();
?>
</td>
</tr>
</table>
<div id='empty'></div>

<?

if($_FILES){
    $var = $form -> fields['urlfile'] -> get_filename();
    $pricename = date('y_m_d_h_i_').$var;
    $handle = fopen('../../media/prices/'.$pricename, 'r');
    $data = array();
    $k = 0;
    while (!feof($handle)){
        $data[$k] = fgetcsv($handle);
    $k++;
    }
    
    unset ($data[0]);
    $query = "SELECT * FROM $tbl_razdel";
    $cat = mysql_query($query);
    if(!$cat){
        exit($query);
    }
    $razdel = array();
    while($op = mysql_fetch_array($cat)){
       $razdel[$op['id']] = $op['title'];
    }
    foreach($data as $key => $value){
        $arr_value = explode (';', $value[0]);
        //echo "<h2>".$arr_value[1]."</h2>";
        $bool = false;
        foreach($razdel as $raz_key => $val_key){
            if($val_key == $arr_value[0]){
                $bool = true;
				$id = $raz_key;
                continue;
            }
        }
        if($bool == true){
            $query = "SELECT * FROM $tbl_tovar WHERE name='".$arr_value[1]."'";
            $cat = mysql_query($query);
            if(!$cat){
                exit ($query);
            }
            if(mysql_num_rows($cat)>0){
                //echo 'Обновить';
				$query1 = "UPDATE $tbl_tovar 
						   SET price = '".$arr_value[2]."',
							   code = '".$arr_value[3]."'
						   WHERE name='".$arr_value[1]."'";
				$cat1 = mysql_query($query1);
				if(!$cat1){
					exit ($query1);
				}
            }else{
                //echo 'INSERT';
                $query2 = "INSERT INTO $tbl_tovar
                           VALUES (NULL,
                                  '".$id."',
                                  '".$arr_value[1]."',
                                  '',
                                  '".$arr_value[2]."',
                                  '".$arr_value[3]."',
                                  '',
                                  '',
                                  'show',
                                  NOW())";
                $cat2 = mysql_query($query2);
				if(!$cat2){
					exit ($query2);
				}    
            }
        }else{
            echo "<b>".$arr_value[1]."</b> <span style=\"color:red\">&ltНеизвестный раздел &quot;<b>".$arr_value[0]."</b>&quot;&gt;</span><br>";
            //echo "<hr/>";
        }
    }
}


	$news = $obj->get_page();
	 if($news)
    {
?>
      <table width="100%" class="table">      
        <tr class="header" align="center">
          <td>Изображение</td>
		  <td>Содержание</td>
          <td>Действия</td>
        </tr>
<?php
	for($i = 0; $i < count($news); $i++)
      {
        $colorrow = "";
        $url = '?id='.$news[$i][id].'&page='.$_GET[page];
        if($news[$i]['showhide'] == 'show')
        {
          $showhide = "<a href=newshide.php$url
                          title='Скрыть'>
					   <img src='../utils/img/folder_locked.gif' align='absmiddle' />
                       Скрыть</a>";
        }
        else
        {
          $showhide = "<a href=newsshow.php$url 
                          title='Отобразить'>
					   <img src='../utils/img/show.gif' align='absmiddle' />
                       Отобразить</a>";
          $colorrow = "class='hiddenrow'";
        }
		if($news[$i]['picturesmall']){
			$pic="<img src='../../media/images/".$news[$i]['picturesmall']."'/>";
		}else{
			$pic="<img src='../../media/img/no_image.png'/>";
		}
		echo "<tr $colorrow>
                    <td>{$pic}</td>
                    <td><h2>{$news[$i]['name']}</h2>
                            цена:<b>{$news[$i]['price']}</b><br/>
                            описание:<b>{$news[$i]['body']}</b></td>
                    <td class='menu_right' width=200 valign=top align=left>
                    $showhide
                    <a href='#' onclick=\"delete_position('newsdel.php$url','Вы действительно хотите удалить?');\" title='Удалить'>
                    <img src='../utils/img/editdelete.gif' align='absmiddle' />Удалить</a>
                    <a href='newsedit.php$url' title='Редактировать'><img src='../utils/img/kedit.gif' align='absmiddle' />Редактировать</a>
					<a href='changepicture.php$url' title='Изменить фото'><img src='../utils/img/changepicture.ico' align='absmiddle' />Изменить фото</a>
                    </td>
			  </tr>";
	  }
?>
</table>
<?php
  }
   echo $obj;
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
?>
  <script>
  $(function(){
      $.ajaxSetup({
        url:'ajax.php',
        success:function(data){
            $('#empty').html(data);
        },
        error:function(msg){
            $('#empty').html(msg);
        },
        beforeSend:function(){
            $('#empty').html("<img src='../../media/img/clock.gif'>");
        }
      });
      $('.search').click(function(){
        $.ajax();
      });
  });
  </script>
<?
  // Включаем завершение страницы
  require_once("../utils/bottom.php");
  
echo "";
?>