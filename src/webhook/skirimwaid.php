<?php
    include '../config/system.conn.php';
	$scheme = $_SERVER['REQUEST_SCHEME'];
	if (strpos(strtolower($scheme), 'http') !== false){
		$okkk=explode(".",$_SERVER['HTTP_HOST']);
		if ($okkk[1]=="ngrok") {
			$cekhttps="https://";
		}else{
			$cekhttps=$scheme."://";
		}
	}else{
		$cekhttps="https://";
	}
	$urlpath=$_SERVER['REQUEST_URI'];
	if (strpos($urlpath ,'index.php?Mikbotam=webhookwa')){
		$linktobot=str_replace('/pages/index.php?Mikbotam=webhookwa', '/Saldo/Core.php',$urlpath);
	}else{
		$linktobot =str_replace('/pages/?Mikbotam=webhookwa', '/Saldo/corewa.php',$urlpath);
		$linktobot1=str_replace('/pages/?Mikbotam=webhookwa', '/Saldo/corewa1.php',$urlpath);
	}
	$actual_linka = explode("?",$cekhttps . $_SERVER['HTTP_HOST']. $linktobot);
	$actual_link  = $cekhttps.$_SERVER['HTTP_HOST'].$linktobot;
	
	$data=statuswebhookwa(strtolower($_SERVER['HTTP_HOST']),$device);
	echo $data;
?>	