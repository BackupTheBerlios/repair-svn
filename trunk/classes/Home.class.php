<?php
require_once 'exceptions/BadParameterException.class.php';
require_once("DB.class.php");
class Home {
	//databank connectie
	protected $db;
	
	//databank velden
	private $id;
	private $korteNaam;
	private $langeNaam;
	private $adres;
	private $verdiepen;
	private $kamerPrefix;
	private $ldapNaam;
	private $verwijderd;
	
	private $updated;
	
	/**
	 * Haalt een Home object op uit de databank die voldoet aan de opgegeven parameters.
	 * Indien een niet uniek veld wordt opgegeven zal de eerste record die aan de parameters
	 * voldoet aangemaakt worden
	 *
	 * @param String $veld veld van de home
	 * @param String $value waarde van het veld
	 */
	public function __construct($id, $korteNaam="", $langeNaam="", $adres="", $verdiepen="", $kamerPrefix="", $ldapNaam="", $verwijderd="0") {
		$this->db = DB::getDB();
		if($id==""){// nieuwe home
			$this->korteNaam = $korteNaam;
			$this->langeNaam = $langeNaam;
			$this->adres = $adres;
			$this->verdiepen = $verdiepen;
			$this->kamerPrefix = $kamerPrefix;
			$this->ldapNaam = $ldapNaam;
			$this->verwijder = $verwijderd;
			// bepalen van zijn userId
			$statement = $this->db->prepare("INSERT INTO home (korteNaam, langeNaam, adres, verdiepen, kamerPrefix, ldapNaam, verwijderd) VALUES (?,?,?,?,?,?,?)");
			$statement->bind_param('sssissi', $this->korteNaam, $this->langeNaam, $this->adres, $this->verdiepen, $this->kamerPrefix, $this->ldapNaam, $this->verwijderd);
			$statement->execute();
			$this->id = $this->db->insert_id;
			$statement->close();
		}
		else{//bestaande home
			if (!is_numeric($id)) throw new BadParameterException();
			$statement = $this->db->prepare("SELECT id, korteNaam, langeNaam, adres, verdiepen, kamerPrefix, ldapNaam, verwijderd FROM home WHERE id = ?");
			$statement->bind_param('i', $id);
			$statement->execute();
			$statement->bind_result($this->id, $this->korteNaam, $this->langeNaam, 
				$this->adres, $this->verdiepen, $this->kamerPrefix, $this->ldapNaam, $this->verwijderd);
			$statement->fetch();
			$statement->close();
		}
			
		$this->updated = 0;
		
	}
	
	public function __destruct() {
		self::save();
	}
	
	public function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE home SET korteNaam = ?, langeNaam = ?, adres = ?, verdiepen = ?, kamerPrefix = ? , ldapNaam = ?, verwijderd = ? WHERE id = ?");
			$statement->bind_param('sssissii', $this->korteNaam, $this->langeNaam, $this->adres, $this->verdiepen, $this->kamerPrefix, $this->ldapNaam, $this->verwijderd, $this->id);
			$statement->execute();
			$statement->close();
			$this->updated = 0;
		}
	}
	/**
	 * @return string
	 */
	public function getAdres() {
		return $this->adres;
	}
	
	/**
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getKamerPrefix() {
		return $this->kamerPrefix;
	}
	
	/**
	 * @return string
	 */
	public function getKorteNaam() {
		return $this->korteNaam;
	}
	
	/**
	 * @return string
	 */
	public function getLangeNaam() {
		return $this->langeNaam;
	}
	
	public function getLdapNaam() {
		return $this->ldapNaam;
	}
	
	/**
	 * @return integer
	 */
	public function getVerdiepen() {
		return $this->verdiepen;
	}
	
	/**
	 * @param string $adres
	 */
	public function setAdres($adres) {
		if (strlen($adres) > 0)
			$this->adres = $adres;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $kamerPrefix
	 */
	public function setKamerPrefix($kamerPrefix) {
		if (strlen($kamerPrefix) > 0 && strlen($kamerPrefix) < 6)
			$this->kamerPrefix = $kamerPrefix;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $korteNaam
	 */
	public function setKorteNaam($korteNaam) {
		if (strlen($korteNaam) > 0)
			$this->korteNaam = $korteNaam;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $langeNaam
	 */
	public function setLangeNaam($langeNaam) {
		if (strlen($langeNaam) > 0)
			$this->langeNaam = $langeNaam;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $ldapNaam
	 */
	public function setLdapNaam($ldapNaam) {
		if (strlen($ldapNaam) > 0)
			$this->ldapNaam = $ldapNaam;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param integer $verdiepen
	 */
	public function setVerdiepen($verdiepen) {
		if (is_numeric($verdiepen) && $verdiepen > 0)
			$this->verdiepen = $verdiepen;
		else throw new BadParameterException();
		
		$this->updated = 1;
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
		$this->updated = 1;
	}

	public static function getHome($veld, $value) {
		if (strlen($veld) == 0) throw new BadParameterException();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM home WHERE $veld = ?");
		$statement->bind_param('s', $value);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		$statement->fetch();
		$home = new Home($id);
		$statement->close();
		return $home;
	}
	
	/**
	 * Geeft een lijst terug van alle beschikbare Home's
	 *
	 * @return array<Home>
	 */
	public static function getHomes(){
		$lijst = array();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM home");
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch())
			$lijst[] = new Home("id", $id);
		$statement->close();
		return $lijst;
	}
}
?>