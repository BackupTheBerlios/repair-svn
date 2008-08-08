<?php
require_once("Taal.class.php");
require_once("exceptions/BadParameterException.class.php");

class Status {
	private $value;
	
	function __construct($value) {
		if (Status::isValid($value))
			$this->value = $value;
		else throw new BadParameterException();
	}
	
	public static function isValid($value) {
		$value = strtolower($value);
		if ($value == "ongezien" || $value == "gezien" || $value = "gedaan" || $value == "afgesloten")
			return true;
		else
			return false;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($newvalue) {
		if (Status::isValid($newvalue))
			$this->value = $newvalue;
		else throw new BadParameterException();
	}

	/**
	 * Geeft terug of een herstelformulier met deze status nog aanpasbaar is.
	 *
	 * @return boolean
	 */
	public function getChangeable() {
		return ($this->value == "ongezien");
	}
	
	public function getUitleg() {
		$temp = $this->value;
		$taal = new Taal();
		return $taal->msg($temp);
	}
}

?>
