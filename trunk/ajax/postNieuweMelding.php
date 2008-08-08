<?php
require_once '../classes/User.class.php';
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/Herstelformulier.class.php';
require_once '../classes/Status.class.php';
$auth = new Auth(false);

if (!$auth->isLoggedIn()) throw new Exception("Unauthorized"); // TODO: gepaste exception

$veldenlijst = $_POST['velden'];
$opmerking = $_POST['opmerking'];
$mysqldate = date("Y-m-d H:i:s");
$melding = new Herstelformulier("", $mysqldate, new Status("ongezien"), User::getUser($auth->getUser()->getId()), $opmerking, $veldenlijst);
// TODO: submit gedaan, geef melding aan gebruiker	
?>