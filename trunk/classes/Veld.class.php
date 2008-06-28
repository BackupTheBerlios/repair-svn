<?php
require_once("DB.class.php");
require_once("Categorie.class.php");
class Veld {
	
	protected $db;
	
	private $id;
	private $naamNL;
	private $naamEN;
	private $categorieId;
	private $categorie;
	private $homeId;
	private $home;
	private $verwijderd;
	
	private $updated;
	
	/**
	 * Vraagt een veld op uit de databank met gespecifieerd id.
	 *
	 * @param integer $id
	 */
	function __construct($id) {
		$this->db = DB::getDB();
		$this->updated = 0;
		
		if (is_numeric($id) && $id > 0)
			$this->id = $id;
		else throw new Exception(); // TODO: gepaste exception
		
		$statement = $this->db->prepare("SELECT naamNL, naamEN, categorieId, homeId, verwijderd FROM velden WHERE id = ?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		$statement->bind_result($this->naamNL, $this->naamEN, $this->categorieId, $this->homeId, $this->verwijderd);
		$statement->fetch();
		$statement->close();
	}
	
	function __destruct() {
		self::save();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE velden SET naamNL = ?, naamEN = ?, categorieId = ?, homeId = ?, verwijderd = ? WHERE id = ?");
			$statement->bind_param('ssiiii', $this->naamNL, $this->naamEN, $this->categorieId, $this->homeId, $this->verwijderd, $this->id);
			$statement->execute();
			$statement->close();
		}
		
		$this->updated = 0;
	}
	/**
	 * @return Categorie
	 */
	public function getCategorie() {
		if (!isset($this->categorie))
			$this->categorie = new Category($this->categorieId);
			
		return $this->categorie;
	}
	
	/**
	 * @return Home
	 */
	public function getHome() {
		if (!isset($this->home))
			$this->home = new Home("id", $this->homeId);
			
		return $this->home;
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
	public function getNaamEN() {
		return $this->naamEN;
	}
	
	/**
	 * @return string
	 */
	public function getNaamNL() {
		return $this->naamNL;
	}
	
	/**
	 * @return 0 of 1
	 */
	public function getVerwijderd() {
		return $this->verwijderd;
	}
	
	/**
	 * @param Categorie $categorie
	 */
	public function setCategorie($categorie) {
		if (is_a($categorie, "Categorie"))
			$this->categorie = $categorie;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->categorieId = $this->categorie->getId();
		$this->updated = 1;
	}
	
	/**
	 * @param Home $home
	 */
	public function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->homeId = $this->home->getId();
		$this->updated = 1;
	}
	
	/**
	 * @param string $naamEN
	 */
	public function setNaamEN($naamEN) {
		if (strlen($naamEN) > 0)
			$this->naamEN = $naamEN;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;
	}
	
	/**
	 * @param string $naamNL
	 */
	public function setNaamNL($naamNL) {
		if (strlen($naamNL) > 0)
			$this->naamNL = $naamNL;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;	
	}
	
	/**
	 * @param bool $verwijderd
	 */
	public function setVerwijderd($verwijderd) {
		if ($verwijderd == 0 || $verwijderd == 1)
			$this->verwijderd = $verwijderd;
		else throw new Exception(); // TODO: gepaste exception
		
		$this->updated = 1;	
	}

}

?>
