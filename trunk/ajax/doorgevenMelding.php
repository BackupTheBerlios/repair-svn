<?php
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'AccessException.php';
	require_once("BadParameterException.class.php");
	require_once("Herstelformulier.class.php");
	require_once("Status.class.php");
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) 
		throw new AccessException();
	
	$formid = $_POST['formid'];
	if (!is_numeric($formid) || $formid < 1)
		throw new BadParameterException("Formid is ongeldig");
		
	$factuurnummer = $_POST['factuurnummer'];
	if (!is_numeric($factuurnummer))
		throw new BadParameterException("Factuurnummer is ongeldig");
		
	$herstelformulier = new Herstelformulier($formid);
	$herstelformulier->setFactuurnummer($factuurnummer);
	$herstelformulier->setStatus(new Status("gedaan"));
	$herstelformulier->save();
	
	echo "SUCCESS";
?>