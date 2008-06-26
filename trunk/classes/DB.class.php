<?
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
			self::$db_connection = new mysqli("localhost", "repair", "r3p@1r", "repair");
		return self::$db_connection;
	}
}
?>