<?
require_once("DB.class.php");
require_once 'CategorieList.class.php';
require_once 'Categorie.class.php';
class CategorieList{
	
	/**
	 * geeft een lijst van alle Categori‘n objecten uit de databankt terug
	 *
	 * @return lijst van Categorie objecten met 
	 */
	/**
	 * geeft een lijst van alle Categori‘n objecten uit de databankt terug
	 *
	 * @param String $locatie
	 * @return lijst van Categorie objecten met 
	 */
	public static function getCategorien($locatie){
		$lijst = array();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM categorie WHERE locatie=?");
		$statement->bind_param('s', $locatie);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch()){
			$cat = new Categorie($id);
			$lijst[$cat->getId()] = $cat->getNaamNL();
		}
		$statement->close();
		return $lijst;
	}
}
?>