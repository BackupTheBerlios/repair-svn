<?php

require_once ('User.class.php');

class Personeel extends User {
	
	private $homeslijst;
	
	function __construct($id) {
		if (!is_numeric($id)) throw new BadParameterException();
		
		parent::__construct ( $id );
		$statement = $db->prepare("SELECT homeId FROM relatie_personeel_home WHERE personeelId = ?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($homeId);
		while($statement->fetch())
			$this->homeslijst[] = new Home("id", $homeId);
		$statement->close();
	}
	
	function __destruct() {
		self::save();
		parent::__destruct();
	}
	
	function save() {
	}
}

?>
