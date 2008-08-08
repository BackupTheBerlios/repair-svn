<?php
	session_start();
	require_once("../classes/exceptions/BadParameterException.class.php");
	require_once '../classes/exceptions/AccessException.php';
	require_once("../classes/Herstelformulier.class.php");
	require_once '../classes/Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isStudent()) //TODO: is deze pagina effectief voor studenten?
		throw new AccessException();
	
	$formid = $_GET['formid'];
	if (!is_numeric($formid) || $formid < 0)
		throw new BadParameterException();
			
	$formulier = new Herstelformulier($formid);
	$veldenlijst = $formulier->getVeldenlijst();
	
	foreach ($veldenlijst as $i => $veldid) {
		$veld = new Veld($veldid);
		$lijst[] = $veld->getCategorie()->getId();
		$lijst[] = $veldid;
	}
	
	echo json_encode($lijst);
?>