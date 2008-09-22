<?php
	//login check
	session_start();
	require_once '../classes/Config.class.php';
	require_once 'Auth.class.php';
	require_once 'AccessException.php';
	require_once 'Error.class.php';
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
		$q = "SELECT id FROM error";
	else{	
		$velden = json_decode(stripslashes($_GET["velden"]));
		$waarden = json_decode(stripslashes($_GET["waarden"]));
		//query opbouwen
		$q = "SELECT id FROM error WHERE ";
		foreach ($waarden as $key =>$value){
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
		$e = new Error($id);
		$lijst[]=$e->toArray();
	}
	$statement->close();
	
	$paginering["aantal_paginas"]=ceil($paginering['aantal_rijen']/$AANTAL_PER_PAGINA);
	$uitvoer = array($paginering, $lijst);
	echo(json_encode($uitvoer));
?>