<?php
require_once 'Taal.class.php';

class PublicKeyException extends Exception {
	
	public function __construct($message = "", $code = 0) {
		$taal = new Taal();
		$vertaling = $taal->msg('exception_publickey');
		if ($message == "")
			$output = $vertaling.". ";
		else
			$output = $vertaling.": ".$message;
		parent::__construct ( $output, $code );
	
	}
}

?>
