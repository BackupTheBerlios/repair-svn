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
		
	$factuurnummers = json_decode(stripslashes($_POST['factuurnummers']));
	
	$opmerkingnummer = json_decode(stripslashes($_POST['opmerkingnummer']));

	$herstelformulier = new Herstelformulier($formid);
	foreach ($factuurnummers as $veldid => $factuurnummer) {
			$herstelformulier->setFactuurnummer($veldid, $factuurnummer);
	}
	$herstelformulier->setFactuurnummer(0, $opmerkingnummer);
	$herstelformulier->setStatus(new Status("gedaan"));
	$herstelformulier->save();
	
	echo "SUCCESS";
?>