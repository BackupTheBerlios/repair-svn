<?
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Personeel.class.php';
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
		
		$personeel = new Personeel($id);
		$personeel->setGebruikersnaam($waarden["gebruikersnaam"]);
	}
	else if($_POST['actie'] == "add"){
		//veldjes ophalen en omzetten
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
	
		//$personeel = new Personeel(id, gebruikersnaam, voornaam, achternaam, laatstonline, email);
	}
	else if($_POST['actie'] == "remove"){
		$home = new Personeel($_POST["id"]);
		$home->setVerwijderd(true);
	}
	else if($_POST['actie'] == "ldap"){
		require_once 'classes/LDAP.class.php';
		$l = new LdapRepair();
		echo(json_encode($l->getUserInfo($_POST['waarde'])));
	}
?>