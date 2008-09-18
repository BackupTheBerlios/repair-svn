<?php
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'AccessException.php';
	require_once("BadParameterException.class.php");
	require_once("Herstelformulier.class.php");
	require_once("Status.class.php");
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn()) 
		throw new AccessException();
	
	$formid = $_POST['formid'];
	if (!is_numeric($formid) || $formid < 1) 
		throw new BadParameterException("formid ".htmlspecialchars($formid)." is invalid");
		
	$evaluatie = $_POST['evaluatie'];
	if (!is_numeric($evaluatie) || ($evaluatie != 0 && $evaluatie != 1)) 
		throw new BadParameterException("evaluatie ".htmlspecialchars($evaluatie)." is invalid");
	
	if ($evaluatie == 1) {
		$herstelformulier = new Herstelformulier($formid);
		$herstelformulier->setStatus(new Status("afgesloten"));
		$herstelformulier->save();
	} 
	elseif ($evaluatie == 0) {
		$opmerking = $_POST['opmerking'];
		$mysqldate = date("Y-m-d H:i:s");
		$herstelformulier = new Herstelformulier($formid);
		$herstelformulier->setDatum($mysqldate);
		$herstelformulier->setStatus(new Status("ongezien"));
		$herstelformulier->setOpmerking($opmerking);
		$herstelformulier->save();	
	}
	
	echo "SUCCESS";
?>