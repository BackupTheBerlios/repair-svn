<?php
require_once 'DB.class.php';
class UserList {
	
	private static $array;
	
	/**
	 * Geeft een gebruiker terug. Indien een gebruiker eerder al aangemaakt werd, zal er geen nieuw User-object aangemaakt worden, maar zal het al bestaande object gerecycled worden.
	 *
	 * @param int $id
	 * @return User-object
	 */
	public static function getUser($id) {
		if (!array_key_exists($id, $array)) {
			$array[$id] = new User($id);
		} else {
			return $array[$id];
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
}

?>
