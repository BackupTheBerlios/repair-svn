<?
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Categorie.class.php';
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
		
		$cat = new Categorie($id);
		$cat->setNaamNL($waarden["naamNL"]);
		$cat->setNaamEN($waarden["naamEN"]);
	}
	else if($_POST['actie'] == "add"){
		//veldjes ophalen en omzetten
		$velden = json_decode(stripslashes($_POST['velden']));
		$waarden = json_decode(stripslashes($_POST['waarden']));
		$waarden = array_combine($velden, $waarden);
		
		$cat = new Categorie("", $waarden["naamNL"],  $waarden["naamEN"], $waarden["locatie"]);
	}
?>