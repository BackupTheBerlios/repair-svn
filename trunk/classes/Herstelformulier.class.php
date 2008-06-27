<?php
require_once("DB.class.php");
class Herstelformulier {
	
	protected $db;
	
	private $id;
	private $datum;
	private $status;
	private $student;
	private $kamer;
	private $home;
	private $opmerking;
	private $veldenlijst;
	
	private $updated;
	
	/**
	 * Maakt een herstelformulier. Met enkel $id gespecifieerd zal het herstelformulier met id = $id uit de database gehaald worden, anders wordt aan de hand van de andere parameters een nieuw herstelformulier gemaakt.
	 * Het herstelformulier schrijft zichzelf weg wanneer het object verwijderd wordt.
	 *
	 * @param integer $id
	 * @param datetime $datum
	 * @param Status $status
	 * @param Student $student
	 * @param string $opmerking
	 * @param unknown_type $veldenlijst
	 */
	function __construct($id, $datum = "", $status = "", $student = "", $opmerking = "", $veldenlijst = "") { // TODO: veldenlijst implementeren
		if (!is_numeric($id)) throw new Exception(); // TODO: gepaste exception
		
		if ($id == "") {
			// nieuw herstelformulier
			setDatum($datum);
			
			if (is_a($status, "Status"))
				$this->status = $status;
			else throw new Exception(); // TODO: gepaste exception
			
			if (is_a($student, "Student"))
				$this->student = $student;
			else throw new Exception(); // TODO: gepaste exception
			
			$this->kamer = $this->student->getKamer();
			$this->home = $this->student->getHome();
			$this->opmerking = $opmerking;
			$this->veldenlijst = $veldenlijst;
			
			// bepalen van zijn herstelformulierId
			$statement = $db->prepare("INSERT INTO herstelformulier (datum, status, userId, kamer, homeId, opmerking) VALUES (?, ?, ?, ?, ?, ?)");
			$statement->bind_param('ssisis', $this->datum, $this->status->getValue(), $this->student->getId(), $this->kamer->getKamernummerLang(), $this->home->getId(), $this->opmerking);
			$statement->execute();
			$this->id = $db->insert_id;
			$statement->close();
		} else {
			// bestaand herstelformulier opvragen
			$this->id = $id;
			$statement = $db->prepare("SELECT datum, status, userId, kamer, homeId, opmerking FROM herstelformulier WHERE id = ? LIMIT 1");
			$statement->bind_param('i', $this->id);
			$statement->execute();
			$statement->bind_result($this->datum, $status, $userId, $kamer, $homeId, $this->opmerking);
			$statement->fetch();
			$statement->close();
			$this->status = new Status($status);
			$this->student = new Student($userId);
			$this->kamer = new Kamer($kamer);
			$this->home = new Home("id", $homeId);
		}
		
		$this->updated = 0;
	}
	
	function __destruct() {
		save();
	}
	
	function save() {
		if ($this->updated == 1) {
			$statement = $db->prepare("UPDATE herstelformulier SET datum = ?, status = ?, userId = ?, kamer = ?, homeId = ?, opmerking = ? WHERE id = ?");
			$statement->bind_param('ssisisi', $this->datum, $this->status->getValue(), $this->student->getId(), $this->kamer->getKamernummerLang(), $this->home->getId(), $this->opmerking, $this->id);
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
		return $this->student;
	}
	
	/**
	 * @param datetime $datum
	 */
	public function setDatum($datum) {
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $datum, $matches)) {
	        if (checkdate($matches[2], $matches[3], $matches[1])) {
	            $this->datum = $datum;
	        } else throw new Exception(); // TODO: gepaste exception
	    } else throw new Exception(); // TODO: gepaste exception
	}
	
	/**
	 * @param Home $home
	 */
	public function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else throw new Exception(); // TODO: gepaste exception
	}
	
	/**
	 * @param integer $id
	 */
	public function setId($id) {
		if (is_numeric($id))
			$this->id = $id;
		else throw new Exception(); // TODO: gepaste exception
	}
	
	/**
	 * @param Kamer $kamer
	 */
	public function setKamer($kamer) {
		if (is_a($kamer, "Kamer"))
			$this->kamer = $kamer;
		else throw new Exception(); // TODO: gepaste exception
	}
	
	/**
	 * @param String $opmerking
	 */
	public function setOpmerking($opmerking) {
		$this->opmerking = $opmerking;
	}
	
	/**
	 * @param Status $status
	 */
	public function setStatus($status) {
		if (is_a($status, "Status"))
			$this->status = $status;
		else throw new Exception(); // TODO: gepaste exception
	}
	
	/**
	 * @param Student $student
	 */
	public function setStudent($student) {
		if (is_a($student, "Student"))
			$this->student = $student;
		else throw new Exception(); // TODO: gepaste exception
	}

}

?>
