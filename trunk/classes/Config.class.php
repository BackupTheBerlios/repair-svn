<?php
final class Config {
	/*
	 * Constanten voor databank
	 */
	public static $DB_SERVER = "localhost";
	public static $DB_LOGIN = "repair";
	public static $DB_PASSWORD = "r3p@1r";
	public static $DB_DATABASE = "repair";
}

/**
 * Eigen exceptionhandler
 */
function exceptions_error_handler($severity, $message, $filename, $lineno) { 
    echo "WTFFF";
}

set_error_handler('exceptions_error_handler');

?>