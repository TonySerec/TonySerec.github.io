<?php
    require_once("../../config/config.php");
    require_once("../../phpQuery/phpQuery/phpQuery.php");
		
    $query="SELECT * FROM $tbl_tovar WHERE picture=''";
    $cat=mysql_query($query);
    if(!$cat){
        exit($query);
    }
    while($tovars=mysql_fetch_array($cat)){
        //echo "<h2>".$tovars['name']."</h2>";
        $str=@ereg_replace(' ','+',$tovars['name']);
        $url="http://www.google.by/search?q=".$str."&client=firefox-a&hs=K6C&rls=org.mozilla:ru:official&channel=nts&tbm=isch&tbo=u&source=univ&sa=X&ei=vestVOjJG6TMygPTsoDYCA&ved=0CB8QsAQ&biw=1366&bih=667";
		$hab=file_get_contents($url);
        $document=phpQuery::newDocument($hab);
        $hentry=$document->find('.images_table img:eq(0)')->attr('src');
        $dir=$_SERVER['DOCUMENT_ROOT'].'/Anton/media/images/';
        $newname=time().'.jpg';
        if(!copy($hentry,$dir.$newname)){
            echo '<span style="color:red">';
            echo 'Не скапировалось изображение для'.$tovars['name'];
            echo '</span>';
        }else{
            $pic="<img src='../../media/images/".$newname."'/>";
            //echo $pic;
            $query1="UPDATE $tbl_tovar SET picture='$newname', picturesmall='$newname' WHERE id=".$tovars['id'];
            $cat1=mysql_query($query1);
        }
        //echo "<hr/>";
        sleep(1);
    }
?>