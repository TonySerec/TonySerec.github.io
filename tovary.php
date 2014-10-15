<?php
require_once("templates/top.php");
 
echo "<div class='mntxt'>
	 <div class='maintext'>";
	 
if($_GET['url']){
	$file=$_GET['url'];
}else{
	$file="industrial";
}
$query="SELECT $tbl_razdel.title as Раздел,
			   $tbl_razdel.body as Описание,
			   $tbl_tovar.name as Товар,
			   $tbl_tovar.body as Характеристика,
			   $tbl_tovar.price as Цена,
			   $tbl_tovar.code as Код,
			   $tbl_tovar.picturesmall as Фото
		FROM $tbl_razdel INNER JOIN
			 $tbl_tovar
		ON   $tbl_razdel.id=$tbl_tovar.razdelID && $tbl_razdel.url='$file' && $tbl_tovar.showhide='show'";
$adr=mysql_query($query);
if(!$adr){
	exit($query);
}
$news=mysql_fetch_array($adr);
echo "<h2>".$news['Раздел']."</h2>
	 <p>".$news['Описание']."</p>";
echo "<table class='tabletovar'>";
while($news){
	if($news['Фото']){
			$pic="<img src='media/images/".$news['Фото']."'/>";
		}else{
			$pic="<img src='media/img/no_image.png'/>";
		}
	echo "<tr>
            <td width='210px' align='center'>{$pic}</td>
            <td width='70%' valign='top'><h3>{$news['Товар']}</h3>
                       Цена:<b> {$news['Цена']}</b><br>
					   Код товара:<b> {$news['Код']}</b><br>
					   Описание: {$news['Характеристика']}</td>
		</tr>";
$news=mysql_fetch_array($adr);
}
echo "</table>";
echo "</div>
	 </div>";

require_once("templates/bottom.php");
?>