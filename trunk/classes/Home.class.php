<?php
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
	
	private $updated;
	
	/**
	 * Haalt een Home object op uit de databank die voldoet aan de opgegeven parameters.
	 * Indien een niet uniek veld wordt opgegeven zal de eerste record die aan de parameters
	 * voldoet aangemaakt worden
	 *
	 * @param String $veld veld van de home
	 * @param String $value waarde van het veld
	 */
	public function __construct($veld, $value) {
		$this->db = DB::getDB();
		$statement = $this->db->prepare("SELECT id, korteNaam, langeNaam, adres, verdiepen, kamerPrefix FROM home WHERE $veld = ?");
		$statement->bind_param('s', $value);
		$statement->execute();
		$statement->bind_result($this->id, $this->korteNaam, $this->langeNaam, 
			$this->adres, $this->verdiepen, $this->kamerPrefix);
		$statement->fetch();
		$statement->close();
		
		$this->updated = 0;
	}
	
	public function __destruct() {
		self::save();
	}
	
	public function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE home SET korteNaam = ?, langeNaam = ?, adres = ?, verdiepen = ?, kamerPrefix = ? WHERE id = ?");
			$statement->bind_param('sssisi', $this->korteNaam, $this->langeNaam, $this->adres, $this->verdiepen, $this->kamerPrefix, $this->id);
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
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $kamerPrefix
	 */
	public function setKamerPrefix($kamerPrefix) {
		if (strlen($kamerPrefix) > 0 && strlen($kamerPrefix) < 6)
			$this->kamerPrefix = $kamerPrefix;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $korteNaam
	 */
	public function setKorteNaam($korteNaam) {
		if (strlen($korteNaam) > 0)
			$this->korteNaam = $korteNaam;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $langeNaam
	 */
	public function setLangeNaam($langeNaam) {
		if (strlen($langeNaam) > 0)
			$this->langeNaam = $langeNaam;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param integer $verdiepen
	 */
	public function setVerdiepen($verdiepen) {
		if (is_numeric($verdiepen) && $verdiepen > 0)
			$this->verdiepen = $verdiepen;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}

}
?>