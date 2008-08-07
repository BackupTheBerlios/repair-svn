<?
	session_start(); 
	require_once 'classes/HomeList.class.php';
	require_once 'classes/Locatie.class.php';
	require_once 'classes/Home.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/VeldList.php';
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
	    <script type="text/javascript" src="js/personeelAdmin2.js"></script>
	    
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
					<h1>Beheer</h1>
					<?if($_GET['homeId']=="") {?>
						Volgens onze gegevens bent u beheerder van volgende homes:
						//TODO dynamisch maken
					<?}
					else{ 
						$currentHome = new Home("id", $_GET['homeId']);	
						$locaties = Locatie::getAllValues();
						echo("<p>Hieronder kunt u het herstelformulier van Home ".$currentHome->getKorteNaam()." aanpassen.</p>");
						?>
						<table>
							<tr class="tabelheader"><td colspan="5">Herstelformulier <?=$currentHome->getKorteNaam(); ?></td></tr>
							<?
							foreach ($locaties as $index => $locatie) {
							?>
							<tr class="subheader"><td colspan="5"><?=$locatie->getValue(); ?></td></tr>
							<tr class="legende"><td>Naam Nederlands</td><td>Naam Engels</td><td>Categorie</td><td></td><td></td></tr>
							<?
								$lijst = VeldList::getHomeLocationFields($currentHome,$locatie);
								foreach($lijst as $veld){
									$id = $veld->getId();
									echo("<tr id='".$id."_".$locatie->getValue()."'><td class='edit' id='naamNL_$id'>".$veld->getnaamNL()."</td><td class='edit' id='naamEN_$id'>".$veld->getnaamEN()."</td><td class='select' id='categorie_$id'>".$veld->getCategorie()->getNaamNL()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
								}
								echo("<tr><td class='edit'><input type='text'/></td><td class='edit'><input type='text'/></td><td class='cat'></td><td class='img'><img alt='bewerken' class='klik bewerk' title='Dit veld bewerken' src='images/page_edit.gif' /></td><td class='img'><img class='klik verwijder' alt='verwijderen' title='Dit veld verwijderen' src='images/page_delete.gif' /></td></tr>");
							}
							?>
						</table>
					<?} ?>
				</div>
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a></div>
		
		<!--navigatie aan de linkerkant-->
		<? new Leftmenu("Beheer", "personeelAdmin.php"); ?>
		
		<!--login aan de rechterkant-->
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		</div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>