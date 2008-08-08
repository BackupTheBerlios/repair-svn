<?php

class AccessException extends Exception {
	
	public function __construct($message = "De pagina die u probeerde te bekijken is niet toegankelijk voor u.", $code = 0) {
		parent::__construct ( $message, $code );
	}
}

?>
