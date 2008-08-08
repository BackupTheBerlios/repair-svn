<?php
require_once ("DB.class.php");
require_once ("Home.class.php");
class Kamer {
	//velden die bij een kamer horen
	private $home; //een Home object
	private $verdiep;
	private $kamernummerKort;
	private $kamernummerLang;
	private $telefoonnummer;
	
	/**
	 * maakt een kamer object aan op basis van een geveven
	 * lang kamernummer. BV. 91.01.230.012
	 *
	 * @param String $kamernummerLang
	 */
	public function __construct($kamernummerLang) {
		$this->kamernummerLang = $kamernummerLang;
		self::calculateHome ();
	}
	
	/**
	 * instellen van de home en het korte kamernummer op
	 * basis van het lange kamernummer
	 */
	private function calculateHome() {
		//opsplitsen in delen
		$gebouw = substr ( $this->kamernummerLang, 0, 5 );
		$verdiep = substr ( $this->kamernummerLang, 6, 3 );
		$lokaal = substr ( $this->kamernummerLang, 10, 3 );
		
		//opzoeken van de naam van de home
		$this->home = Home::getHome( "kamerPrefix", $gebouw );
		
		//instellen van het kamernummer
		$this->kamernummerKort = (($verdiep / 10) - 10) . substr ( $lokaal, 1, 2 );
		
		//instellen van verdiep
		$this->verdiep = (($verdiep / 10) - 10);
	}
	
	public function getHome() {
		return $this->home;
	}
	
	public function getVerdiep() {
		return $this->verdiep;
	}
	
	public function getKamernummerKort() {
		return $this->kamernummerKort;
	}
	
	public function getKamernummerLang() {
		return $this->kamernummerLang;
	}
	
	public function getTelefoonnummer() {
		return $this->telefoonnummer;//TODO
	}
}
?>