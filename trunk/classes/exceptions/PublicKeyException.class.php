<?php

class PublicKeyException extends Exception {
	
	public function __construct() {
		$messageEN = "Public Key error, please contact the server admin";
		$messageNL = "Publieke sleutel fout, contacteer de server beheerder";
		$code = 0000;
		// TODO: $messageEN of $messageNL tonen adhv User preferences
		parent::__construct ( $messageEN, $code );
	
	}
}

?>
