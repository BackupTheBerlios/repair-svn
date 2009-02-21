<?php
require_once 'classes/Config.class.php';
require_once 'Taal.class.php';

class KotadresException extends Exception {
	
	public function __construct($message = "", $code = 0) {
		$taal = new Taal();
		$vertaling = $taal->msg('exception_kotadres');
		if ($message == "")
			$output = $vertaling.". ";
		else
			$output = $vertaling.": ".$message;
		parent::__construct ( $output, $code );
	}
}

?>
