<?
require_once("Config.class.php");

class DB{
	//singleton
	private static $db_connection = NULL;
	/**
	 * creert een databank connectie als er nog geen bestaat, geeft anders het huidige terug
	 *
	 * @return mysqli object
	 */
	public static function getDB(){
		if(self::$db_connection == NULL)
			self::$db_connection = new mysqli(Config::$DB_SERVER, Config::$DB_LOGIN, Config::$DB_PASSWORD, Config::$DB_DATABASE);
		return self::$db_connection;
	}
}
?>