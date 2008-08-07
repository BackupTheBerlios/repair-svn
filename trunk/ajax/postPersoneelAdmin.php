<?
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/Veld.class.php';
require_once '../classes/Categorie.class.php';
require_once '../classes/CategorieList.class.php';
$auth = new Auth(false);

//if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new Exception("Unauthorized"); // TODO: gepaste exception
if (!$auth->isLoggedIn()) throw new Exception("Unauthorized");

if($_POST['actie'] == "edit"){
	//veldjes ophalen en omzetten
	$id = $_POST['id'];
	$velden = json_decode(stripslashes($_POST['velden']));
	$waarden = json_decode(stripslashes($_POST['waarden']));
	$waarden = array_combine($velden, $waarden);
	$naam_NL = $_POST['naam_NL'];
	$naam_EN = $_POST['naam_EN'];
	$categorie_id = $_POST['categorie_id'];
	
	$veld = new Veld($id);
	$veld->setNaamNL($waarden['naamNL']);
	$veld->setNaamEN($waarden['naamEN']);
	$cat = new Categorie($waarden['categorie']);
	$veld->setCategorie($cat);
	// TODO: submit gedaan, geef melding aan gebruiker	
}
else if($_POST['actie'] == "select"){
	if($_POST['property'] == "categorie")
		echo json_encode(CategorieList::getCategorien($_POST["locatie"]));
}
else if($_POST['actie'] == "remove"){
	$veld = new Veld($_POST["id"]);
	$veld->setVerwijderd(true);
}
?>