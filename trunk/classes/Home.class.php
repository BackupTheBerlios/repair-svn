<?php
require_once("DB.class.php");
class Home{
	//databank connectie
	protected $db;
	
	//databank velden
	public $id;
	public $korteNaam;
	public $langeNaam;
	public $adres;
	public $verdiepen;
	public $kamerPrefix;
	
	public function __construct($id){
		$this->db = DB::getDB();
		$statement = $this->db->prepare("SELECT id, korteNaam, langeNaam, adres, verdiepen, kamerPrefix FROM items WHERE id = ?");
		$statement->bind_param('i', $id);
		$statement->execute();
		$statement->bind_result($this->id, $this->korteNaam, $this->langeNaam, 
			$this->adres, $this->verdiepen, $this->kamerPrefix);
		$statement->fetch();
		$statement->close();
	}
}
?>