<?php
require_once("DB.class.php");
require_once 'Student.class.php';
require_once 'Personeel.class.php';
class User {
	
	protected $db;
	
	protected $id;
	protected $gebruikersnaam;
	protected $voornaam;
	protected $achternaam;
	protected $laatsteOnline;
	protected $email;
	
	// Is er een veld geupdate? Dan moet er weggeschreven worden in __destruct(), anders niet.
	protected $updated;
	
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
			$statement = $this->db->prepare("INSERT INTO user (gebruikersnaam, voornaam, achternaam, laatsteOnline, email) VALUES (?, ?, ?, NOW(), ?)");
			$statement->bind_param('ssss', $this->gebruikersnaam, $this->voornaam, $this->achternaam, $this->email);
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
			$statement = $this->db->prepare("UPDATE user SET gebruikersnaam = ?, laatsteOnline = ?, voornaam = ?, achternaam = ?, email = ? WHERE id = ?");
			$statement->bind_param("sssssi", $this->gebruikersnaam, $this->laatsteOnline, $this->voornaam, $this->achternaam, $this->email, $this->id);
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
		return $this instanceof Student;
	}
	
	function isPersoneel(){
		return $this instanceof Personeel;
	}
	
	private static $array = array();
	
	/**
	 * Geeft een gebruiker terug. Indien een gebruiker eerder al aangemaakt werd, zal er geen nieuw User-object aangemaakt worden, maar zal het al bestaande object gerecycled worden.
	 *
	 * @param int $id
	 * @return User
	 */
	public static function getUser($id) {
		if (!array_key_exists($id, self::$array)) {
			if(self::isExistingPersoneel($id))
				self::$array[$id] = new Personeel($id);
			else if(self::isExistingStudent($id))
				self::$array[$id] = new Student($id);
			else{
				throw new Exception("de gebruiker is geen student en geen personeel, er klopt iets niet");
				die();
			}
		} 
		return self::$array[$id];
	}
	
	/**
	 * controleert of de gebruiker met deze gebruikersnaam al in onze databank zit
	 * geeft zijn userid terug indien dit het geval is
	 * geeft 0 terug indien hij nog niet bestaat
	 *
	 * @param string $username de te controleren gebruikersnaam
	 * @return het gebruikersid
	 */
	public static function isExistingUser($username){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM user WHERE gebruikersnaam = ?");
		$statement->bind_param('s', $username);
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows==1){
			$statement->bind_result($id);
			$statement->fetch();
			return $id;
		}
		else
			return 0;
	}
	
	/**
	 * checkt of de gebruiker met dit Id een student is
	 *
	 * @param integer $id userid
	 * @return boolean
	 */
	private static function isExistingStudent($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM student WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
	
	/**
	 * checkt of de gebruiker met dit Id personeel is
	 *
	 * @param integer $id userid
	 * @return boolean
	 */
	private static function isExistingPersoneel($id){
		$db = DB::getDB();
		$statement = $db->prepare("SELECT userId FROM personeel WHERE userId = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->store_result();
		return $statement->num_rows==1;
	}
}

?>
