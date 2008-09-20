<?php
session_start();
require_once '../classes/Config.class.php';
require_once 'BadParameterException.class.php';
require_once 'Herstelformulier.class.php';
require_once 'Status.class.php';
require_once 'Auth.class.php';

$auth = new Auth(false);
if (!$auth->getUser()->isPersoneel())
	throw new AccessException();
	
$formid = $_POST['formid'];
if (!is_numeric($formid) || $formid < 1)
	throw new BadParameterException("Formid ".htmlspecialchars($formid)." is een ongeldige parameter.");
	
$herstelformulier = new Herstelformulier($formid);
$herstelformulier->setStatus(new Status("afgesloten"));
$herstelformulier->save();

echo "SUCCESS";
?>