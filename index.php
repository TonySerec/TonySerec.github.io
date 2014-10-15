<?php
require_once("templates/top.php");
 
echo "<div class='mntxt'>
	 <div class='maintext'>";
 
if($_GET['url']){
	$file=$_GET['url'];
}else{
	$file="index";
}
$query="SELECT * FROM $tbl_maintext WHERE url='$file'";
$adr=mysql_query($query);
if(!$adr){
	exit($query);
}
$news=mysql_fetch_array($adr);
echo "<h2>".$news['name']."</h2>";
if($file=="product"){
	echo"<p>".$news['body']."</p>";
	echo "<div id='tovarmenu'>";
	$query="SELECT * FROM $tbl_razdel WHERE showhide='show'";
	$adr=mysql_query($query);
	if(!$adr){
		exit($query);
	}
	while($menu=mysql_fetch_array($adr)){
		echo "<a href='tovary.php?url=".$menu['url']."'>- ".$menu['title']."</a>";
	}
	echo "</div>";
}else{
	echo"<p>".$news['body']."</p>";
}
echo "</div>
	 </div>";

require_once("templates/bottom.php");
?>