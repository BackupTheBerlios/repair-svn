<?php
require_once 'classes/Config.class.php';
require_once 'Taal.class.php';

class InvalidKeyException extends Exception {
	
	public function __construct($message = "", $code = 0) {
		$taal = new Taal();
		$vertaling = $taal->msg('exception_invalidkey');
		if ($message == "")
			$output = $vertaling.". ";
		else
			$output = $vertaling.": ".$message;
		parent::__construct ( $output, $code );
	}
}

?>
