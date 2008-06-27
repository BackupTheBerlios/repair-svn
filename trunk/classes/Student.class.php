<?php

require_once ('User.class.php');

class Student extends User {
	
	private $taal;
	private $home;
	private $kamer;
	private $telefoon;
	
	// Is er een veld geupdate? Dan moet er weggeschreven worden in __destruct(), anders niet.
	private $updated;
	
	function __construct($id, $gebruikersnaam = "", $laatsteOnline = "", $email = "", $taal = "nl", $homeId = "", $kamer = "", $telefoon = "") {
		$db = DB::getDB();
		if ($id == "") {
			// Nieuwe Student en User
			parent::__construct($id, $gebruikersnaam, $laatsteOnline, $email);
			$this->taal = $taal;
			$this->home = new Home("id", $homeId);
			$this->kamer = new Kamer($kamer);
			$this->telefoon = $telefoon;
			// Maak de Student aan
			$statement = $db->prepare("INSERT INTO student (userId, taal, homeId, kamer, telefoon) VALUES (?, ?, ?, ?, ?)");
			$statement->bind_param('isisi', $this->id, $this->taal, $this->home->getId(), $this->kamer->getKamernummerLang(), $this->telefoon);
			$statement->execute();
			$statement->close();
		} else {
			if (!is_numeric($id)) throw new Exception(); // TODO: gepaste exception
			
			parent::__construct ( $id );
			$statement = $db->prepare("SELECT taal, homeId, kamer, telefoon FROM student WHERE userId = ? LIMIT 1");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->bind_result($this->taal, $homeId, $kamer, $this->telefoon);
			$statement->fetch();
			$this->home = new Home("id", $homeId);
			$this->kamer = new Kamer($kamer);
			$statement->close();
		}
		$this->updated = 0;
	}
	
	function __destruct() {
		save();
		parent::__destruct();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $db->prepare("UPDATE student SET taal = ?, homeId = ?, kamer = ?, telefoon = ? WHERE userId = ?");
			$statement->bind_param('sisii', $this->taal, $this->home->getId(), $this->kamer->getKamernummerLang(), $this->telefoon, $this->id);
			$statement->execute();
			$statement->close();
		}
		$this->updated = 0;
	}
	
	function setTaal($taal) {
		if ($taal == "en" || $taal == "nl") {
			$this->taal = $taal;
			$this->updated = 1;
		} else // TODO: speciale exception
			throw new Exception();
	}
	
	function setHome($home) {
		if (is_a($home, "Home")) {
			$this->home = $home;
			$this->updated = 1;
		}
		else
			throw new Exception(); // TODO: speciale exception
	}
	
	function setKamer($kamer) {
		if (is_a($kamer, "Kamer")) {
			$this->kamer = $kamer;
			$this->updated = 1;
		}
		else
			throw new Exception(); // TODO: speciale exception
	}
	
	function setTelefoon($telefoon) {
		if (is_numeric($telefoon)) {
			$this->telefoon = $telefoon;
			$this->updated = 1;
		}
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
