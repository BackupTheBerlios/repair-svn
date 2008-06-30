<?php
require_once("DB.class.php");
class User {
	
	protected $db;
	
	protected $id;
	protected $gebruikersnaam;
	protected $voornaam;
	protected $achternaam;
	protected $laatsteOnline;
	protected $email;
	
	// Is er een veld geupdate? Dan moet er weggeschreven worden in __destruct(), anders niet.
	private $updated;
	
	function __construct($id, $gebruikersnaam = "", $voornaam = "", $achternaam = "", $laatsteOnline = "", $email = "") {
		$this->db = DB::getDB();
		if ($id == "") {
			// Dit is een nieuwe User
			if ($gebruikersnaam == "") throw new BadParameterException();
			$this->gebruikersnaam = $gebruikersnaam;
			$this->voornaam = $voornaam;
			$this->achternaam = $achternaam;
			self::setLaatsteOnline($laatsteOnline);
			self::setEmail($email);
			// bepalen van zijn userId
			$statement = $this->db->prepare("INSERT INTO user (gebruikersnaam, voornaam, achternaam, laatsteOnline, email) VALUES (?, ?, ?, ?, ?)");
			$statement->bind_param('sss', $this->gebruikersnaam, $this->voornaam, $this->achternaam, $this->laatsteOnline, $this->email);
			$statement->execute();
			$this->id = $this->db->insert_id;
			$statement->close();
		} else {
			// Al bestaande User
			if (!is_numeric($id)) throw new BadParameterException();
			
			$this->id = $id;
			$statement = $this->db->prepare("SELECT gebruikersnaam, voornaam, achternaam, laatsteOnline, email FROM user WHERE id = ? LIMIT 1");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->bind_result($this->gebruikersnaam, $this->voornaam, $this->achternaam, $this->laatsteOnline, $this->email);
			$statement->fetch();
			$statement->close();
		}
		$this->updated = 0; // vanaf dat er een update gebeurt, zal __destruct() dit weten
	}
	
	function __destruct() {
		self::save();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE user SET laatsteOnline = ?, voornaam = ?, achternaam = ?, email = ? WHERE id = ?");
			$statement->bind_param("ssssi", $this->laatsteOnline, $this->voornaam, $this->achternaam, $this->email, $this->id);
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
	
	static function is_valid_email_address($email){
		$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
		$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
		$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
		$quoted_pair = '\\x5c[\\x00-\\x7f]';
		$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
		$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
		$domain_ref = $atom;
		$sub_domain = "($domain_ref|$domain_literal)";
		$word = "($atom|$quoted_string)";
		$domain = "$sub_domain(\\x2e$sub_domain)*";
		$local_part = "$word(\\x2e$word)*";
		$addr_spec = "$local_part\\x40$domain";

		return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
	}
	
	function setEmail($email) {
		if (self::is_valid_email_address($email)) {
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
	
	function getVoornaam() {
		return $this->voornaam;
	}
	
	function getAchternaam() {
		return $this->achternaam;
	}
	
	function getLaatsteOnline() {
		return $this->laatsteOnline;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function isStudent(){
		return is_a($this, "Student");
	}
	
	function isPersoneel(){
		return is_a($this, "Personeel");
	}
}

?>
