<?php 

	include_once "Security.php";
	
	if ($_SERVER['REQUEST_METHOD'] != 'POST'){
		header("Location: /");
		exit;
	}
	
	$security = new Security(false);
	$secret_key = $security->hashDecode($security->ReturnAccessHash(), 0);
	$secret_value = $security->hashDecode($security->ReturnRandHash(), 1);
	
	if (isset($_POST[$secret_key]) && $_POST[$secret_key] == $secret_value){
		die(json_encode(array("status" => "ok", 'msg' => 'Protected', "rh"=>$security->ReturnRandHash(), "ah"=>$security->ReturnAccessHash(), "sid"=>$security->ReturnSessionId())));
	}
	
	die('Error access');
