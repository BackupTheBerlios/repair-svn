<?
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/Veld.class.php';
require_once '../classes/Categorie.class.php';
require_once '../classes/CategorieList.class.php';
$auth = new Auth(false);

//if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new Exception("Unauthorized"); // TODO: gepaste exception
if (!$auth->isLoggedIn()) throw new Exception("Unauthorized");


	echo $_POST["action"];
	echo $_POST["locatie"];

if($_POST['actie'] == "edit"){
	//veldjes ophalen TODO:input checken
	$id = $_POST['id'];
	$naam_NL = $_POST['naam_NL'];
	$naam_EN = $_POST['naam_EN'];
	$categorie_id = $_POST['categorie_id'];
	
	$veld = new Veld($id);
	$veld->setNaamNL($naam_NL);
	$veld->setNaamEN($naam_EN);
	//$cat = new Categorie($categorie_id);
	$cat = new Categorie(1);
	$veld->setCategorie($cat);
	// TODO: submit gedaan, geef melding aan gebruiker	
}
else if($_POST['actie'] == "categorie"){
	$lijst = CategorieList::getCategorien($_POST["locatie"]);
	echo array_to_json_string($lijst);
}


function array_to_json_string($arraydata) {
		$output = "";
		$output .= "{";
		foreach($arraydata as $key=>$val){
			if (is_array($val)) {
				$output .= "\"".$key."\" : [{";
					foreach($val as $subkey=>$subval){
						$output .= "\"".$subkey."\" : \"".$subval."\",";
					}
				$output .= "}],";
			} else {
				$output .= "\"".$key."\" : \"".$val."\",";
			}
		}
		$output .= "}";
		return $output;
}
?>