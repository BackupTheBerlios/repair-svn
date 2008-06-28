<?php

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
}

?>
