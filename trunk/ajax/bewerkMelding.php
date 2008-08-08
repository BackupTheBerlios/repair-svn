<?php
	session_start();
	require_once '../classes/exceptions/AccessException.php';
	require_once '../classes/UserList.class.php';
	require_once '../classes/Herstelformulier.class.php';
	require_once '../classes/Status.class.php';
	require_once '../classes/Auth.class.php';
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
	// TODO: aanpassing gedaan, geef melding aan gebruiker	

?>