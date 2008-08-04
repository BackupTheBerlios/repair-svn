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
}
?>
