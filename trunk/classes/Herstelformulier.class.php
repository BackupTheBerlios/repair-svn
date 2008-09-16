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
	function __construct($id, $datum = "", $status = "", $student = "", $opmerking = "", $veldenlijst = "") {
		$this->db = DB::getDB();
		
		if ($id == "") {
			// nieuw herstelformulier
			self::setDatum($datum);
			
			if (is_a($status, "Status"))
				$this->status = $status;
			else throw new BadParameterException("supplied Status is not a Status object");
			
			if (is_a($student, "Student"))
				$this->student = $student;
			else throw new BadParameterException("supplied Student is not a Student object");
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
			$statement = $this->db->prepare("UPDATE herstelformulier SET factuurnummer = ?, datum = ?, status = ?, userId = ?, kamer = ?, homeId = ?, opmerking = ? WHERE id = ?");
			$statement->bind_param('issisisi', $this->factuurnummer, $this->datum, $this->status->getValue(), $this->studentId, $this->kamer->getKamernummerLang(), $this->homeId, $this->opmerking, $this->id);
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
			$this->home = new Home($this->homeId);
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
	        } else throw new BadParameterException("supplied date is invalid");
	    } else throw new BadParameterException("supplied date is invalid");
	    
	    $this->updated = 1;
	}
	
	/**
	 * @param Home $home
	 */
	public function setHome($home) {
		if (is_a($home, "Home"))
			$this->home = $home;
		else throw new BadParameterException("supplied Home is not a Home object");
		
		$this->homeId = $this->home->getId();
		
		$this->updated = 1;
	}

	
	/**
	 * @param Kamer $kamer
	 */
	public function setKamer($kamer) {
		if (is_a($kamer, "Kamer"))
			$this->kamer = $kamer;
		else throw new BadParameterException("supplied Kamer is not a Kamer object");
		
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
		else throw new BadParameterException("supplied status is no Status object");
		
		$this->updated = 1;
	}
	
	/**
	 * @param Student $student
	 */
	public function setStudent($student) {
		if (is_a($student, "Student"))
			$this->student = $student;
		else throw new BadParameterException("supplied student is no Student object");
		
		$this->studentId = $this->student->getId();
		
		$this->updated = 1;
	}

	public function setVeldenlijst($veldenlijst) {
		$statement = $this->db->prepare("DELETE FROM relatie_herstelformulier_velden WHERE herstelformulierId = ?");
		$statement->bind_param('i', $this->id);
		$statement->execute();
		
		$statement = $this->db->prepare("INSERT INTO relatie_herstelformulier_velden (herstelformulierId, veldId) VALUES (?, ?)");
		foreach ($veldenlijst as $veldId) {
			$statement->bind_param('ii', $this->id, $veldId);
			$statement->execute();
		}
		$statement->close();
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
			$output .= $veld->getNaam().", ";
		}
		$opmerking = self::getOpmerking();
		if ($opmerking != "") {
			$output .= $opmerking;
			return $output;
		} else
			return substr($output, 0, -2);
	}
	
	public function getFactuurnummer($veldid) {
		$statement = $this->db->prepare("SELECT referentienummer FROM relatie_herstelformulier_veld WHERE veldid = ? AND herstelformulierId = ?");
		$statement->bind_param('ii', $veldid, $this->id);
		$statement->bind_result($referentienummer);
		return $referentienummer;	
	}
	
	public function setFactuurnummer($veldid, $factuurnummer) {
		$statement = $this->db->prepare("INSERT INTO relatie_herstelformulier_veld (herstelformulierId, veldId, referentienummer) VALUES (?, ?, ?)");
		$statement->bind_param('iis', $this->id, $veldid, $factuurnummer);
		$statement->execute();
		$statement->close();
	}
	
	public function toArray(){
		$lijst = array();
		$lijst['id'] = $this->id;
		$lijst['datum'] = date("Y-m-d",strtotime($this->datum));
		$lijst['status'] = $this->status->getValue();
		$lijst['kamer'] = $this->kamer->getKamernummerLang();
		$lijst['factuurnummer'] = $this->factuurnummer==null?"":$this->factuurnummer;
		$lijst['persoon'] = $this->getStudent()->getVoornaam()." ".$this->getStudent()->getAchternaam();
		$lijst['home'] = $this->getHome()->getKorteNaam();
		return $lijst;
	}
	
	/**
	 * Geeft een lijst van Herstelformulieren terug. Je kan zoeken op userId en/of status. Indien enkel userId opgegeven is, zal je alle herstelformulieren terugkrijgen voor deze gebruiker. Indien je enkel de status opgeeft, zal je alle herstelformulieren terugkrijgen van alle gebruikers met die status.
	 *
	 * @param integer(optioneel) $userId
	 * @param Status(optioneel) $status
	 * @return list<Status=>Herstelformulier>
	 */
	static function getList($userId = 0, $searchStatus = "") {
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 0) throw new BadParameterException("userId is invalid");
		
		if ($searchStatus == "") {
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE userId = ? ORDER BY status, datum DESC");
			$statement->bind_param('i', $userId);
		} else if ($userId == 0) {
			if ($searchStatus == "") throw new BadParameterException();
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE status = ? ORDER BY datum DESC");
			$statement->bind_param('s', $searchStatus->getValue());
		} else {
			if (!is_a($searchStatus, "Status")) throw new BadParameterException("supplied status is no Status object");
			
			$statement = $db->prepare("SELECT id, status FROM herstelformulier WHERE userId = ? AND status = ? ORDER BY datum DESC");
			$statement->bind_param('is', $userId, $searchStatus->getValue());
		}
		$statement->execute();
		$statement->bind_result($id, $status);
		$statement->store_result();
		while ($statement->fetch()) {
			if (!isset($lijst[$status])) $lijst[$status] = Array();
			$tmp = $lijst[$status];
			$tmp[] = new Herstelformulier($id);
			$lijst[$status] = $tmp;
		}
		$statement->free_result();
		$statement->close();
		
		if ($searchStatus == "")
			return $lijst;
		else
			return $lijst[$searchStatus->getValue()];
	}
	
	/**
	 * Geeft een lijst van Herstelformulieren terug. De eerste parameter zijn de homes van de herstelformulieren, de tweede parameter is de status
	 *
	 * @param integer(optioneel) $userId
	 * @param Status(optioneel) $status
	 * @return list<Status=>Herstelformulier>
	 */
	static function getPersoneelList($homes, $searchStatus = "") {
		$db = DB::getDB();
		$lijst = Array();
		if(sizeof($homes)<1)
			throw new BadParameterException("Je moet minstens 1 home opgeven voor de methode getPersoneelList");
		
		$homequery = "(";
		foreach($homes as $home){
			$homequery.= "home.korteNaam = '$home' OR ";
		}
		$homequery = substr($homequery, 0, -3).")";
		
		if ($searchStatus == "") {
			$statement = $db->prepare("SELECT herstelformulier.id, status FROM herstelformulier INNER JOIN home ON (herstelformulier.homeId = home.id) WHERE $homequery ORDER BY status, datum DESC");
		}
		else {
			if (!is_a($searchStatus, "Status")) throw new BadParameterException("supplied status is no Status object");
			
			$statement = $db->prepare("SELECT herstelformulier.id, status FROM herstelformulier INNER JOIN home ON (herstelformulier.homeId = home.id) WHERE $homequery AND status = ? ORDER BY datum DESC");
			$statement->bind_param('s', $searchStatus->getValue());
		}
		$statement->execute();
		$statement->bind_result($id, $status);
		$statement->store_result();
		while ($statement->fetch()) {
			if (!isset($lijst[$status])) $lijst[$status] = Array();
			$tmp = $lijst[$status];
			$tmp[] = new Herstelformulier($id);
			$lijst[$status] = $tmp;
		}
		$statement->free_result();
		$statement->close();
		
		if ($searchStatus == "")
			return $lijst;
		else
			return $lijst[$searchStatus->getValue()];
	}
	
	/**
	 * geeft een lijst van maximaal $aantal items terug met Herstelformulier objecten horende bij het opgegeven userid
	 *
	 * @param integer $userId
	 * @param integer(optional) $aantal
	 * @return array[herstelformulierobject] een lijst van Herstelformulier objecten
	 */
	static function getLatest($userId, $aantal = -1){
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 1 || !is_numeric($aantal)) throw new BadParameterException("userId or aantal is invalid");		
		
		$statement = $db->prepare("SELECT id FROM herstelformulier WHERE userId = ? AND (status = 'ongezien' OR status = 'gedaan' ) ORDER BY status, datum DESC LIMIT ?");
		$statement->bind_param('ii', $userId, $aantal);
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch()) 
			$lijst[] = new Herstelformulier($id);
		$statement->free_result();
		$statement->close();
		return $lijst;
	}
	
	/**
	 * Geeft een lijst van door studenten te evalueren herstelformulieren terug.
	 *
	 * @param int $userId
	 * @return array<Herstelformulier>
	 */
	static function getEvaluationList($userId = 0) {
		$db = DB::getDB();
		$lijst = Array();
		if (!is_numeric($userId) || $userId < 0) throw new BadParameterException("userId is invalid");
		
		if ($userId == 0)
			$statement = $db->prepare("SELECT id FROM herstelformulier WHERE status = 'gedaan' AND datum < SUBDATE(NOW(), INTERVAL ".Config::$DAYS_FOR_EVAL." DAY) ORDER BY datum DESC");
		else {
			$statement = $db->prepare("SELECT id FROM herstelformulier WHERE userId = ? AND status = 'gedaan' AND datum < SUBDATE(NOW(), INTERVAL ".Config::$DAYS_FOR_EVAL." DAY) ORDER BY datum DESC");
			$statement->bind_param('i', $userId);
		}
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch())
			$lijst[] = new Herstelformulier($id);
		$statement->free_result();
		$statement->close();
		
		return $lijst;
	}

	/**
	 * Geeft een lijst van herstelformulieren terug voor een kamer.
	 *
	 * @param Kamer $kamer
	 * @return array<Herstelformulier>
	 */
	static function getKamerList($kamer) {
		if (!is_a($kamer, "Kamer")) throw new BadParameterException("kamer is geen Kamer object");
		
		$db = DB::getDB();
		$statement = $db->prepare("SELECT id FROM herstelformulier WHERE kamer = ? ORDER BY datum DESC");
		$statement->bind_param('i', $kamer->getKamernummerLang());
		$statement->execute();
		$statement->bind_result($id);
		$statement->store_result();
		while ($statement->fetch())
			$lijst[] = new Herstelformulier($id);
		$statement->free_result();
		$statement->close();
		
		return $lijst;
	}
	
	/**
	 * statistiek functies
	 */
	static function getAantalFormulieren($categorie, $homeId=""){
		$db = DB::getDB();
		if($homeId==""){
			$statement = $db->prepare("SELECT count(datum), DATE(datum) FROM herstelformulier INNER JOIN relatie_herstelformulier_velden ON (herstelformulier.id=relatie_herstelformulier_velden.herstelformulierId) INNER JOIN velden ON (relatie_herstelformulier_velden.veldId=velden.id) INNER JOIN categorie ON (velden.categorieId = categorie.id) WHERE categorie.naamNL=? GROUP BY DATE(datum) ORDER BY datum ASC");
			$statement->bind_param('s', $categorie);
		}
		else{
			$statement = $db->prepare("SELECT count(datum), DATE(datum) FROM herstelformulier INNER JOIN relatie_herstelformulier_velden ON (herstelformulier.id=relatie_herstelformulier_velden.herstelformulierId) INNER JOIN velden ON (relatie_herstelformulier_velden.veldId=velden.id) INNER JOIN categorie ON (velden.categorieId = categorie.id) WHERE categorie.naamNL=? AND velden.homeId=? GROUP BY DATE(datum) ORDER BY datum ASC");
			$statement->bind_param('si', $categorie, $homeId);
		}
		$statement->execute();
		$statement->bind_result($aantal, $datum);
		$statement->store_result();
		while ($statement->fetch())
			$lijst[] = array($datum, $aantal);
		$statement->free_result();
		$statement->close();
		
		return $lijst;
		
	}
}

?>
