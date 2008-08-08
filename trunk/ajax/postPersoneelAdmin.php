<?
	session_start();
	require_once '../classes/exceptions/AccessException.php';
	require_once '../classes/Locatie.class.php';
	require_once '../classes/Veld.class.php';
	require_once '../classes/Home.class.php';
	require_once '../classes/Categorie.class.php';
	require_once '../classes/Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) 
		throw new AccessException();
	
	if($_POST['actie'] == "edit"){
		//veldjes ophalen en omzetten
		$id = $_POST['id'];
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
		
		$veld = new Veld($id);
		$veld->setNaamNL($waarden['naamNL']);
		$veld->setNaamEN($waarden['naamEN']);
		$cat = new Categorie($waarden['categorie']);
		$veld->setCategorie($cat);
	}
	else if($_POST['actie'] == "add"){
		//veldjes ophalen en omzetten
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
		
		$cat = new Categorie($waarden['categorie']);
		$home = new Home($_POST['home']);
		$veld = new Veld("", $waarden['naamNL'], $waarden['naamEN'], $cat, $home);
	}
	else if($_POST['actie'] == "select"){
		if($_POST['property'] == "categorie")
			echo json_encode(Categorie::getCategorien($_POST["locatie"]));
	}
	else if($_POST['actie'] == "remove"){
		$veld = new Veld($_POST["id"]);
		$veld->setVerwijderd(true);
	}
?>