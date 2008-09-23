<?php
session_start();
require_once '../classes/Config.class.php';
require_once 'BadParameterException.class.php';
require_once 'Herstelformulier.class.php';
require_once 'Status.class.php';
require_once 'Auth.class.php';
require_once 'Error.class.php';

$auth = new Auth(false);
if (!$auth->getUser()->isPersoneel())
	throw new AccessException();
	
$formid = $_POST['formid'];
if (!is_numeric($formid) || $formid < 1)
	throw new BadParameterException("Formid ".htmlspecialchars($formid)." is een ongeldige parameter.");
	
$error = new Error(0, "Herstelformulier genegeerd: ".$formid, "personeelNegeerMelding.php", "18", $auth->getUser()->getGebruikersnaam());

$herstelformulier = new Herstelformulier($formid);
$herstelformulier->setStatus(new Status("afgesloten"));
$herstelformulier->save();

echo "SUCCESS";
?>