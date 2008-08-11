<?php
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Status.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isStudent()) 
		throw new AccessException();
	
	$formid = $_POST['formid'];
	$veldenlijst = $_POST['velden'];
	$opmerking = $_POST['opmerking'];
	$mysqldate = date("Y-m-d H:i:s");
	$melding = new Herstelformulier($formid);
	$melding->setDatum($mysqldate);
	$melding->setVeldenlijst($veldenlijst);
	$melding->setOpmerking($opmerking);
	$melding->setStatus(new Status("ongezien"));
	$melding->save();
	
	echo "SUCCESS";
?>