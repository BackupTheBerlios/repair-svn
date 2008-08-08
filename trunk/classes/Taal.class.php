<?php
require_once 'exceptions/BadParameterException.class.php';

class Taal {
	
	private $messages = array(
			'NL' => array('titel' => 'Online Herstelformulier',
						  'dringende_herstellingen' => 'Dringende Herstellingen',
						  'herstelformulieren_te_evalueren' => "U heeft nog herstelformulieren die <a href='evaluatieMelding.php'>geevalueerd</a> moeten worden.",
						  'welkom_naam_home_kamer' => 'Welkom %1$s, volgens onze gegevens woont u op Home %2$s op kamer %3$s.<br>Indien deze gegevens niet correct zijn, neem dan contact op met de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a>.',
						  'keuze_opties' => 'Maak uw keuze uit de volgende opties:',
						  'meld_nieuw_defect' => 'Een <a href="nieuweMelding.php">defect</a> melden',
						  'overzicht_aanvragen' => 'Een <a href="studentOverzicht.php">overzicht</a> van de vorige aanvragen bekijken'
						  ),
			'EN' => array('titel' => 'Online Repairform',
						  'dringende_herstellingen' => 'Urgent Repairs',
						  'herstelformulieren_te_evalueren' => "There are still some <a href='evaluatieMelding.php'>repairforms</a> that need to be evaluated.",
						  'welkom_naam_home_kamer' => 'Welcome %1$s, according to our data U reside on Home %2$s in room %3$s.<br>If this is incorrect, please contact the <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Department of Housing</a>.',
						  'keuze_opties' => 'Please choose one of the following:',
						  'meld_nieuw_defect' => 'Report a new <a href="nieuweMelding.php">shortcoming</a>',
						  'overzicht_aanvragen' => 'View a <a href="studentOverzicht.php">listing</a> of the previous repairforms'
						  )
	);
	
	private $lang;
	
	function __construct($lang = "NL") {
		if ($lang == "NL" || $lang == "EN")
			$this->lang = $lang;
		else throw new BadParameterException("Lang werd niet correct gebruikt."); // TODO: gepaste exception
	}
	
	public function msg($key) {
		if ($this->lang == "EN" || $this->lang == "NL") {
			return $this->messages[$this->lang][$key];
		}
		else throw new BadParameterException("Lang werd niet correct gebruikt."); // TODO: gepaste exception
	}
}

?>
