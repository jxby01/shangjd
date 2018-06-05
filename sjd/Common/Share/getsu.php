<?php
	require_once "jssdk.php";
	$appid = 'wx5246c89aea484a59';
	$appSecret = '50fe9f01075df962fecefdac3b6fa31a';
	$urls = $_POST['uRl'];
	$jssdk = new JSSDK($appid, $appSecret,$urls);
	$signPackage = $jssdk->GetSignPackage();
	// $allsign = array($signPackage["appId"],$signPackage["timestamp"],$signPackage["nonceStr"],$signPackage["signature"],$signPackage["url"]);
	//print_r($signPackage);
	exit(json_encode(array('result'=>$signPackage)));
?>