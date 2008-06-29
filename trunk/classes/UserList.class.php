<?php
require_once 'DB.class.php';
class UserList {
	
	private static $array;
	
	/**
	 * Geeft een gebruiker terug. Indien een gebruiker eerder al aangemaakt werd, zal er geen nieuw User-object aangemaakt worden, maar zal het al bestaande object gerecycled worden.
	 *
	 * @param int $id
	 * @return User
	 */
	public static function getUser($id) {
		if (!array_key_exists($id, self::$array)) {
			if(self::isStudent($id))
				self::$array[$id] = new Student($id);
			else
				self::$array[$id] = new Personeel($id);
		} else {
			return self::$array[$id];
		}
	}
	
	/**
	 * controleert of de gebruiker met deze gebruikersnaam al in onze databank zit
	 * geeft zijn userid terug indien dit het geval is
	 * geeft 0 terug indien hij nog niet bestaat
	 *
	 * @param string $username de te controleren gebruikersnaam
	 * @return het gebruikersid
	 */
	public static function isExistingUser($username){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM user WHERE gebruikersnaam = ?");
		$statement->bind_param('s', $username);
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows==1){
			$statement->bind_result($id);
			$statement->fetch();
			return $id;
		}
		else
			return 0;
	}
	
	/**
	 * checkt of de gebruiker met dit Id een student is
	 *
	 * @param integer $id userid
	 * @return boolean
	 */
	private static function isStudent($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM student WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
	
	/**
	 * checkt of de gebruiker met dit Id personeel is
	 *
	 * @param integer $id userid
	 * @return boolean
	 */
	private static function isPersoneel($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM personeel WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
	
	
}

?>
