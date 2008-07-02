<?
	session_start(); 
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Status.class.php';
	require_once 'classes/UserList.class.php';
	require_once 'classes/VeldList.php';
	require_once 'classes/Auth.class.php';
	$auth = new Auth(true);
	if (!$auth->isLoggedIn()) {
		// throw new UnauthorizedException(); // TODO: gepaste exception
	}
	/**/
	if (isset($_POST['submit'])) {
		// update database
		foreach ($_POST as $key => $value) {
			if ($value == "on")
				$veldenlijst[] = $key;
		}
		$mysqldate = date("Y-m-d H:i:s");
		$opmerking = $_POST['opmerking'];
		$melding = new Herstelformulier("", $mysqldate, new Status("ongezien"), UserList::getUser($auth->getUser()->getId()), $opmerking, $veldenlijst);
		// TODO: submit gedaan, geef melding aan gebruiker	
		die("SUCCES met herstelformulierid ".$melding->getId()."!");
	}
	/**/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/nieuweMelding.js"></script>	    
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
			<a href='index.php'>Dringende Herstellingen</a> &gt; Defect Melden
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<div id="mainnav">
				<ul>
					<li class="first"><a href="overzicht.php">Overzicht</a></li>
					<li><a href="nieuweMelding.php">Defect melden</a></li>
					<li><a href="#">Statistieken</a></li>
					<li><a href="personeelAdmin.php">TIJDELIJKE LINK NAAR BEHEER</a></li>
				</ul>
			</div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div>
				<?
				$user = NULL;
				$currentHome = NULL;
				if ($auth->getUser()->isStudent()) {
					$user = $auth->getUser();
					$currentHome = $user->getHome();
				}
				
				?>
				<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" id='meldingform'>
				<table>
						<tr class="tabelheader"><td colspan="3">Herstelformulier <?=$currentHome->getKorteNaam(); ?></td></tr>
						<?
							$lijst = VeldList::getHomeForm($currentHome);

							for($i=0; $i < sizeof($lijst);$i++){
								$veld = $lijst[$i];
								$nieuweCategorie = $veld->getCategorie();
								if (!isset($huidigeCategorie) || ($huidigeCategorie->getNaamNL() != $nieuweCategorie->getNaamNL())) {
									if (isset($huidigeCategorie)) echo("</tbody>");
									$huidigeCategorie = $nieuweCategorie;
									echo("<tr class='subheader klik' id='cat_".$huidigeCategorie->getId()."' onclick='showGroup(".$huidigeCategorie->getId().");'><td colspan='3'>".$huidigeCategorie->getNaamNL()."/".$huidigeCategorie->getNaamEN()."</td></tr>");
									echo("<tbody id='group_cat_".$huidigeCategorie->getId()."' style='display:none'>");
									echo("<tr class='legende'><td>Defect</td><td>Naam Nederlands</td><td>Naam Engels</td></tr>");
								}
								echo("<tr class='klik' id='item_".$veld->getId()."' onclick='checkItem(".$veld->getId().");'><td><input id='check_".$veld->getId()."' type='checkbox' name='".$veld->getId()."' onclick='checkItem(".$veld->getId().");'/></td><td>".$veld->getnaamNL()."</td><td>".$veld->getnaamEN()."</td></tr>");
							}
						?>
				</table>
				<div><label for="opmerking">Opmerking:</label><div><textarea name="opmerking" id="opmerking" cols="50" rows="8"></textarea></div></div>
				<div><input name="submit" id="submit" type="submit"/></div>
				</form>
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