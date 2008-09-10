<?php
require_once("DB.class.php");

class Error {
	
	protected $db;
	
	private $id;
	private $datum;
	private $melding;
	private $file;
	private $lijn;
	private $user;
	
	function __construct($id, $melding="", $file="", $lijn="", $user="") {
		$this->db = DB::getDB();
		$this->id = $id;
		
		if ($this->id == "") {
			// nieuwe fout
			$this->melding=$melding;
			$this->file=$file;
			$this->lijn=$lijn;
			$this->user=$user;
			
			$statement = $this->db->prepare("INSERT INTO error (datum, melding, file, lijn, user) VALUES (NOW(), ?, ?, ?, ?)");
			$statement->bind_param('ssss', $this->melding, $this->file, $this->lijn, $this->user);
			$statement->execute();
			$this->id = $this->db->insert_id;
			$statement->close();
		} else {
			if (!is_numeric($id) || $id < 1) throw new BadParameterException();
			$statement = $this->db->prepare("SELECT datum, melding, file, lijn, user FROM error WHERE id = ?");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($this->datum, $this->melding, $this->file, $this->lijn, $this->user);
			$statement->fetch();
			$statement->close();	
		}
	}
	
	/**
	 * @return unknown
	 */
	public function getDatum() {
		return $this->datum;
	}
	
	/**
	 * @return unknown
	 */
	public function getFile() {
		return $this->file;
	}
	
	/**
	 * @return unknown
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return unknown
	 */
	public function getLijn() {
		return $this->lijn;
	}
	
	/**
	 * @return unknown
	 */
	public function getMelding() {
		return $this->melding;
	}
	
	/**
	 * @return unknown
	 */
	public function getUser() {
		return $this->user;
	}

public function toArray(){
		$lijst = array();
		$lijst['id'] = $this->id;
		$lijst['datum'] = date("Y-m-d",strtotime($this->datum));
		$lijst['melding'] = $this->melding;
		$f = explode("/", $this->file);
		$lijst['file'] = $f[sizeof($f)-1];
		$lijst['lijn'] = $this->lijn;
		$lijst['user'] = $this->user;
		return $lijst;
	}
	
}

?>
