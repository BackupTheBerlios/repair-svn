<?
	session_start();
	require_once 'classes/exceptions/BadParameterException.class.php';
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
	require_once 'classes/Auth.class.php';
	$auth = new Auth(false);
	if(!$auth->getUser()->isPersoneel())
		throw new AccessException();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/doorgevenMelding.js"></script>
	</head>
	<body>
		<?new Header(array("#"), array("Melding Doorgeven")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div id='beforecontent'>
					$formid = $_GET['formid'];
					if (!is_numeric($formid) || $formid < 1) throw new BadParameterException("Formid werd foutief gebruikt");
					$formulier = new Herstelformulier($formid);
					?>
					<div id='test'>
						<table>
						<tr class="tabelheader"><td colspan="4">Melding</td></tr>
						<tr class="legende">
							<td>Datum ingave</td>
							<td>Student</td>
							<td>Kamer</td>
							<td>Telefoon</td>
						</tr>
						<tr>
							<td><?=$formulier->getDatum();?></td>
							<td><?=$formulier->getStudent()->getAchternaam()." ".$formulier->getStudent()->getVoornaam();?></td>
							<td><?=$formulier->getKamer()->getKamernummerKort();?></td>
							<td><?=$formulier->getKamer()->getTelefoonnummer();?></td>
						</tr>
						<tr><td colspan="4"class="unityheader">Gemelde defecten:</td></tr>
						<?
						foreach ($formulier->getVeldenlijst() as $veldid) {
							$veld = new Veld($veldid);
							?>
							<tr class="unity">
								<td></td>
								<td colspan="3"><?=$veld->getNaamNL();?></td>
							</tr>
							<?
						}
						?>
						<tr>
							<td>Opmerking:</td>
							<td colspan="3"><?=$formulier->getOpmerking();?></td>
						</tr>
						<tr>
							<td colspan="3"></td>
							<td><button name="submit" id="submit" type="submit" onclick="geefDoor('<?=$formid;?>');">Doorgegeven</button></td>
						</tr>
						</table>
					</div>
				</div>
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt>Handige links</dt>
				<dd><ul>
					<li><a href="http://helpdesk.ugent.be">&#187; Helpdesk</a></li>
					<li><a href="http://www.ugent.be/nl/voorzieningen/huisvesting">&#187; Huisvesting</a></li>
					<li><a href="https://minerva.ugent.be/">&#187; Minerva</a></li>
				</ul></dd>
			</dl>				
		</div>
		
		<!--login aan de rechterkant-->
		<? if($auth->isLoggedIn()){ ?>
			<div id="login-act">
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen">aanmelden</a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>