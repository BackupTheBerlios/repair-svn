<?php

require_once ('User.class.php');
require_once ('Home.class.php');
require_once ('Kamer.class.php');

class Student extends User {
	
	private $taal;
	private $home;
	private $homeId;
	private $kamer;
	private $telefoon;
	
	// Is er een veld geupdate? Dan moet er weggeschreven worden in __destruct(), anders niet.
	private $updated;
	
	function __construct($id, $gebruikersnaam = "", $laatsteOnline = "", $email = "", $taal = "nl", $homeId = "", $langkamernummer = "", $telefoon = "") {
		if ($id == "") {
			// Nieuwe Student en User
			parent::__construct($id, $gebruikersnaam, $laatsteOnline, $email);
			$this->taal = $taal;
			$this->homeId = $homeId;
			$this->kamer = new Kamer($langkamernummer);
			$this->telefoon = $telefoon;
			// Maak de Student aan
			$statement = $this->db->prepare("INSERT INTO student (userId, taal, homeId, kamer, telefoon) VALUES (?, ?, ?, ?, ?)");
			$statement->bind_param('isisi', $this->id, $this->taal, $this->homeId, $this->kamer->getKamernummerLang(), $this->telefoon);
			$statement->execute();
			$statement->close();
		} else {
			if (!is_numeric($id)) throw new BadParameterException();
			
			parent::__construct ( $id );
			$statement = $this->db->prepare("SELECT taal, homeId, kamer, telefoon FROM student WHERE userId = ? LIMIT 1");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->bind_result($this->taal, $this->homeId, $kamer, $this->telefoon);
			$statement->fetch();
			$statement->close();
			$this->kamer = new Kamer($kamer);
		}
		$this->updated = 0;
	}
	
	function __destruct() {
		self::save();
		parent::__destruct();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE student SET taal = ?, homeId = ?, kamer = ?, telefoon = ? WHERE userId = ?");
			$statement->bind_param('sisii', $this->taal, $this->homeId, $this->kamer->getKamernummerLang(), $this->telefoon, $this->id);
			$statement->execute();
			$statement->close();
		}
		$this->updated = 0;
	}
	
	function setTaal($taal) {
		if ($taal == "en" || $taal == "nl")
			$this->taal = $taal;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else throw new BadParameterException();
		$this->homeId = $this->home->getId();
		
		$this->updated = 1;
	}
	
	function setKamer($kamer) {
		if (is_a($kamer, "Kamer"))
			$this->kamer = $kamer;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	function setTelefoon($telefoon) {
		if (is_numeric($telefoon))
			$this->telefoon = $telefoon;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	function getTaal() {
		return $this->taal;
	}
	
	function getHome() {
		if (!isset($this->home))
			$this->home = new Home("id", $this->homeId);
			
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
