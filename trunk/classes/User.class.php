<?php
require_once("DB.class.php");
class User {
	
	protected $db;
	
	protected $id;
	protected $gebruikersnaam;
	protected $laatsteOnline;
	protected $email;
	
	function __construct($id) {
		$this->id = $id;
		$db = DB::getDB();
		$statement = $db->prepare("SELECT gebruikersnaam, laatsteOnline, email FROM user WHERE id = ? LIMIT 1");
		$statement->bind_param("i", $id);
		$statement->execute();
		$statement->bind_result($this->gebruikersnaam, $this->laatsteOnline, $this->email);
		$statement->fetch();
		$statement->close();
	}
	
	function __destruct() {
		$statement = $db->prepare("UPDATE user SET laatsteOnline = ?, email = ? WHERE id = ?");
		$statement->bind_param("s", $this->laatsteOnline);
		$statement->bind_param("s", $this->email);
		$statement->bind_param("i", $this->id);
		$statement->execute();
		$statement->close();
	}
	
	function setLaatsteOnline($tijdstip) {
		// TODO: input sanitizing
		$this->laatsteOnline = $tijdstip;
	}
	
	function setEmail($email) {
		if (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email)) {
			$this->email = $email;
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
