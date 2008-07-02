<?php
require_once("DB.class.php");
require_once("Kamer.class.php");
require_once("Home.class.php");
require_once("Status.class.php");
require_once 'Veld.class.php';

class Herstelformulier {
	
	protected $db;
	
	private $id;
	private $datum;
	private $status;
	private $studentId;
	private $student;
	private $kamer;
	private $home;
	private $homeId;
	private $opmerking;
	
	// List<Veldid>
	private $veldenlijst;
	
	private $updated;
	
	/**
	 * Maakt een herstelformulier. Met enkel $id gespecifieerd zal het herstelformulier met id = $id uit de database gehaald worden, 
	 * anders wordt aan de hand van de andere parameters een nieuw herstelformulier gemaakt.
	 * Het herstelformulier schrijft zichzelf weg wanneer het object verwijderd wordt.
	 *
	 * @param integer $id
	 * @param datetime $datum
	 * @param Status $status
	 * @param Student $student
	 * @param string $opmerking
	 * @param List<veldid> $veldenlijst
	 */
	function __construct($id, $datum = "", $status = "", $student = "", $opmerking = "", $veldenlijst = "") { // TODO: veldenlijst implementeren
		$this->db = DB::getDB();
		
		if ($id == "") {
			// nieuw herstelformulier
			self::setDatum($datum);
			
			if (is_a($status, "Status"))
				$this->status = $status;
			else throw new BadParameterException();
			
			if (is_a($student, "Student"))
				$this->student = $student;
			else throw new BadParameterException();
			$this->studentId = $this->student->getId();
			
			$this->kamer = $this->student->getKamer();
			$this->home = $this->student->getHome();
			$this->homeId = $this->home->getId();
			$this->opmerking = $opmerking;
			$this->veldenlijst = $veldenlijst;
			
			// bepalen van zijn herstelformulierId
			$statement = $this->db->prepare("INSERT INTO herstelformulier (datum, status, userId, kamer, homeId, opmerking) VALUES (?, ?, ?, ?, ?, ?)");
			$statement->bind_param('ssisis', $this->datum, $this->status->getValue(), $this->studentId, $this->kamer->getKamernummerLang(), $this->homeId, $this->opmerking);
			$statement->execute();
			$this->id = $this->db->insert_id;
			$statement->close();
			
			$statement = $this->db->prepare("INSERT INTO relatie_herstelformulier_velden (herstelformulierId, veldId) VALUES (?, ?)");
			foreach ($this->veldenlijst as $key => $veldId) {
				$statement->bind_param('ii', $this->id, $veldId);
				$statement->execute();
			}
			$statement->close();
		} else {
			// bestaand herstelformulier opvragen
			if (!is_numeric($id)) throw new BadParameterException();
			
			$this->id = $id;
			$statement = $this->db->prepare("SELECT datum, status, userId, kamer, homeId, opmerking FROM herstelformulier WHERE id = ? LIMIT 1");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($this->datum, $status, $this->studentId, $kamer, $this->homeId, $this->opmerking);
			$statement->fetch();
			$statement->close();
			$this->status = new Status($status);
			$this->kamer = new Kamer($kamer);
			
			$statement = $this->db->prepare("SELECT veldid FROM relatie_herstelformulier_velden WHERE herstelformulierId = ?");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($veldid);
			while ($statement->fetch())
				$this->veldenlijst[] = $veldid;
			$statement->close();
		}
		
		$this->updated = 0;
	}
	
	function __destruct() {
		self::save();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $this->db->prepare("UPDATE herstelformulier SET datum = ?, status = ?, userId = ?, kamer = ?, homeId = ?, opmerking = ? WHERE id = ?");
			$statement->bind_param('ssisisi', $this->datum, $this->status->getValue(), $this->studentId, $this->kamer->getKamernummerLang(), $this->homeId, $this->opmerking, $this->id);
			$statement->execute();
			$statement->close();
		}
		$this->updated = 0;
	}
	/**
	 * @return datetime
	 */
	public function getDatum() {
		return $this->datum;
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
	 * @return Kamer
	 */
	public function getKamer() {
		return $this->kamer;
	}
	
	/**
	 * @return String
	 */
	public function getOpmerking() {
		return $this->opmerking;
	}
	
	/**
	 * @return Status
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * @return Student
	 */
	public function getStudent() {
		if (!isset($this->student))
			$this->student = new Student($this->studentId);
		return $this->student;
	}
	
	/**
	 * @param datetime $datum
	 */
	public function setDatum($datum) {
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $datum, $matches)) {
	        if (checkdate($matches[2], $matches[3], $matches[1])) {
	            $this->datum = $datum;
	        } else throw new BadParameterException();
	    } else throw new BadParameterException();
	    
	    $this->updated = 1;
	}
	
	/**
	 * @param Home $home
	 */
	public function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else throw new BadParameterException();
		
		$this->homeId = $this->home->getId();
		
		$this->updated = 1;
	}

	
	/**
	 * @param Kamer $kamer
	 */
	public function setKamer($kamer) {
		if (is_a($kamer, "Kamer"))
			$this->kamer = $kamer;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param String $opmerking
	 */
	public function setOpmerking($opmerking) {
		$this->opmerking = $opmerking;
		
		$this->updated = 1;
	}
	
	/**
	 * @param Status $status
	 */
	public function setStatus($status) {
		if (is_a($status, "Status"))
			$this->status = $status;
		else throw new BadParameterException();
		
		$this->updated = 1;
	}
	
	/**
	 * @param Student $student
	 */
	public function setStudent($student) {
		if (is_a($student, "Student"))
			$this->student = $student;
		else throw new BadParameterException();
		
		$this->studentId = $this->student->getId();
		
		$this->updated = 1;
	}

	/**
	 * @return array(veldid)
	 */
	public function getVeldenlijst() {
		return $this->veldenlijst;
	}

	public function getSamenvatting(){
		$output="";
		for($i=0; $i < sizeof($this->veldenlijst); $i++){
			$veld = new Veld($this->veldenlijst[$i]);
			$output .= $veld->getNaamNL().", ";//TODO taal onafhankelijk maken
		}
		return substr($output, 0, -2);
	}
}

?>
