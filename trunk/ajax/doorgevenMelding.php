<?php
require_once("../classes/exceptions/BadParameterException.class.php");
require_once("../classes/Herstelformulier.class.php");
require_once("../classes/Status.class.php");
$formid = $_POST['formid'];
if (!is_numeric($formid) || $formid < 1)
	throw new BadParameterException("Formid is ongeldig");
	
$herstelformulier = new Herstelformulier($formid);
$herstelformulier->setStatus(new Status("gedaan"));
$herstelformulier->save();
?>