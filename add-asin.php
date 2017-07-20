<?php
require_once('config.php');
if(isset($_POST['submit']))
{
	$asin=$_POST['txtasin'];
	$asin=trim($asin);
	$asintype=$_POST['asintype'];
	$asintype=(int)$asintype;
	$bulkasin=trim($_POST['bulkasin']);
	if($asintype==1)
	  $asin=$bulkasin;
	if(strlen($asin)>0)
	{
		$asin_arr=array();
		if($asintype==1)
		  $asin_arr=explode("\n",$asin);
		
		else 
		  $asin_arr[]=$asin;

		
		$cnt=count($asin_arr);

		for($idx=0;$idx<$cnt;$idx++) 
		{
			$ptr=$asin_arr[$idx];
			$ptr=trim($ptr);
			if(strlen($ptr)==0)
			  continue;
		
			$no=DB::queryFirstField("SELECT COUNT(id) from ft_asin WHERE asin=%s",$ptr);
			if($no==0)
			{
				$record=array('asin'=>$ptr,'date_added'=>new DateTime("now"));
				DB::insert("ft_asin",$record);
			}
		}
		
	}
}
echo $twig->render('addAsin.html');
?>