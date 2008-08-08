<?php
session_start();
$taal = $_SESSION['taal'];
if ($taal == "nl")
	$_SESSION['taal'] = "en";
else
	$_SESSION['taal'] = "nl";

$vorige = $_GET['vorige'];

echo("<meta http-equiv=\"Refresh\" content=\"0; URL=".$vorige."\">");
?>