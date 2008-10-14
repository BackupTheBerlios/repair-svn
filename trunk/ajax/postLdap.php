<?php
	//login check
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Auth.class.php';
	require_once 'AccessException.php';
	require_once 'Error.class.php';
	require_once 'LDAP.class.php';
	$auth = new Auth(false);
	if(!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new AccessException();
	if($_GET['waarden']=="")
		die();
	else{	
		$velden = json_decode(stripslashes($_GET["velden"]));
		$waarden = json_decode(stripslashes($_GET["waarden"]));
		//query opbouwen
		$filter = "";
		foreach ($waarden as $key =>$value){
			if($value!="")
				if(strlen($filter)==0)
					$filter = "(".$velden[$key]."=*".$value."*)";
				else
					$filter = "(&".$filter."(".$velden[$key]."=*".$value."*))";
		}
	}
	$lijst = array();
	$ld = new LdapRepair();
	$ld->connect();
	$ld->bind();
	$ld->search($filter);
	$result = $ld->get_entries();
	array_shift($result);
	foreach ($result as $persoon){
		$p = $ld->parseDataSearch($persoon);
		if($p['gebruikersnaam']!=NULL)
			$lijst[] = $p;
	}
	$uitvoer = array(array(), $lijst);
	echo(json_encode($uitvoer));
?>