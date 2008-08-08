<?
	session_start(); 
	require_once 'classes/HomeList.class.php';
	require_once 'classes/Home.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/Leftmenu.class.php';
	$auth = new Auth(true);
	if($auth->getUser()->isStudent()){
		//throw new Exception("Access Violation Exception");//todo: aanzetten
	}
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
		<!--logo linksboven-->
		<div id="logo"><img src="images/logo.gif" width="200" height="60" alt="Logo Universiteit Gent" usemap="#linklogo" /><map name="linklogo" id="linklogo"><area shape="rect" coords="60,0,142,60" href="http://www.ugent.be" alt="Startpagina Universiteit Gent" /></map></div>
		
		<!--pagina titel-->
		<div id="siteid"><img src="images/siteid-portal.jpg" width="300" height="80" alt="Portaalsite Universiteit Gent" /><a href="index.php" class="text" >Online Herstelformulier</a></div>
		
		<!--linkjes rechtsboven-->
		<div id="utility">
			<a href="help.php">CSS</a> | <a href="#">English</a> | <a href="#">Contact</a> | <a href="#" onclick="window.print()">Print</a>
		</div>
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='index.php'>Dringende Herstellingen</a> &gt; Beheer
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<div id="mainnav">
				<ul>
					<li class="first"><a href="overzicht.php">Overzicht</a></li>
					<li><a href="nieuweMelding.php">Defect melden</a></li>
					<li><a href="#">Statistieken</a></li>
					<li id="active"><a href="#">Beheer</a></li>
				</ul>
			</div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div>
					<h1>Beheer Homes</h1>
					<p>Hier kunt u homes toevoegen en bewerken.</p>
					<table>
						<tr class="tabelheader"><td colspan="9">Beheer Homes</td></tr>
						<tr class="legende"><td>id</td><td>Korte naam</td><td>Lange naam</td><td>Adres</td><td>Verdiepen</td><td>Kamer prefix</td><td>LDAP naam</td><td></td><td></td></tr>
						<?
							$homes = HomeList::getHomes();
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
		<? new Leftmenu("Beheer", "personeelHomes.php"); ?>
		
		<!--login aan de rechterkant-->
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		</div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>