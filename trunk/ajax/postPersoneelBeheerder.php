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
		$personeel->setMails($waarden["mails"]);
		echo$waarden["mails"];
		$l = explode(";", $waarden['homes']);
		$lijst = array();
		foreach ($l as $home){
			if($home != "")
				$lijst[] = $home;
		}
		$personeel->setHomes($lijst);
	}
	else if($_POST['actie'] == "add"){
		//veldjes ophalen en omzetten
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
		require_once 'LDAP.class.php';
		$l = new LdapRepair();
		$extra = $l->getUserInfo($waarden['gebruikersnaam']);
		$personeel = new Personeel("", $waarden['gebruikersnaam'], $extra['voornaam'], $extra['achternaam'], "", $extra['email'],$waarden['mails']);
		$l = explode(";", $waarden['homes']);
		$lijst = array();
		foreach ($l as $home){
			if($home != "")
				$lijst[] = $home;
		}
		$personeel->setHomes($lijst);
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
	else if($_POST['actie'] == "lijst"){
		$l = array();
		require_once 'Home.class.php';
		$h = Home::getHomes();
		foreach($h as $home)
			$l[$home->getId()] = $home->getKorteNaam();
		echo(json_encode($l));
	}
?>