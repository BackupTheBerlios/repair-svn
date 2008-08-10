<?
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Home.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) 
		throw new AccessException();
	
	if($_POST['actie'] == "edit"){
		//veldjes ophalen en omzetten
		$id = $_POST['id'];
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
		
		$home = new Home($id);
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
	
		$home = new Home("", $waarden["korteNaam"], $waarden["langeNaam"], $waarden["adres"], $waarden["verdiepen"], $waarden["kamerPrefix"], $waarden["ldapNaam"]);
	}
	else if($_POST['actie'] == "remove"){
		$home = new Home($_POST["id"]);
		$home->setVerwijderd(true);
	}
?>