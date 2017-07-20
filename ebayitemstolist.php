<?php
require_once("config.php");
if(isset($_POST['submit']))
{
	$shipping=$_POST['ebay_shipping'];
	$ebay_fee=$_POST['ebay_fee'];
	$paisapay_fee=$_POST['paisapay_fee'];
	$cnt=count($shipping);
	$aID=$_POST['aID'];
	for($idx=0;$idx<$cnt;$idx++)
	{
		$id=$aID[$idx];
		$amz_price=DB::queryFirstField("SELECT price from ft_product WHERE id=%d",$id);
		//$amz_price=50;
		$total=$amz_price+$shipping[$idx];
		$total=$total+$total*($ebay_fee[$idx]+$paisapay_fee[$idx])/100.00;
		$fee=$total*($ebay_fee[$idx]+$paisapay_fee[$idx])/100.0;
		$total=$amz_price+$shipping[$idx]+$fee;
		$ebayprice=$total;
		$ebay_final_fee=$total*$ebay_fee[$idx]/100.0;
		$paisapay_final_fee=$total*$paisapay_fee[$idx]/100.0;
		$fee=$total*($ebay_fee[$idx]+$paisapay_fee[$idx])/100.0;
		$profit=$total-$amz_price-$fee;
		$record_arr['ebay_fee_percentage']=$ebay_fee[$idx];
		$record_arr['paisapay_fee_percentage']=$paisapay_fee[$idx];
		$record_arr['ebay_final_fee']=round($ebay_final_fee,2);
		$record_arr['paisapay_final_fee']=round($paisapay_final_fee,2);
		$record_arr['shipping']=$shipping[$idx];
		$record_arr['ebayprice']=round($ebayprice,2);
		$record_arr['profit']=round($profit,2);
		DB::update("ft_product",$record_arr,"id=%d",$id);
		
	}
}
$results=DB::query("SELECT ft_product.*,asin from ft_product,ft_asin WHERE id_asin=ft_asin.id and active=1 AND ebaylisted=0");

$template=$twig->loadTemplate('displayEbay.html');
echo $template->render(array('aAsin'=>$results));
?>