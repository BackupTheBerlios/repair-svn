<?php

class BadParameterException extends Exception {
	
	public function __construct($message = "Wrong parameter supplied!", $code = 0) {
		parent::__construct ( $message, $code );
	}
}

?>
