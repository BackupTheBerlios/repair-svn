<?php
	session_start();
	require_once 'classes/Auth.class.php';
	$auth = new Auth(true);
	if($auth->getUser()->isStudent()){
		echo("<meta http-equiv=\"Refresh\" content=\"0; URL=studentOverzicht.php\">");
	}
	else if($auth->getUser()->isPersoneel()){
		echo("<meta http-equiv=\"Refresh\" content=\"0; URL=personeelOverzicht.php\">");
	}
?>