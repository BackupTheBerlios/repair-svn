<?php
session_start();
require_once '../classes/Auth.class.php';
require_once '../classes/Veld.class.php';
require_once '../classes/Categorie.class.php';
$auth = new Auth(false);

if (!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new Exception("Unauthorized"); // TODO: gepaste exception

//veldjes ophalen TODO:input checken
$id = $_POST['id'];
$naam_NL = $_POST['naam_NL'];
$naam_EN = $_POST['naam_EN'];
$categorie_id = $_POST['categorie_id'];
echo "start";
echo $id;
echo $naam_NL;

$veld = new Veld($id);
$veld->setNaamNL($naam_NL);
$veld->setNaamEN($naam_EN);
//$cat = new Categorie($categorie_id);
$cat = new Categorie(1);
$veld->setCategorie($cat);
// TODO: submit gedaan, geef melding aan gebruiker	
	
?>