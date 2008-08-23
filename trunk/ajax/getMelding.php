<?php
	session_start();
	require_once '../classes/Config.class.php';
	require_once("BadParameterException.class.php");
	require_once 'AccessException.php';
	require_once("Herstelformulier.class.php");
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isStudent())
		throw new AccessException();
	
	$formid = $_GET['formid'];
	if (!is_numeric($formid) || $formid < 0)
		throw new BadParameterException();
		
	$opmerking = $_GET['opmerking'];
	if (!is_numeric($opmerking) || ($opmerking != 1 && $opmerking != 0))
		throw new BadParameterException();
			
	$formulier = new Herstelformulier($formid);
	
	if ($opmerking == 0) {
		$veldenlijst = $formulier->getVeldenlijst();
		
		foreach ($veldenlijst as $i => $veldid) {
			$veld = new Veld($veldid);
			$lijst[] = $veld->getCategorie()->getId();
			$lijst[] = $veldid;
		}
		
		echo json_encode($lijst);
	} else {
		echo json_encode($formulier->getOpmerking());	
	}
?>