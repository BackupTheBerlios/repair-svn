<?php

class OngeldigeEmailException extends Exception {
	
	public function __construct() {
		$messageEN = "Invalid emailaddress specified.";
		$messageNL = "Ongeldige emailadres gespecifieerd.";
		$code = 0000;
		// TODO: $messageEN of $messageNL tonen adhv User preferences
		parent::__construct ( $messageEN, $code );
	
	}
}

?>
