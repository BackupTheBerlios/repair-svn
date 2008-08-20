<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Home.class.php';
	require_once 'Personeel.class.php';
	require_once 'Auth.class.php';
	require_once 'Leftmenu.class.php';
	require_once 'Topmenu.class.php';
	require_once 'Header.class.php';
	$auth = new Auth(true);
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
	    <script type="text/javascript" src="js/jquery/json.js"></script>
	    <script type="text/javascript" src="js/personeelAdminBeheerders.js"></script>
	    
	</head>
	<body>
		<?new Header(array("personeelAdmin.php", "#"), array("Beheer", "Personeel")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu("beheer"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div>
					<h1>Beheer Personeel</h1>
					<p>Hier kunt u personeelsleden toevoegen en bewerken.</p>
					<table>
						<tr class="tabelheader"><td colspan="9">Beheer Personeel</td></tr>
						<tr class="legende"><td>id</td><td>UgentID</td><td>Voornaam</td><td>Familienaam</td><td>Homes</td><td></td><td></td></tr>
						<?
							$personeel = Personeel::getBeheerders();
							foreach($personeel as $p){
								$id = $p->getId();
								echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='gebruikersnaam_$id'>".$p->getGebruikersnaam()."</td><td class='voornaam'>".$p->getVoornaam()."</td><td class='achternaam'>".$p->getAchternaam()."</td><td class='homes'>");
								$homes = $p->getHomesLijst();
								foreach($homes as $home){
									echo "Home ".$home->getKorteNaam()."<br/>";
								}
								echo("</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
							}
							echo("<tr><td>x</td><td class='edit' id='gebruikersnaam'><input type='text'/></td><td id='voornaam'></td><td id='achternaam'></td><td>");
							$l = Home::getHomes();
							foreach($l as $home){
								echo("
								<label for='home_".$home->getId()."' ><input type='checkbox' id='home_".$home->getId()."' name='home_".$home->getId()."' class='Home ".$home->getKorteNaam()."' value='".$home->getId()."'/>Home ".$home->getKorteNaam()."</label><br/>");
							}
							echo("</td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
						?>
					</table>
				</div>
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a></div>
		
		<!--navigatie aan de linkerkant-->
		<? new Leftmenu("Beheer", "personeelAdminBeheerders.php"); ?>
		
		<!--login aan de rechterkant-->
		<div id="login-act" class="DONTPrint">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		</div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>