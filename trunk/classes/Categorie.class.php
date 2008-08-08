<?php
require_once("exceptions/BadParameterException.class.php");
require_once("DB.class.php");
require_once("Locatie.class.php");

class Categorie {
	
	protected $db;
	
	private $id;
	private $naamNL;
	private $naamEN;
	private $locatie;
	
	private $updated;
	
	function __construct($id, $naamNL = "", $naamEN = "", $locatie = "kot") {
		$this->db = DB::getDB();
		$this->id = $id;
		
		if ($this->id == "") {
			// deze categorie bestaat nog niet
			$this->naamNL = $naamNL;
			$this->naamEN = $naamEN;
			$this->locatie = new Locatie($locatie);
			
			$statement = $this->db->prepare("INSERT INTO categorie (naamNL, naamEN, locatie) VALUES (?, ?, ?)");
			$statement->bind_param('sss', $this->naamNL, $this->naamEN, $this->locatie->getValue());
			$statement->execute();
			$this->id = $this->db->insert_id;
			$statement->close();
		} else {
			if (!is_numeric($id) || $id < 1) throw new BadParameterException();
			$statement = $this->db->prepare("SELECT naamNL, naamEN, locatie FROM categorie WHERE id = ?");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($this->naamNL, $this->naamEN, $locatie);
			$statement->fetch();
			$statement->close();	
			
			$this->locatie = new Locatie($locatie);
		}
		
		$this->updated = 0;
	}
	
	function __destruct() {
		self::save();	
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE categorie SET naamNL = ?, naamEN = ?, locatie = ? WHERE id = ?");
			$statement->bind_param('sssi', $this->naamNL, $this->naamEN, $this->locatie->getValue(), $this->id);
			$statement->execute();
			$statement->close();
		}
		
		$this->updated = 0;
	}
	
	/**
	 * @return integer
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	function getNaamNL() {
		return $this->naamNL;
	}
	
	/**
	 * @return string
	 */
	function getNaamEN() {
		return $this->naamEN;
	}
	
	/**
	 * @return Locatie
	 */
	function getLocatie() {
		return $this->locatie;
	}
	
	function setNaamNL($naam) {
		if (strlen($naam) > 0)
			$this->naamNL = $naam;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	function setNaamEN($naam) {
		if (strlen($naam) > 0)
			$this->naamEN = $naam;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param Locatie $locatie
	 */
	function setLocatie($locatie) {
		if (is_a($locatie, "Locatie"))
			$this->locatie = $locatie;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * geeft een lijst van alle Categorie objecten uit de databankt terug
	 *
	 * @param String $locatie
	 * @return array<CategorieId,CategorieNaamNL>
	 */
	public static function getCategorien($locatie){
		$lijst = array();
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM categorie WHERE locatie=?");
		$statement->bind_param('s', $locatie);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch()){
			$cat = new Categorie($id);
			$lijst[$cat->getId()] = $cat->getNaamNL();
		}
		$statement->close();
		return $lijst;
	}
}

?>
