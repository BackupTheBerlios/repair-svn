<?php
final class Config {
	/*
	 * Constanten voor databank
	 */
	public static $DB_SERVER = "localhost";
	public static $DB_LOGIN = "repair";
	public static $DB_PASSWORD = "r3p@1r";
	public static $DB_DATABASE = "repair";
	
	/**
	 * Debug
	 */
	public static $IS_DEBUG = 0;
}

/**
 * Eigen exceptionhandler
 */
function error_handler($severity, $message, $filename, $lineno, $errcontext) { 
	//alle brol afzetten
	//if ( ! ($error_level & error_reporting ()) || ! (ini_get ('display_errors') || ini_get ('log_errors')))
     //   return;
    $error = $message." ".$message." ". $filename." ".$lineno;
    showError($error);
    exit;
}



/**
 * Vangt alle onopgevangen exception op
 *
 * @param Exception $exception de exception
 */
function exception_handler($exception){
	$error = "<p><em>".$exception->getMessage().":</em> ".$exception->getFile()." at line".$exception->getLine()."</p>";
	showError($error);
}

function showError($msg){
	$_SESSION['error']=$msg;
    echo("<meta http-equiv=\"Refresh\" content=\"0; URL=error.php\">");
	die();
}

error_reporting (E_ALL & ~ (E_NOTICE | E_USER_NOTICE));
set_error_handler('error_handler');//TODO: o, de een of andere reden werkt dit niet :(
set_exception_handler('exception_handler');

?>