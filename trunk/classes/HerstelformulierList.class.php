<?php
require_once 'classes/Herstelformulier.class.php';
require_once 'classes/Status.class.php';
require_once 'classes/exceptions/BadParameterException.class.php';
require_once("DB.class.php");

class HerstelformulierList {
	
	/**
	 * Geeft een lijst van Herstelformulieren terug. Je kan zoeken op userId en/of status.
	 *
	 * @param integer $userId
	 * @param Status(optioneel) $status
	 * @return list<Status=>Herstelformulier>
	 */
	static function getList($userId = 0, $searchStatus = "") {
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 0) throw new BadParameterException();
		
		if ($searchStatus == "") {
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE userId = ? ORDER BY status, datum DESC");
			$statement->bind_param('i', $userId);
		} else if ($userId == 0) {
			if ($searchStatus == "") throw new BadParameterException();
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE status = ? ORDER BY datum DESC");
			$statement->bind_param('s', $searchStatus->getValue());
		} else {
			if (!is_a($searchStatus, "Status")) throw new BadParameterException();
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE userId = ? AND status = ? ORDER BY datum DESC");
			$statement->bind_param('is', $userId, $searchStatus->getValue());
		}
		$statement->execute();
		$statement->bind_result($id, $status);
		$statement->store_result();
		while ($statement->fetch()) {
			if (!isset($lijst[$status])) $lijst[$status] = Array();
			$tmp = $lijst[$status];
			$tmp[] = new Herstelformulier($id);
			$lijst[$status] = $tmp;
		}
		$statement->free_result();
		$statement->close();
		
		if ($searchStatus == "")
			return $lijst;
		else
			return $lijst[$searchStatus->getValue()];
	}
	
	/**
	 * geeft een lijst van maximaal $aantal items terug met Herstelformulier objecten horende bij het opgegeven userid
	 *
	 * @param integer $userId
	 * @param integer(optional) $aantal
	 * @return array[herstelformulierobject] een lijst van Herstelformulier objecten
	 */
	static function getLatest($userId, $aantal = -1){
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 1 || !is_numeric($aantal)) throw new BadParameterException();		
		
		$statement = $db->prepare("SELECT id FROM herstelformulier WHERE userId = ? ORDER BY status, datum DESC LIMIT ?");
		$statement->bind_param('ii', $userId, $aantal);
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch()) 
			$lijst[] = new Herstelformulier($id);
		$statement->free_result();
		$statement->close();
		return $lijst;
	}
}

?>
