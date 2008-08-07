<?
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/Home.class.php';
$auth = new Auth(false);

//if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new Exception("Unauthorized"); // TODO: gepaste exception
if (!$auth->isLoggedIn()) throw new Exception("Unauthorized");

if($_POST['actie'] == "edit"){
	//veldjes ophalen en omzetten
	$id = $_POST['id'];
	$velden = json_decode(stripslashes($_POST['velden']));
	$waarden = json_decode(stripslashes($_POST['waarden']));
	$waarden = array_combine($velden, $waarden);
	
	$home = new Home("id", $id);
	$home->setKorteNaam($waarden["korteNaam"]);
	$home->setLangeNaam($waarden["langeNaam"]);
	$home->setAdres($waarden["adres"]);
	$home->setKamerPrefix($waarden["kamerPrefix"]);
	$home->setVerdiepen($waarden["verdiepen"]);
	$home->setLdapNaam($waarden["ldapNaam"]);
}
else if($_POST['actie'] == "add"){
	//veldjes ophalen en omzetten
	$velden = json_decode(stripslashes($_POST['velden']));
	$waarden = json_decode(stripslashes($_POST['waarden']));
	$waarden = array_combine($velden, $waarden);

	$home = new Home("");//todo
}
else if($_POST['actie'] == "remove"){
	$home = new Home($_POST["id"]);
	$home->setVerwijderd(true);
}
?>