<?php
	session_start();
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'LeftMenu.class.php';
	require_once 'Header.class.php';
	require_once 'DB.class.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
	$auth = new Auth(false);
	$taal = new Taal();
	if(!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) throw new AccessException();
	if($_POST['waarden']!=""){
		$waarden = explode(";", $_POST['waarden']);
		$export = array();
		//eerste rij
		$rij = array();
		if(in_array("herstelformulier.id", $waarden)) $rij[] = "Herstelformulier ID";
		if(in_array("herstelformulier.datum", $waarden)) $rij[] = "Herstelformulier Datum";
		if(in_array("herstelformulier.status", $waarden)) $rij[] = "Herstelformulier Status";
		if(in_array("herstelformulier.kamer", $waarden)) $rij[] = "Herstelformulier Kamer";
		if(in_array("herstelformulier.factuurnummer", $waarden)) $rij[] = "Herstelformulier Factuurnummer";
		
		$export[]=$rij;	
		
		$statement = DB::getDB()->prepare($_SESSION['query']);
		$statement->execute();		
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch()){
			$rij = array();
			$herstelformulier = new Herstelformulier($id);
				
			if(in_array("herstelformulier.id", $waarden)) $rij[] = $herstelformulier->getId();
			if(in_array("herstelformulier.datum", $waarden)) $rij[] = $herstelformulier->getDatum();
			if(in_array("herstelformulier.status", $waarden)) $rij[] = $herstelformulier->getStatus()->getValue();
			if(in_array("herstelformulier.kamer", $waarden)) $rij[] = $herstelformulier->getKamer()->getKamernummerLang();
			if(in_array("herstelformulier.factuurnummer", $waarden)) $rij[] = $herstelformulier->getFactuurnummer();
			
			$export[]=$rij;	
		}
		$statement->close();
		
		//headers
		header("Expires: 0");
		header("Cache-control: private");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Description: File Transfer");
		header('Content-Type: text/csv; charset="utf-8"');
		header("Content-disposition: attachment; filename=herstelformulier_export.csv");
		
		//de output
		$out = fopen('php://output','w');
		foreach($export as $rij)
			fputcsv($out, $rij, ";");
		fclose($out);
	}
	else{
		if($_SESSION['query']=="")
			throw new Exception("Er is niets om te exporteren");
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
			    <title>Online Herstelformulier</title>
			    <link rel="stylesheet" type="text/css" href="style.css"/>
			    <script type="text/javascript" src="js/jquery/jquery.js"></script>
			    <script type="text/javascript" src="js/jquery/json.js"></script>
			    <script type="text/javascript" src="js/personeelExporteer.js"></script>
			</head>
			<body>	
				<?new Header(array("#"), array("Exporteren")); ?>	
				<div id="container">
					<div id="contenthome">
						<h1>Exporteren</h1>	
						<?
							echo("<p>U staat op het punt om een lijst van herstelformulieren te exporteren. Selecteer hieronder de velden die u wil exporteren. <a href='#' id='selecteer_alles'>Selecteer alles</a>. </p>");
							
							echo "<form method='post' id='formulier'>";
							echo("<h2>Herstelformulier gegevens</h2>");
							generateCheckbox('herstelformulier.id', 'Herstelformulier ID');
							generateCheckbox('herstelformulier.datum', 'Herstelformulier Datum');
							generateCheckbox('herstelformulier.status', 'Herstelformulier Status');
							generateCheckbox('herstelformulier.kamer', 'Herstelformulier Kamer');
							generateCheckbox('herstelformulier.factuurnummer', 'Herstelformulier Factuurnummer');
							
							echo "<input type='button' id='doorsturen' value='exporteren'/></form>";
						?>
					</div>	
				</div>
				<!--de footer-->
				<div id="footer"><?=$taal->msg('footer') ?></div>
				<? new LeftMenu("overzicht", "personeelExporteer.php") ?>
			</body>
		</html>		
		<?
	}
	
	function generateCheckbox($id, $tekst){
			echo"<label for='$id' class='labelCheckbox'><input type='checkbox' class='inputCheckbox' id='$id' value='$id'/>$tekst</label><br/>";
	}
?>