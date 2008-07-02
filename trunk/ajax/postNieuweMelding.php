<?php
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/UserList.class.php';
require_once '../classes/Herstelformulier.class.php';
require_once '../classes/Status.class.php';
$auth = new Auth(false);

if (!$auth->isLoggedIn()) throw new Exception("Unauthorized"); // TODO: gepaste exception

print_r($_POST);

foreach ($_POST as $key => $value) {
	if ($value == "on")
		$veldenlijst[] = $key;
}
$mysqldate = date("Y-m-d H:i:s");
$melding = new Herstelformulier("", $mysqldate, new Status("ongezien"), UserList::getUser($auth->getUser()->getId()), "", $veldenlijst);
// TODO: submit gedaan, geef melding aan gebruiker	
	
?>