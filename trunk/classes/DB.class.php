<?
require_once("Config.class.php");

class DBWrapper extends mysqli {
	public $aantal = 0;

	public function prepare($query) {
		if (Config::$IS_DEBUG)
			echo($query."<br/>");
		$this->aantal++;
		$_SESSION['numOfQ'] = $this->aantal;
		return parent::prepare($query);
	}
	
	
}

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
			self::$db_connection = new DBWrapper(Config::$DB_SERVER, Config::$DB_LOGIN, Config::$DB_PASSWORD, Config::$DB_DATABASE);
		return self::$db_connection;
	}
}
?>