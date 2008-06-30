<?php
require_once 'Veld.class.php';
require_once 'classes/exceptions/BadParameterException.class.php';
require_once("DB.class.php");

class VeldList {
	
	static function getHomeForm($homeid){
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($homeid) || $homeid < 1) throw new BadParameterException();		
		
		$statement = $db->prepare("SELECT velden.id FROM velden INNER JOIN categorie ON (velden.categorieId = categorie.id)WHERE homeId = ? ORDER BY locatie, categorieId, velden.naamNL");
		$statement->bind_param('i', $homeid);
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
