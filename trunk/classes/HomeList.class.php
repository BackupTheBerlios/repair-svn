<?
require_once("DB.class.php");
require_once("Home.class.php");
class HomeList{
	public static function getHomes(){
		$lijst = array();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM home");
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch())
			$lijst[] = new Home($id);
		$statement->close();
		return $lijst;
	}
}
?>