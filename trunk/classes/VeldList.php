<?php
require_once 'classes/Locatie.class.php';
require_once 'classes/Home.class.php';
require_once 'Veld.class.php';
require_once 'classes/exceptions/BadParameterException.class.php';
require_once("DB.class.php");

class VeldList {
	
	/**
	 * Geeft alle velden terug die bij een homeform horen
	 *
	 * @param Home $homeid
	 * @return Lijst<veldobject>
	 */
	static function getHomeForm($home){
		$db = DB::getDB();
		$lijst = Array();
		if (!is_a($home, "Home")) throw new BadParameterException();		
		
		$statement = $db->prepare("SELECT velden.id FROM velden INNER JOIN categorie ON (velden.categorieId = categorie.id) WHERE homeId = ? ORDER BY locatie, categorieId, velden.naamNL");
		$statement->bind_param('i', $home->getId());
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch()) 
			$lijst[] = new Veld($id);
		$statement->free_result();
		$statement->close();
		return $lijst;
	}
	
	/**
	 * Geeft alel velden voor een home en een locatie terug
	 *
	 * @param Home $homeid
	 * @param Locatie $locatie
	 * @return List[veldid]
	 */
	static function getHomeLocationFields($home, $locatie){
		$db = DB::getDB();
		$lijst = Array();
		if (!is_a($home, "Home")) throw new BadParameterException();
		if (!is_a($locatie, "Locatie")) throw new BadParameterException();		
		
		$statement = $db->prepare("SELECT velden.id FROM velden INNER JOIN categorie ON (velden.categorieId = categorie.id) WHERE homeId = ? AND locatie = ? ORDER BY locatie, categorieId, velden.naamNL");
		$statement->bind_param('is', $home->getId(), $locatie->getValue());
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch()) 
			$lijst[] = new Veld($id);
		$statement->free_result();
		$statement->close();
		return $lijst;
		
	}
}

?>
