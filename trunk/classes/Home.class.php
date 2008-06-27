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
	
	/**
	 * Haalt een Home object op uit de databank die voldoet aan de opgegeven parameters.
	 * Indien een niet uniek veld wordt opgegeven zal de eerste record die aan de parameters
	 * voldoet aangemaakt worden
	 *
	 * @param String $veld veld van de home
	 * @param String $value waarde van het veld
	 */
	public function __construct($veld, $value){
		$this->db = DB::getDB();
		$statement = $this->db->prepare("SELECT id, korteNaam, langeNaam, adres, verdiepen, kamerPrefix FROM items WHERE $veld = ?");
		$statement->bind_param('s', $value);
		$statement->execute();
		$statement->bind_result($this->id, $this->korteNaam, $this->langeNaam, 
			$this->adres, $this->verdiepen, $this->kamerPrefix);
		$statement->fetch();
		$statement->close();
	}
}
?>