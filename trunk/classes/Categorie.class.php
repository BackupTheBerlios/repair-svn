<?php
require_once("DB.class.php");
require_once("Locatie.class.php");

class Categorie {
	
	protected $db;
	
	private $id;
	private $naamNL;
	private $naamEN;
	private $locatie;
	
	private $updated;
	
	function __construct($id) {
		$this->db = DB::getDB();
		$this->id = $id;
		$this->updated = 0;
		
		$statement = $this->db->prepare("SELECT naamNL, naamEN, locatie FROM categorie WHERE id = ?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement->bind_result($this->naamNL, $this->naamEN, $locatie);
		$statement->fetch();
		$statement->close();	
		
		$this->locatie = new Locatie($locatie);
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
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	function setNaamEN($naam) {
		if (strlen($naam) > 0)
			$this->naamEN = $naam;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param Locatie $locatie
	 */
	function setLocatie($locatie) {
		if (is_a($locatie, "Locatie"))
			$this->locatie = $locatie;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
}

?>
