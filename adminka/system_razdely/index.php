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
  $title = 'Управление блоком "Разделы"';
  $pageinfo = '<p class=help>Здесь можно добавить
               раздел, отредактировать или
               удалить уже существующий раздел.</p>';

  // Включаем заголовок страницы
  require_once("../utils/top.php");

  try
  {
    // Количество ссылок в постраничной навигации
    $page_link = 3;
    // Количество позиций на странице
    $pnumber = 10;
    // Объявляем объект постраничной навигации
    $obj = new pager_mysql($tbl_razdel,
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
             title='Добавить раздел'>
		<img border=0 src='../utils/img/add.gif' align='absmiddle' />
             Добавить раздел</a>";
?>
</td>
<td width=50%>
</td>
</tr>
</table>
<?
    // Получаем содержимое текущей страницы
    $news = $obj->get_page();
    // Если имеется хотя бы одна запись - выводим 
    if($news)
    {
      ?>
      <table width="100%" class="table">      
        <tr class="header" align="center">
          <td>Наименование</td>
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
        
        echo "<tr $colorrow>
                <td><h4>{$news[$i][title]}</h4></td>
				<td> {$news[$i][body]}</td>
                <td class='menu_right' width=200 valign=top align=left>
                    $showhide
                    <a href='#' onclick=\"delete_position('newsdel.php$url','Вы действительно хотите удалить?');\" title='Удалить'>
                    <img src='../utils/img/editdelete.gif' align='absmiddle' />Удалить</a>
                    <a href='newsedit.php$url' title='Редактировать'><img src='../utils/img/kedit.gif' align='absmiddle' />Редактировать</a>
                </td>
              </tr>";
      }
      echo "</table><br>";
    }
  
    // Выводим ссылки на другие страницы
    echo $obj;
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }

  // Включаем завершение страницы
  require_once("../utils/bottom.php");

echo "";
?>