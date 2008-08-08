<?php
	require_once '../classes/exceptions/AccessException.php';
	require_once("../classes/exceptions/BadParameterException.class.php");
	require_once("../classes/Herstelformulier.class.php");
	require_once("../classes/Status.class.php");
	require_once '../classes/Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isStudent()) 
		throw new AccessException();
	
	$formid = $_POST['formid'];
	if (!is_numeric($formid) || $formid < 1) 
		throw new BadParameterException("Formid is ongeldig."); // TODO: gepaste exception
	$evaluatie = $_POST['evaluatie'];
	if (!is_numeric($evaluatie) || ($evaluatie != 0 && $evaluatie != 1)) 
		throw new BadParameterException("Evaluatie is ongeldig."); // TODO: gepaste exception
	
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
?>