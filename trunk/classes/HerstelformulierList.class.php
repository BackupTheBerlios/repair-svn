<?php
require_once 'classes/Herstelformulier.class.php';
require_once 'classes/Status.class.php';
require_once 'classes/exceptions/BadParameterException.class.php';
require_once("DB.class.php");

class HerstelformulierList {
	
	/**
	 * Enter description here...
	 *
	 * @param integer $userId
	 * @param Status(optioneel) $status
	 * @return list<Status=>Herstelformulier>
	 */
	static function getList($userId, $searchStatus = "") {
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 1) throw new BadParameterException();
		
		if ($searchStatus == "") {
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE userId = ? ORDER BY status, datum DESC");
			$statement->bind_param('i', $userId);
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
}

?>
