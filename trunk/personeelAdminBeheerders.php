<?
	session_start(); 
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Home.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/Leftmenu.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
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
	    <script type="text/javascript" src="js/personeelHome.js"></script>
	    
	</head>
	<body>
		<?new Header(array("personeelAdmin.php", "#"), array("Beheer", "Homes")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu("beheer"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div>
					<h1>Beheer Homes</h1>
					<p>Hier kunt u homes toevoegen en bewerken.</p>
					<table>
						<tr class="tabelheader"><td colspan="9">Beheer Homes</td></tr>
						<tr class="legende"><td>id</td><td>Korte naam</td><td>Lange naam</td><td>Adres</td><td>Verdiepen</td><td>Kamer prefix</td><td>LDAP naam</td><td></td><td></td></tr>
						<?
							$homes = Home::getHomes();
							foreach($homes as $home){
								$id = $home->getId();
								echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='korteNaam_$id'>".$home->getKorteNaam()."</td><td class='edit' id='langeNaam_$id'>".$home->getLangeNaam()."</td><td class='edit' id='adres_$id'>".$home->getAdres()."</td><td class='edit' id='verdiepen_$id'>".$home->getVerdiepen()."</td><td class='edit' id='kamerPrefix_$id'>".$home->getKamerPrefix()."</td><td class='edit' id='ldapNaam_$id'>".$home->getLdapNaam()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
							}
							echo("<tr><td></td><td class='edit' id='korteNaam'><input type='text'/></td><td class='edit' id='langeNaam'><input type='text'/></td><td class='edit' id='adres'><input type='text'/></td><td class='edit' id='verdiepen'><input class='verdiep' type='text'/></td><td class='edit' id='kamerPrefix'><input class='prefix' type='text'/></td><td class='edit' id='ldapNaam'><input type='text'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
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
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		</div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>