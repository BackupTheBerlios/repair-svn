<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Veld.class.php';
	require_once 'Locatie.class.php';
	require_once 'Home.class.php';
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
	    <script type="text/javascript" src="js/personeelAdmin.js"></script>
	    
	</head>
	<body>
		<?new Header(array("#"), array("Beheer")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu("beheer"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div>
					<h1>Beheer</h1>
					<?if($_GET['homeId']=="") {?>
						<p>U kunt de herstelformulieren van volgende homes aanpassen:</p><ul>
						<?
							$lijst = $auth->getUser()->getHomesLijst();
							foreach($lijst as $home)
								echo "<li><a href='personeelAdmin?homeId=".$home->getId()."'>Home ".$home->getKorteNaam()."</a></li>"
						 ?>
						 </ul>
						 <p>U kunt ook <a href='personeelAdminBeheerders.php'>beheerders aanmaken</a> en <a href='personeelAdminHomes.php'>homes aanmaken en bewerken</a></p>
					<?}
					else{ 
						$currentHome = new Home($_GET['homeId']);	
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
								$lijst = Veld::getHomeLocationFields($currentHome,$locatie);
								foreach($lijst as $veld){
									$id = $veld->getId();
									echo("<tr id='".$id."_".$locatie->getValue()."'><td class='edit' id='naamNL_$id'>".$veld->getnaamNL()."</td><td class='edit' id='naamEN_$id'>".$veld->getnaamEN()."</td><td class='select' id='categorie_$id'>".$veld->getCategorie()->getNaamNL()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
								}
								echo("<tr id='".$locatie->getValue()."_".$_GET['homeId']."'><td class='edit' id='naamNL_".$locatie->getValue()."'><input type='text'/></td><td class='edit' id='naamEN_".$locatie->getValue()."'><input type='text'/></td><td class='dd select' id='categorie_".$locatie->getValue()."'></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
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