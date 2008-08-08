<?php
	session_start();
	require_once '../classes/exceptions/BadParameterException.class.php';
	require_once '../classes/exceptions/AccessException.php';
	require_once '../classes/DB.class.php';
	require_once '../classes/Auth.class.php';
	$auth = new Auth(false);
	if (!$auth->isLoggedIn() || !$auth->getUser()->isStudent()) 
		throw new AccessException();
	
	$formid = $_POST['formid'];
	
	//if (!is_numeric($formid) || $formid < 1) throw new BadParameterException();
	
	$db = DB::getDB();
	$statement = $db->prepare("DELETE FROM herstelformulier WHERE id = ?");
	$statement->bind_param('i', $formid);
	$statement->execute();
	$statement->close();
?>