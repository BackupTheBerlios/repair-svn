<?php
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
}

?>
