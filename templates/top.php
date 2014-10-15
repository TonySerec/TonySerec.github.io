<?php 
	session_start();
	require_once("config/config.php");
	require_once("config/class.config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LFA-corporation</title>
	<meta name="description" content="Такие светильники применяются для освещения производственных и административных помещений, а также промышленных площадок и улиц.">
	<meta name="keywords" content="Светодиодные светильники">
	<link type="text/css" rel="stylesheet" href="media/style.css">
</head>
<body>
<div class="page">
<div class="wrap">
<div id="header">
	<h1>LFA-corporation</h1>
    <img src="media/img/mylogo1.png" class="logo"/>
	
	<table class="logo">
		<tr>
			<td><FORM ACTION="">
			<INPUT TYPE=search NAME=search VALUE="Поиск">
			</FORM><td>
			<td><img src="media/img/L.png"/></td>
		</tr>
		
		<tr>
			<td class="regy">
<?php if($_SESSION['id_user_position']){ 
?>
					<p><a href='out.php'>Выход</a></p>
					<p><a href='cabinet.php'>Мой кабинет</a></p>
<?php } else { 
?>
					<p><a href='login.php'>Вход</a></p>
					<p><a href='reg.php'>Регистрация</a></p>
<?php } 
?>
			</td>
		</tr>
	</table>

    <img src="media/img/mylogo1.png" class="logo"/>
</div>
	<table width=100% class="menu">
		<tr>
			<td class="menubutton">
				<a href="index.php?url=index">Главная</a>
			</td>
			<td class="menubutton">
				<a href="index.php?url=about">О Компании</a>
			</td>
			<td class="menubutton">
				<a href="index.php?url=product">Продукция</a>
			</td>
			<td class="menubutton">
				<a href="index.php?url=vacancy">Вакансии</a>
			</td>
			<td class="menubutton">
				<a href="index.php?url=contact">Контакты</a>
			</td>
		</tr>
	</table>
        <div class="block left">
		<div class="title">Продукция</div>
		<div class="leftmenu">
<?php 
	$query="SELECT * FROM $tbl_razdel WHERE showhide='show'";
	$adr=mysql_query($query);
	if(!$adr){
		exit($query);
	}
	while($menu=mysql_fetch_array($adr)){
		echo "<a href='tovary.php?url=".$menu['url']."'>".$menu['title']."</a>";
	}
 ?>
		</div>
        </div>
	    <div class="block right">
		<div class="title">Погода</div>
		<table width="200" height="180" style="background-color:#CFCFCF; border: #FFFF00 1px solid; font-size:12px; padding:5px; border-radius:5px;" cellpadding="2" cellspacing="0">
			<tr>
				<td><a href="http://6.pogoda.by/26850" style="font-family:Tahoma; font-size:12px; color:#1C1C1C;" title="Погода Минск на 6 дней - Гидрометцентр РБ" target="_blank">Погода Минск</a></td>
			</tr>
			<tr>
				<td>
					<table width=100% height=100% style="background-color:#CFCFCF; font-family:Tahoma; font-size:12px; color:#1C1C1C;" cellpadding="0" cellspacing="0">
						<tr>
							<td><script type="text/javascript" charset="windows-1251" src="http://pogoda.by/meteoinformer/js/26850_1.js"></script></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right">Информация сайта <a href="http://www.pogoda.by" target="_blank" style="font-family:Tahoma; font-size:12px; color:#1C1C1C;">pogoda.by</a>
				</td>
			</tr>
		</table>
		</div>