<?php
require_once 'exceptions/BadParameterException.class.php';

class Taal {
	
	private $messages = array(
			'nl' => array('titel' => 'Online Herstelformulier',
						  'dringende_herstellingen' => 'Dringende Herstellingen',
						  'herstelformulieren_te_evalueren' => "U heeft nog herstelformulieren die <a href='studentMeldingEvalueren.php'>geevalueerd</a> moeten worden.",
						  'welkom_naam_home_kamer' => 'Welkom %1$s, volgens onze gegevens woont u op Home %2$s op kamer %3$s.<br>Indien deze gegevens niet correct zijn, neem dan contact op met de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a>.',
						  'keuze_opties' => 'Maak uw keuze uit de volgende opties:',
						  'meld_nieuw_defect' => 'Een <a href="studentMeldingToevoegen.php">defect</a> melden',
						  'overzicht_aanvragen' => 'Een <a href="studentOverzicht.php">overzicht</a> van de vorige aanvragen bekijken',
						  'welkom' => 'Welkom',
						  'welkom_niet_aangemeld' => 'Welkom op de online herstelformulier applicatie. Op deze website is het mogelijk om een herstelformulier digitaal in te vullen. Klik links op aanmelden om verder te gaan.',
						  'footer' => '&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a>',
						  'handige_links' => 'Handige links',
						  'disclaimer_evaluatie_melding' => 'Deze herstelformulieren werden uitgevoerd maar moeten nog geevalueerd worden. Klik op het groene vinkje om de herstelling aan te duiden als uitgevoerd en hersteld. Klik op het rode kruisje om aan te geven dat de herstelling niet opgelost is, en eventueel een extra opmerking toe te voegen. Let op: je keuze is finaal en onomkeerbaar!',
						  'datum' => 'Datum',
						  'inhoud' => 'Inhoud',
						  'afmelden' => 'Afmelden',
						  'aanmelden' => 'Aanmelden',
						  'overzicht' => 'Overzicht',
						  'welkom_overzicht_naam' => 'Welkom %1$s, op deze pagina kunt u een overzicht vinden van de reeds ingediende herstelformulieren.',
						  'overzicht_herstellingen' => 'Overzicht van de voorbije herstellingen',
						  'defect_melden' => 'Defect melden',
						  'herstelformulier_nieuw' => 'Nieuw herstelformulier',
						  'herstelformulier_nieuw_disclaimer' => 'Hier kan u een nieuw herstelformulier opmaken en indienen. Duid de gepaste velden aan, in de desbetreffende categori&#235en. Extra informatie, of een probleem die niet standaard invulbaar is op dit formulier, kan u altijd onderaan bij "Opmerking" invullen.',
						  'herstelformulier_homenaam' => 'Herstelformulier voor %1$s',
						  'opmerking' => 'Opmerking',
						  'verzenden' => 'Verzenden',
						  'naam' => 'Naam',
						  'ongezien' => "Ongezien: de homemanager heeft dit nog niet bekeken.",
						  'gezien' => "Gezien: de homemanager heeft dit al bekeken.",
						  'gedaan' => "Gedaan: de homemanager heeft dit doorgegeven.",
						  'afgesloten' => "Afgesloten: dit euvel werd verholpen.",
						  'kot' => "Kot",
						  'verdiep' => "Verdiep",
						  'gemeenschappelijk' => "Gemeenschappelijk",
						  'succes_melding_bewerkt' => "<h1>Succes</h1><p>Uw melding werd aangepast.</p>",
						  'succes_melding_toegevoegd_url' => '<h1>Succes</h1><p>Uw melding werd toegevoegd. Klik <a href="%1$s">hier</a> om terug te keren.</p>',
						  'confirm_verwijder' => 'Wil je dit herstelformulier echt verwijderen?',
						  'andere_taal' => 'English',
						  'u_bent_hier' => 'U bent hier:',	
						  'exception_ontoegankelijk' => 'U heeft onvoldoende rechten om deze pagina te bekijken',
						  'exception_badparameter' => 'Er werd een foutieve parameter doorgegeven',
						  'exception_ongeldigemail' => 'Het opgegeven emailadres is geen geldig emailadres',
						  'exception_publickey' => 'De opgegeven sleutel om in te loggen is ongeldig',
						  'exception_invalidkey' => 'De opgegeven sleutel om in te loggen is ongeldig',
						  'geen_error' => 'Er werd geen foutboodschap doorgegeven.',
						  'fout' => 'Er is een onvoorziene fout opgetreden.',
						  'fout_disclaimer' => 'De beheerders van deze applicatie werden op de hoogte gebracht.',
						  'error_melding_bewerken' => 'Het bewerken van dit herstelformulier is mislukt. Onze excuses voor het ongemak. Gelieve het later nog eens te proberen.',
						  'error_melding_toevoegen' => 'Het toevoegen van dit herstelformulier is mislukt. Onze excuses voor het ongemak. Gelieve het later nog eens te proberen.',
						  'error_melding_evaluatie' => 'Het evalueren van dit herstelformulier is mislukt. Onze excuses voor het ongemak. Gelieve het later nog eens te proberen.'
						  ),
			'en' => array('titel' => 'Online Repairform',
						  'dringende_herstellingen' => 'Urgent Repairs',
						  'herstelformulieren_te_evalueren' => "There are still some <a href='studentMeldingEvalueren.php'>repairforms</a> that need to be evaluated.",
						  'welkom_naam_home_kamer' => 'Welcome %1$s, according to our data U reside on Home %2$s in room %3$s.<br>If this is incorrect, please contact the <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Department of Housing</a>.',
						  'keuze_opties' => 'Please choose one of the following:',
						  'meld_nieuw_defect' => 'Report a new <a href="studentMeldingToevoegen.php">defect</a>',
						  'overzicht_aanvragen' => 'View a <a href="studentOverzicht.php">listing</a> of the previous repairforms',
						  'welkom' => 'Welcome',
						  'welkom_niet_aangemeld' => 'Welcome to the online repairform application. This website provides you with the possibility to report your repairforms digitally. Click on login on the left to continue.',
						  'footer' => '&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste commissioned by <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Department of Housing</a>',
						  'handige_links' => 'Links',
						  'disclaimer_evaluatie_melding' => 'These defects were passed on but they do still need to be evaluated. Click on the green icon if this defect was repaired correctly. Click on the red icon if it wasn\'t repaired corectly and you would like to add a comment. Watch out: your choice is final and irreversible!',
						  'datum' => 'Date',
						  'inhoud' => 'Content',
						  'afmelden' => 'Logout',
						  'aanmelden' => 'Login',
						  'overzicht' => 'Listing',
						  'welkom_overzicht_naam' => 'Welcome %1$s, on this page you\'ll find a listing of your reported repairforms and their status.',
						  'overzicht_herstellingen' => 'Reported repairforms',
						  'defect_melden' => 'Report defect',
						  'herstelformulier_nieuw' => 'New repairform',
						  'herstelformulier_nieuw_disclaimer' => 'This is the place where you can fill out a new repairform. Just check the right checkboxes in the right categories. If you have any extra information, or your problem is not available on the repairform, please enter it in the "Comment" field.',
						  'herstelformulier_homenaam' => '%1$s repairform',
						  'opmerking' => 'Comment',
						  'verzenden' => 'Submit',
						  'naam' => 'Name',
						  'ongezien' => "Unseen: the homemanager hasn't seen it yet.",
						  'gezien' => "Seen: the homemanager saw this.",
						  'gedaan' => "Done: the homemanager already reported this.",
						  'afgesloten' => "Finished: this was successfully repaired.",
						  'kot' => "Room",
						  'verdiep' => "Floor",
						  'gemeenschappelijk' => "Common area",
						  'succes_melding_bewerkt' => "<h1>Success</h1><p>Your report was editted.</p>",
						  'succes_melding_toegevoegd_url' => '<h1>Success</h1><p>Your report was added. Click <a href="%1$s">here</a> to return.</p>',
						  'confirm_verwijder' => 'Are you sure you want to delete this repairform?',
						  'andere_taal' => 'Nederlands',
						  'u_bent_hier' => 'You are here:',	
						  'exception_ontoegankelijk' => 'You do not have sufficient rights to access this page',
						  'exception_badparameter' => 'A wrong parameter was supplied',
						  'exception_ongeldigemail' => 'The supplied emailaddress is invalid',
						  'exception_publickey' => 'The suplied loginkey is invalid',
						  'exception_invalidkey' => 'The suplied login key is invalid',
						  'geen_error' => 'There was no errormessage specified.',
						  'fout' => 'Error',
						  'fout_disclaimer' => 'The application\'s administrators were notified of this problem.',
						  'error_melding_bewerken' => 'The editting of this repairform failed. Our apologies for the inconvenience, please try again later.',
						  'error_melding_toevoegen' => 'There was an error while adding this repairform. Our apologies for the inconvenience, please try again later.',
						  'error_melding_evaluatie' => 'There was an error while evaluating this repairform. Our apologies for the inconvenience, please try again later.'
						  )
	);
	
	private $lang;
	
	function __construct() {
		$lang = $_SESSION['taal'];
		$lang = strtolower($lang);
		if ($lang == "nl" || $lang == "en")
			$this->lang = $lang;
		else throw new BadParameterException("this language hasn't been implemented.");
	}
	
	public function msg($key) {
		if ($this->lang == "en" || $this->lang == "nl") {
			$vertaling = $this->messages[$this->lang][strtolower($key)];
			if ($vertaling == "") $vertaling = "#UNDEFINED";
			return $vertaling;
		}
		else throw new BadParameterException("this language hasn't been implemented.");
	}
	
	public function getTaal() {
		return $this->lang;
	}
}

?>
