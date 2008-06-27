<?php
require_once("DB.class.php");
class User {
	
	protected $db;
	
	protected $id;
	protected $gebruikersnaam;
	protected $laatsteOnline;
	protected $email;
	
	// Is er een veld geupdate? Dan moet er weggeschreven worden in __destruct(), anders niet.
	private $updated;
	
	function __construct($id, $gebruikersnaam = "", $laatsteOnline = "", $email = "") {
		$db = DB::getDB();
		if ($id == "") {
			// Dit is een nieuwe User
			$this->gebruikersnaam = $gebruikersnaam;
			setLaatsteOnline($laatsteOnline);
			setEmail($email);
			// bepalen van zijn userId
			$statement = $db->prepare("INSERT INTO user (gebruikersnaam, laatsteOnline, email) VALUES (?, ?, ?)");
			$statement->bind_param('sss', $this->gebruikersnaam, $this->laatsteOnline, $this->email);
			$statement->execute();
			$this->id = $db->insert_id;
			$statement->close();
		} else {
			// Al bestaande User
			if (!is_numeric($id)) throw new Exception(); // TODO: gepaste exception
			
			$this->id = $id;
			$statement = $db->prepare("SELECT gebruikersnaam, laatsteOnline, email FROM user WHERE id = ? LIMIT 1");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->bind_result($this->gebruikersnaam, $this->laatsteOnline, $this->email);
			$statement->fetch();
			$statement->close();
		}
		$this->updated = 0; // vanaf dat er een update gebeurt, zal __destruct() dit weten
	}
	
	function __destruct() {
		save();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $db->prepare("UPDATE user SET laatsteOnline = ?, email = ? WHERE id = ?");
			$statement->bind_param("ssi", $this->laatsteOnline, $this->email, $this->id);
			$statement->execute();
			$statement->close();
		}
		$this->updated = 0;
	}
	
	function setLaatsteOnline($tijdstip) {
		// TODO: input sanitizing
		$this->laatsteOnline = $tijdstip;
		$this->updated = 1;
	}
	
	function setEmail($email) {
		if (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email)) {
			$this->email = $email;
			$this->updated = 1;
		} else
			throw new OngeldigeEmailException();
	}
	
	function getId() {
		return $this->id;
	}
	
	function getGebruikersnaam() {
		return $this->gebruikersnaam;
	}
	
	function getLaatsteOnline() {
		return $this->laatsteOnline;
	}
	
	function getEmail() {
		return $this->email;
	}
}

?>
