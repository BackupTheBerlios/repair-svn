<?php
require_once("../classes/Herstelformulier.class.php");
require_once("../classes/Status.class.php");
require_once("../classes/exceptions/BadParameterException.class.php");
$formid = $_POST['formid'];
if (!is_numeric($formid) || $formid < 1) throw new BadParameterException("Formid is ongeldig."); // TODO: gepaste exception
$evaluatie = $_POST['evaluatie'];
if (!is_numeric($evaluatie) || ($evaluatie != 0 && $evaluatie != 1)) throw new BadParameterException("Evaluatie is ongeldig."); // TODO: gepaste exception

if ($evaluatie == 1) {
	$herstelformulier = new Herstelformulier($formid);
	$herstelformulier->setStatus(new Status("afgesloten"));
	$herstelformulier->save();
}
?>