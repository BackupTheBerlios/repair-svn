<?php
require_once 'Error.class.php';
final class Config {
	/*
	 * Constanten voor databank
	 */
	public static $DB_SERVER = "localhost";
	public static $DB_LOGIN = "repair";
	public static $DB_PASSWORD = "r3p@1r";
	public static $DB_DATABASE = "repair";
	
	/*
	 * Evaluatie nodig voor welke formulieren
	 */
	public static $DAYS_FOR_EVAL = "7";
	
	/**
	 * Debug
	 */
	public static $IS_DEBUG = 0;
}

/**
 * Eigen exceptionhandler
 */
function error_handler($severity, $message, $filename, $lineno) { 
	//alle brol afzetten
	if ( ! ($error_level & error_reporting ()) || ! (ini_get ('display_errors') || ini_get ('log_errors')))
        return;
    $error = "<p><em>".$message.":</em> ". $filename." op lijn".$lineno;
    try{
	    $user = "";
	    if(isset($_SESSION['userid'])){
	    	$user = new User($_SESSION['userid']);
	    	$user = $user->getGebruikersnaam();
	    }
	    new Error("", $message, $filename, $lineno, $user);
    }
    catch (Exception $e){
    	//doe niets anders is er een oneindige error lus :(
    }
    showError($error);
}



/**
 * Vangt alle onopgevangen exception op
 *
 * @param Exception $exception de exception
 */
function exception_handler($exception){
	$error = "<em>".$exception->getMessage()."</em><br/>(line ".$exception->getLine()." in ".$exception->getFile().")";
	try{
	    $user = "";
	    if(isset($_SESSION['userid'])){
	    	$user = new User($_SESSION['userid']);
	    	$user = $user->getGebruikersnaam();
	    }
	    new Error("", $exception->getMessage(), $exception->getFile(), $exception->getLine(), $user);
    }
    catch (Exception $e){
    	//doe niets anders is er een oneindige error lus :(
    }
	showError($error);
}

function showError($msg){
	$_SESSION['error']=$msg;
	if(strpos(" ".$_SERVER['PHP_SELF'],"error.php"))
		echo $msg;
	else{
    	echo("<meta http-equiv=\"Refresh\" content=\"0; URL=error.php\">");
		die();
	}
}

error_reporting (E_ALL & ~ (E_NOTICE | E_USER_NOTICE));
set_error_handler('error_handler');
set_exception_handler('exception_handler');
$path = "classes".PATH_SEPARATOR."classes/exceptions".PATH_SEPARATOR."ajax".PATH_SEPARATOR."..".PATH_SEPARATOR."../classes".PATH_SEPARATOR."../classes/exceptions";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

?>