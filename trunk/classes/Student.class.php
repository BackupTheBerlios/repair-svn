<?php

require_once 'exceptions/BadParameterException.class.php';
require_once ('User.class.php');
require_once ('Home.class.php');
require_once ('Kamer.class.php');
require_once 'LDAP.class.php';

class Student extends User {
	
	private $taal;
	private $home;
	private $homeId;
	private $kamer;
	private $telefoon;
	private $verwijderd;
	
	
	
	function __construct($id, $gebruikersnaam = "", $voornaam = "", $achternaam = "", $laatsteOnline = "", $email = "", $taal = "nl", $homeId = "", $langkamernummer = "", $telefoon = "", $verwijderd="0") {
		$andere = 1;
		if ($id == "") {
			$andere = 0;
			// Nieuwe Student en User
			parent::__construct($id, $gebruikersnaam, $voornaam, $achternaam, $laatsteOnline, $email);
			if(self::isInStudentDatabase($this->id)){
				$andere = 2;
			}
			else{
				$this->taal = $taal;
				$this->homeId = $homeId;
				$this->kamer = new Kamer($langkamernummer);
				$this->telefoon = $telefoon;
				$this->verwijderd = $verwijderd;
				// Maak de Student aan
				$statement = $this->db->prepare("INSERT INTO student (userId, taal, homeId, kamer, telefoon, verwijderd) VALUES (?, ?, ?, ?, ?,?)");
				$statement->bind_param('isisii', $this->id, $this->taal, $this->homeId, $this->kamer->getKamernummerLang(), $this->telefoon, $this->verwijderd);
				$statement->execute();
				$statement->close();
			}
		} 
		if($andere>0) {
			if ($id!="" && !is_numeric($id)) throw new BadParameterException();
			if($andere==1)
				parent::__construct ( $id );
			$statement = $this->db->prepare("SELECT taal, homeId, kamer, telefoon, verwijderd FROM student WHERE userId = ? LIMIT 1");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($this->taal, $this->homeId, $kamer, $this->telefoon, $this->verwijderd);
			$statement->fetch();
			$statement->close();
			$this->kamer = new Kamer($kamer);
		}
		$this->updated = 0;
		
		if($andere==2)
			self::setVerwijderd(0);
	}
	
	function __destruct() {
		self::save();
		parent::__destruct();
	}
	
	function save() {
		if ($this->updated == 1) {
			parent::save();
			$statement = $this->db->prepare("UPDATE student SET taal = ?, homeId = ?, kamer = ?, telefoon = ?, verwijderd = ? WHERE userId = ?");
			$statement->bind_param('sisiii', $this->taal, $this->homeId, $this->kamer->getKamernummerLang(), $this->telefoon, $this->verwijderd, $this->id);
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
			$this->home = new Home($this->homeId);
			
		return $this->home;
	}
	
	function getKamer() {
		return $this->kamer;
	}
	
	function getTelefoon() {
		return $this->telefoon;
	}
	
	function setVerwijderd($var){
		$this->verwijderd = $var;
		$this->updated = 1;
	}
	
	public function syncLDAP(){
		$l = new LdapRepair();
		$gegevens = $l->getUserInfo($this->gebruikersnaam);
		if($gegevens['homeId']=="" || $gegevens['homeId']=="0")//geen homebewoner meer
			setVerwijderd(1);
		if($gegevens['homeId']!=$this->homeId) //andere home
			self::setHome(new Home($gegevens['homeId']));
		if($gegevens['kamer']!=$this->kamer->getKamernummerLang()) //andere kamer
			self::setKamer(new Kamer($gegevens['kamer']));
		
	}

	
	function isInStudentDatabase($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM student WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
}

?>
