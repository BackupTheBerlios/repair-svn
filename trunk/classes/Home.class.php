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
		//TODO verder afwerken
	}
}
?>