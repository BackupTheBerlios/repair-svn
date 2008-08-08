<?php
require_once 'classes/Taal.class.php';
require_once 'classes/Auth.class.php';
session_start();
$auth = new Auth(false);

$taal = $_SESSION['taal'];
if ($taal == "nl") {
	$_SESSION['taal'] = "en";
	if ($auth->isLoggedIn() && $auth->getUser()->isStudent()) {
		$auth->getUser()->setTaal("en");
		$auth->getUser()->save();
	}
}
else {
	$_SESSION['taal'] = "nl";
	if ($auth->isLoggedIn() && $auth->getUser()->isStudent()) {
		$auth->getUser()->setTaal("nl");
		$auth->getUser()->save();
	}
}

$vorige = $_GET['vorige'];

echo("<meta http-equiv=\"Refresh\" content=\"0; URL=".$vorige."\">");
?>