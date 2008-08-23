<?php
	session_start();
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'DB.class.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
	require_once 'Menu.class.php';
	
	$auth = new Auth(false);
	$taal = new Taal();
	if(!$auth->isLoggedIn() || !$auth->getUser()->isPersoneel()) 
		throw new AccessException();
		
	if($_POST['waarden']!=""){
		$waarden = explode(";", $_POST['waarden']);
		$export = array();
		//eerste rij
		$rij = array();
						
		if(in_array("herstelformulier.id", $waarden)) $rij[] = "Herstelformulier ID";
		if(in_array("herstelformulier.datum", $waarden)) $rij[] = "Datum";
		if(in_array("herstelformulier.kamer", $waarden)) $rij[] = "Kamer";
		if(in_array("herstelformulier.home", $waarden)) $rij[] = "Home";
		if(in_array("herstelformulier.persoon", $waarden)) $rij[] = "Persoon";
		if(in_array("herstelformulier.status", $waarden)) $rij[] = "Status";
		if(in_array("herstelformulier.factuurnummer", $waarden)) $rij[] = "Factuurnummer";
		
		$export[]=$rij;	
		
		$statement = DB::getDB()->prepare($_SESSION['query']);
		$statement->execute();		
		$statement->store_result();
		$statement->bind_result($id);
		while($statement->fetch()){
			$rij = array();
			$herstelformulier = new Herstelformulier($id);
			$persoon = $herstelformulier->getStudent();
				
			if(in_array("herstelformulier.id", $waarden)) $rij[] = $herstelformulier->getId();
			if(in_array("herstelformulier.datum", $waarden)) $rij[] = $herstelformulier->getDatum();
			if(in_array("herstelformulier.kamer", $waarden)) $rij[] = $herstelformulier->getKamer()->getKamernummerLang();
			if(in_array("herstelformulier.home", $waarden)) $rij[] = $herstelformulier->getHome()->getKorteNaam();
			if(in_array("herstelformulier.persoon", $waarden)) $rij[] = $persoon->getVoornaam()." ".$persoon->getAchternaam();
			if(in_array("herstelformulier.status", $waarden)) $rij[] = $herstelformulier->getStatus()->getValue();
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
	    <title><?=$taal->msg('titel');?></title>
	    <style type="text/css" media="all">@import url(reset.css);</style>
		<style type="text/css" media="all">@import url(screen.css);</style>
		<style type="text/css" media="print">@import url(print.css);</style>
		<style type="text/css" media="all">@import url(ploneCustom.css);</style>
		
		<!-- Internet Explorer 6 CSS Fixes -->
		<!--[if IE 6]>
			        <style type="text/css" media="all">@import url(ie6.css);</style>
		<![endif]-->
		
		<!-- Internet Explorer 7 CSS Fixes -->
		<!--[if IE 7]>
			        <style type="text/css" media="all">@import url(ie7.css);</style>
		<![endif]-->
		
		<!-- syndication -->
		<!-- meta (http-equiv) -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/personeelExporteer.js"></script>
	</head>
	<body>
		<!--main content-->
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<!--horizontale navigatiebalk bovenaan-->
				<?new Menu("Exporteren", "personeelExporteer.php"); ?>
				<!--de inhoud van de pagina-->
				<div id="content" class="normal">
					<h1>Exporteren</h1>	
					<?
					echo("<p>U staat op het punt om een lijst van herstelformulieren te exporteren. Selecteer hieronder de velden die u wil exporteren. <a href='#' id='selecteer_alles'>Selecteer alles</a>. </p>");
					
					echo "<form method='post' id='formulier'>";
					echo("<h2>Herstelformulier gegevens</h2>");
					generateCheckbox('herstelformulier.id', 'Herstelformulier ID');
					generateCheckbox('herstelformulier.datum', 'Datum');
					generateCheckbox('herstelformulier.kamer', 'Kamer');
					generateCheckbox('herstelformulier.home', 'Home');
					generateCheckbox('herstelformulier.persoon', 'Persoon');
					generateCheckbox('herstelformulier.status', 'Status');
					generateCheckbox('herstelformulier.factuurnummer', 'Factuurnummer');
					
					
					echo "<input type='button' id='doorsturen' value='exporteren'/></form>";
					?>
				</div>	
			</div>
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>		
	<?
	}
	
	function generateCheckbox($id, $tekst){
			echo"<label for='$id' class='labelCheckbox'><input type='checkbox' class='inputCheckbox' id='$id' value='$id'/>$tekst</label><br/>";
	}
?>