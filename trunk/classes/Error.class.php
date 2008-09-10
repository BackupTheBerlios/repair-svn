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
	
}

?>
