<a href="pages/help.php">klik</a><br/>
<?
require_once("classes/Herstelformulier.class.php");
require_once("classes/Veld.class.php");

$h = new Herstelformulier(1);
print_r($h->getVeldenlijst());

foreach ($h->getVeldenlijst() as $index => $veldid) {
	$veldenlijst[$veldid] = new Veld($veldid);
}

print_r($veldenlijst);
?>