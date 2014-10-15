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
  $title = 'Управление блоком "Основная информация"';
  $pageinfo = '<p class=help>Здесь можно отредактировать основную инфомацию.</p>';

  // Включаем заголовок страницы
  require_once("../utils/top.php");

  try
  {
    // Количество ссылок в постраничной навигации
    $page_link = 3;
    // Количество позиций на странице
    $pnumber = 10;
    // Объявляем объект постраничной навигации
    $obj = new pager_mysql($tbl_maintext,
                           "",
                           "ORDER BY id DESC",
                           $pnumber,
                           $page_link);

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
        $url = '?id='.$news[$i][id].'&page='.$_GET[page];        
        echo "<tr>
                <td><h4>{$news[$i][name]}</h4></td>
				<td> {$news[$i][body]}</td>
                <td class='menu_right' width=200 valign=top align=left>
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