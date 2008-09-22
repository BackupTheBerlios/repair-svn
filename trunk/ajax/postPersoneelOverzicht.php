<?php
	//login check
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Auth.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'DB.class.php';
	$auth = new Auth(false);
	if(!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new AccessException();
	
	//aantal per pagina
	$AANTAL_PER_PAGINA = 20;
	
	//paginering stuff
	$pagina = $_GET['page']=="" ? 1 : $_GET['page'];
	$vanaf = ($pagina - 1)*$AANTAL_PER_PAGINA;
	$paginering=array();
	$paginering['current_page'] = $pagina;
	
	if($_GET['waarden']=="")
		$q = "SELECT id FROM herstelformulier";
	else{	
		$velden = json_decode(stripslashes($_GET["velden"]));
		$waarden = json_decode(stripslashes($_GET["waarden"]));
		//query opbouwen
		$q = "SELECT DISTINCT herstelformulier.id FROM herstelformulier INNER JOIN user ON (herstelformulier.userId=user.id) INNER JOIN home ON (herstelformulier.homeId=home.id) LEFT JOIN relatie_herstelformulier_velden ON (herstelformulier.id=relatie_herstelformulier_velden.herstelformulierId)WHERE ";
		foreach ($waarden as $key =>$value){
			if(sizeof(explode("|", $velden[$key]))>1){
				$e = explode("|", $velden[$key]);
				$q .= "(".$e[0]." LIKE '%".$value."%' OR ".$e[1]." LIKE '%".$value."%') AND  ";
			}
			else
				$q .= $velden[$key]." LIKE '%".$value."%' AND  ";
		}
		$q = substr($q, 0, -6);
	}	
	$q .= " ORDER BY datum DESC";
	$_SESSION["query"] = $q;
	//eerste een query voor het aantal resultaten
	$statement = DB::getDB()->prepare($q);
	$statement->execute();		
	$statement->store_result();
	$paginering['aantal_rijen'] = $statement->num_rows;
	
	$q .= " LIMIT $vanaf, $AANTAL_PER_PAGINA";
	$lijst = array();
	$statement = DB::getDB()->prepare($q);
	$statement->execute();		
	$statement->store_result();
	$statement->bind_result($id);
	while($statement->fetch()){
		$h = new Herstelformulier($id);
		$lijst[]=$h->toArray();
	}
	$statement->close();
	
	$paginering["aantal_paginas"]=ceil($paginering['aantal_rijen']/$AANTAL_PER_PAGINA);
	$uitvoer = array($paginering, $lijst);
	echo(json_encode($uitvoer));
?>