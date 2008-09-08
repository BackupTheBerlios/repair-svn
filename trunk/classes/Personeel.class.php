<?php

require_once ('User.class.php');

class Personeel extends User {
	
	protected $db;
	private $verwijderd;
	private $mails;
	
	function __construct($id, $gebruikersnaam="", $voornaam="", $achternaam="", $laatsteOnline="", $email="", $mails=1, $verwijderd="0") {
		if($id==""){//nieuw personeel
			parent::__construct($id, $gebruikersnaam, $voornaam, $achternaam, $laatsteOnline, $email);
			$this->verwijderd = $verwijderd;
			$this->mails = $mails;
			if(self::isInPersoneelDatabase($this->id)){
				self::setVerwijderd(0);
				self::setMails($this->mails);
				self::save();
			}
			else{
				echo"ik ga personeel toevoegen aan de databank";
				$statement = $this->db->prepare("INSERT INTO personeel (userId, mails, verwijderd) VALUES (?, ?, ?)");
				echo $this->db->error;
				$statement->bind_param('iii', $this->id, $this->mails, $this->verwijderd);
				$statement->execute();
				$statement->close();
			}
		}
		else{
			if (!is_numeric($id)) throw new BadParameterException();
			parent::__construct ($id);
			$this->db =  DB::getDB();
			$statement = $this->db->prepare("SELECT verwijderd, mails FROM personeel WHERE userId = ?");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($this->verwijderd, $this->mails);
			$statement->fetch();
			$statement->close();
		}
		$this->updated = 0;
	}
	
	function __destruct() {
		self::save();
		parent::__destruct();
	}
	
	function save() {
		if ($this->updated == 1) {
			parent::save();
			$statement = $this->db->prepare("UPDATE personeel SET verwijderd = ?, mails=? WHERE userId = ?");
			$statement->bind_param('iii', $this->verwijderd, $this->mails, $this->id);
			$statement->execute();
			$statement->close();
		}
		$this->updated = 0;
	}
	
	/**
	 * @return unknown
	 */
	public function getVerwijderd() {
		return $this->verwijderd;
	}
	
	/**
	 * @param unknown_type $verwijderd
	 */
	public function setVerwijderd($verwijderd) {
		$this->verwijderd = $verwijderd;
		$this->updated = true;
	}
	
	/**
	 * @return unknown
	 */
	public function getMails() {
		return $this->mails;
	}
	
	/**
	 * @param unknown_type $mails
	 */
	public function setMails($mails) {
		$this->mails = $mails;
		$this->updated = true;
	}

	/**
	 * geeft een lijst van alle beheerders terug
	 *
	 * @return array[Personeel]
	 */
	public static function getBeheerders(){
		$lijst = array();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM personeel WHERE verwijderd='0'");
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch())
			$lijst[] = new Personeel($id);
		$statement->close();
		return $lijst;
	}
	
	public function setGebruikersnaam($uid){
		$this->gebruikersnaam = $uid;
		$this->updated = 1;
	}
	
	/**
	 * Geeft lijst van Homes voor deze Homemanager terug.
	 *
	 * @return list[Home]
	 */
	function getHomesLijst() {
		$lijst = array();
		$statement = $this->db->prepare("SELECT homeId FROM relatie_personeel_home WHERE personeelId=?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch())
			$lijst[] = new Home($id);
		$statement->close();
		return $lijst;
	}
	
	function setHomes($lijst){
		//eerst huidige homes wissen
		$statement = $this->db->prepare("DELETE FROM relatie_personeel_home WHERE personeelId=?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement = $this->db->prepare("INSERT INTO relatie_personeel_home (personeelId, homeId) VALUES (?, ?)");
		foreach($lijst as $id){
			$statement->bind_param('ii', $this->id, $id);
			$statement->execute();
		}
	}
	
	function isInPersoneelDatabase($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM personeel WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
}

?>
