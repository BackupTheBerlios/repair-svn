<?php
//hier gaan we proberen van alle users op te halen uit de ldap die in een home wonen
//vervolgens gaan we zo proberen parsen (home en kamernummer) de gevallen die problemen
//geven worden geoutput.
//PAS OP: dit script is waarschijnlijk redelijk zwaar
require_once 'classes/LDAP.class.php';
require_once 'classes/Home.class.php';

session_start();

if($_SESSION['ldapData']==""){//enkel de eerste keer alle data ophalen
	//data ophalen
	$ldap = new LdapRepair();
	$ldap->connect();
	$ldap->bind();
	$ldap->search("ugentdormpostaladdress=*HOME*");
	$data = $ldap->get_entries();
	$_SESSION['ldapData'] = $data;
}
else 
	$data = $_SESSION['ldapData'];

//voor de statistiekjes
$aantal=sizeof($data);
$failed = 0;
$home=0;
$kamer=0;

//we itereren over de resultset
foreach($data as $rij){
	//we parsen de data
	$parse = parseData($rij);
	
	//we controleren de data
	if(($parse['home']==""||strlen($parse['kamer'])!=13)&&$parse['gebruikersnaam']!=""){
		//er is iets fout, dus we outputten de data voor verder onderzoek
		echo("<pre>");
		print_r($parse);
		print_r($rij);
		echo("</pre>");
		$failed++;
		if($parse['home']=="")
			$home++;
		if(strlen($parse['kamer'])!=13)
			$kamer++;
	}
}

//we outputten het resultaat
if($failed==0)
	echo("WOOHOO! Er werden geen fouten gevonden. $aantal personen werden correct geparsed");
else
	echo("Er trad een fout op bij $failed van de $aantal gevallen. Bij $home was er een fout bij het vaststellen van de home en bij $kamer bij het vaststellen van het kamernummer");


/**
 * aangepaste parseData functie die overweg kan met 1 rij ipv een array met daarin een array
 *
 * @param unknown_type $data
 * @return unknown
 */
function parseData($data){
	$result = array();
	$result['gebruikersnaam'] = $data["uid"][0];
	$result['voornaam'] = $data["ugentpreferredgivenname"][0];
	$result['achternaam'] = $data["ugentpreferredsn"][0];
	$result['email'] = $data["mail"][0];
	$kot = $data["ugentdormpostaladdress"][0];
	if($kot!=""){
		$kot = explode("$", $kot);
		if(strpos(" ".$kot[0], "HOME")){
			//VUILE LDAP HACK :(
			$kot[0] = $kot[0]=="HOME BERTHA DE VRIES"?"HOME BERTHA DE VRIESE":$kot[0];
			$home = Home::getHome("ldapNaam", $kot[0]);
			$result['homeId'] = $home->getId();
			$result['home'] = $home->getLangeNaam();
			$temp = explode(":", $kot[1]);
			if(sizeof($temp)>1)
				$result['kamer'] = $temp[1];//het meest normale geval (volledige kamercode staat waar hij moest staan)
			else{
				$temp = explode("(", $kot[1]);
				$temp = explode(")", $temp[1]);
				if(sizeof($temp)>1)
					$result['kamer'] = $home->getKamerPrefix().".".$temp[0];//enkel de laatste cijfers van de code staan tussen haakjes
				else{
					$temp = explode("K. ", $kot[1]);
					$result['kamer'] = $home->getKamerPrefix().".".converteer($temp[0]);//er wordt nog een oud kamernummer gebruikt
				}
			}
		}
	}
	return $result;
}
?>