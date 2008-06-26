<?php

require_once ('classes/User.class.php');

class Student extends User {
	
	private $taal;
	private $home;
	private $kamer;
	private $telefoon;
	
	function __construct($id) {
		parent::__construct ( $id );
		$db = DB::getDB();
		$statement = $db->prepare("SELECT taal, homeId, kamer, telefoon FROM student WHERE userId = ? LIMIT 1");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->bind_result($this->taal, $homeId, $kamer, $this->telefoon);
		$statement->fetch();
		$this->home = new Home("id", $homeId);
		$this->kamer = new Kamer($kamer);
		$statement->close();
	}
	
	function __destruct() {
		$statement = $db->prepare("UPDATE student SET taal = ?, homeId = ?, kamer = ?, telefoon = ? WHERE userId = ?");
		$statement->bind_param('s', $this->taal);
		$statement->bind_param('i', $this->home->getId());
		$statement->bind_param('s', $this->kamer->getKamernummerLang());
		$statement->bind_param('i', $this->telefoon);
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement->close();
	}
	
	function setTaal($taal) {
		if ($taal == "en" || $taal == "nl") {
			$this->taal = $taal;
		} else // TODO: speciale exception
			throw new Exception();
	}
	
	function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else
			throw new Exception(); // TODO: speciale exception
	}
	
	function setKamer($kamer) {
		if (is_a($kamer, "Kamer"))
			$this->kamer = $kamer;
		else
			throw new Exception(); // TODO: speciale exception
	}
	
	function setTelefoon($telefoon) {
		if (is_numeric($telefoon))
			$this->telefoon = $telefoon;
		else
			throw new Exception(); // TODO: speciale exception
	}
	
	function getTaal() {
		return $this->taal;
	}
	
	function getHome() {
		return $this->home;
	}
	
	function getKamer() {
		return $this->kamer;
	}
	
	function getTelefoon() {
		return $this->telefoon;
	}
}

?>
