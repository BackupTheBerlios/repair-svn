<?php
class LDAP {
	private $connection;
	private $server; //ldap server
	private $port;
	private $connection_string; // connection string
	private $password;
	private $base_dn;
	
	private $search_result;
	private $data;
	
	function __construct($server = null, $port = null, $connection_string = null, $password = null, $base_dn = null) {
		if (empty ( $server )) {
			$this->server = "ldaps://ldaps.ugent.be";
		} 
		else {
			$this->server = $server;
		}
		
		if (empty ( $port )) {
			$this->port = 636;
		} 
		else {
			$this->port = $port;
		}
		
		if (empty ( $connection_string )) {
			$this->connection_string = "";
		} 
		else {
			$this->connection_string = $connection_string;
		}
		
		if (empty ( $password )) {
			$this->password = "";
		} 
		else {
			$this->password = $password;
		}
		
		if (empty ( $base_dn )) {
			$this->base_dn = "ou=people,dc=UGent,dc=be";
		} 
		else {
			$this->base_dn = $base_dn;
		}
	}
	
	function connect() {
		$this->connection = ldap_connect ( $this->server, $this->port );
		//echo get_resource_type( $this->connection )."\n";
	}
	
	function bind() {
		if ($this->connection) {
			if (empty ( $this->connection_string )) {
				// Anonymous
				ldap_bind ( $this->connection );
			} else {
				ldap_bind ( $this->connection, $this->connection_string, $this->password );
			}
		
		}
	}
	
	function search($filter) {
		$this->search_result = null;
		
		if ($this->connection) {
			$this->search_result = ldap_search ( $this->connection, $this->base_dn, $filter );
		}
	}
	
	function get_entries() {
		$this->data = null;
		
		if ($this->connection) {
			if ($this->search_result) {
				$this->data = ldap_get_entries ( $this->connection, $this->search_result );
				
				return $this->data;
			}
		}
	}
	
	function close() {
		if ($this->connection) {
			ldap_close ( $this->connection );
		}
	
	}
}

class LdapRepair extends LDAP{
	function __construct (){
		parent::__construct(null,null, "cn=herstelformulier,ou=applications,dc=UGent,dc=be", "Abracadabra+1");
	}
	
	/**
	 * functie om gemakkelijk de userinfo op te halen aan de hand van de username
	 *
	 * @param unknown_type $uid ugent username
	 * @return Array
	 */
	function getUserInfo($uid){
		parent::connect();
		parent::bind();
		parent::search("uid=".$uid);
		return self::parseData(parent::get_entries());
	}
	
	function getUserInfo2($uid){
		parent::connect();
		parent::bind();
		parent::search("uid=".$uid);
		return parent::get_entries();
	}
	
	function parseData($data){
		$result = array();
		$result['gebruikersnaam'] = $data[0]["uid"][0];
		$result['voornaam'] = $data[0]["ugentpreferredgivenname"][0];
		$result['achternaam'] = $data[0]["ugentpreferredsn"][0];
		$result['email'] = $data[0]["mail"][0];
		$kot = $data[0]["ugentdormpostaladdress"][0];
		if($kot!=""){
			$kot = explode("$", $kot);
			if(strpos(" ".$kot[0], "HOME")){
				//VUILE LDAP HACK :(
				$kot[0] = $kot[0]=="HOME BERTHA DE VRIES"?"HOME BERTHA DE VRIESE":$kot[0];
				require_once 'classes/Home.class.php';
				$home = Home::getHome("ldapNaam", $kot[0]);
				$result['homeId'] = $home->getId();
				$result['home'] = $home->getLangeNaam();
				$temp = explode(":", $kot[1]);
				if(sizeof($temp)>1)
					$result['kamer'] = $temp[1];//het meest normale geval (volledige kamercode staat waar hij moest staan)
				else{
					$temp = explode("(", $kot[1]);
					$temp = explode(")", $temp[1]);
					if(sizeof($temp)>1)
						$result['kamer'] = $home->getKamerPrefix().".".$temp[0];//enkel de laatste cijfers van de code staan tussen haakjes
					else{
						echo "jep";
						$temp = explode("K. ", $kot[1]);
						$result['kamer'] = $home->getKamerPrefix().".".converteer($temp[0]);//er wordt nog een oud kamernummer gebruikt
					}
				}
			}
		}
		return $result;
	}
}

function converteer($data){
	return "111.111";
}
?>
