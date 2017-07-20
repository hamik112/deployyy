<?php
require_once("config.php");
$id=$_GET['id'];
$row=DB::queryFirstRow("SELECT * from ft_product WHERE id=%d",$id);
$template=DB::queryFirstField("SELECT template from ft_template");
$template=str_replace("{title}",$row['title'],$template);
$template=str_replace("{description}","<p>" . $row['description'] . "</p>",$template);
$f=$row['features'];
$f=explode("~",$f);
$cnt=count($f);
$ptr="";
for($idx=0;$idx<$cnt;$idx++)
 $ptr.="<li>" . $f[$idx] . "</li>\n";
$template=str_replace("{features}",$ptr,$template); 
//$template=html_entity_decode($template);
$t=$twig->loadTemplate('showdescription.html');
echo $t->render(array('template'=>$template));
?>