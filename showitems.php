<?php
require_once('config.php');
if(isset($_POST['submit']))
{
	$aID=$_POST['aID'];
	$cnt=count($aID);
	for($idx=0;$idx<$cnt;$idx++)
	{
		$sql_query="UPDATE ft_product SET active=0 WHERE id=" . $aID[$idx];
		DB::query($sql_query);
	}
}
$results=DB::query("SELECT ft_product.id,title,price,asin,availability,fba,prime,date_last_scanned,brand,image from ft_product,ft_asin WHERE id_asin=ft_asin.id and active=1");

$template=$twig->loadTemplate('displayAsin.html');
echo $template->render(array('aAsin'=>$results));
?>