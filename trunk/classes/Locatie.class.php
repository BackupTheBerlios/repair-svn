<?php
require_once("Taal.class.php");
require_once("exceptions/BadParameterException.class.php");
class Locatie {
	
	private $value;
	
	function __construct($locatie) {
		if (self::isValid($locatie))
			$this->value = $locatie;
		else throw new BadParameterException();
	}
	
	static function getAllValues() {
		return Array(0 => new Locatie("kot"), 1 => new Locatie("verdiep"), 2 => new Locatie("gemeenschappelijk"));
	}
	
	function isValid($locatie) {
		$locatie = strtolower($locatie);
		if ($locatie == "kot" || $locatie == "verdiep" || $locatie == "gemeenschappelijk")
			return true;
		else
			return false;
	}
	
	function getValue() {
		$taal = new Taal();
		return $taal->msg($this->value);
	}
	
	function setValue($value) {
		if (self::isValid($value)) 
			$this->value = $value;
		else throw new BadParameterException();
	}
}

?>
