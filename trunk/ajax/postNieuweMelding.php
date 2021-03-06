<?php
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'User.class.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Status.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn()) 
		throw new AccessException();
	
	$veldenlijst = $_POST['velden'];
	$opmerking = $_POST['opmerking'];
	$kamer = $_POST['kamer'];
	$mysqldate = date("Y-m-d H:i:s");
	$melding = new Herstelformulier("", $mysqldate, new Status("ongezien"), User::getUser($auth->getUser()->getId()), $opmerking, $veldenlijst, $kamer);
	$melding->save();
	
	echo "SUCCESS";
?>