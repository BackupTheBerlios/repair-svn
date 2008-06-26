<?php
require_once("DB.class.php");
class Kamer{
	//velden die bij een kamer horen
	public $home;
	public $verdiep;
	public $kamernummerKort;
	public $kamernummerLang;
	public $telefoonnummer;
	
	/**
	 * maakt een kamer object aan op basis van een geveven
	 * lang kamernummer. BV. 91.01.230.012
	 *
	 * @param String $kamernummerLang
	 */
	public function __construct(String $kamernummerLang){
		$this->kamernummerLang = $kamernummerLang;
		calculateHome();
	}
	
	/**
	 * instellen van de home en het korte kamernummer op
	 * basis van het lange kamernummer
	 */
	private function calculateHome(){
		//opsplitsen in delen
		$gebouw = substr($this->kamernummerLang,0,5);
		$verdiep = substr($this->kamernummerLang,6,3);
		$lokaal = substr($this->kamernummerLang,10,3);
		
		//TODO opzoeken van de home
		//$this->home = $homes.getByPrefix($prefix).naam;
		
		//instellen van het kamernummer
		$this->kamernummerKort=(($verdiep/10)-10).substr($lokaal,1,2);		
	}
}
?>