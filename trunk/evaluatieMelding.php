<? require_once 'classes/HerstelformulierList.class.php';

require_once 'classes/exceptions/BadParameterException.class.php';
require_once 'classes/Herstelformulier.class.php';

	session_start(); 
	require_once 'classes/Auth.class.php';
	$auth = new Auth(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/evaluatieMelding.js"></script>
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
			<a href='index.php'>Dringende Herstellingen</a> &gt; Index
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
				<div id='beforecontent'>
					<? 
					if($auth->isLoggedIn()) { 
						if($auth->getUser()->isStudent()) {
								// Toon listing van alle formulieren die als "gedaan" gemarkeerd zijn en die geevalueerd moeten worden
								$list = HerstelformulierList::getList($auth->getUser()->getId(), new Status("gedaan"));
								$evaluatielijst = Array();
								?>
								<table>
									<tr class="tableheader">
										<td colspan="4">Deze herstelformulieren werden uitgevoerd maar moeten nog geevalueerd worden. Klik op het groene vinkje om de herstelling aan te duiden als uitgevoerd en hersteld. Klik op het rode kruisje om aan te geven dat de herstelling niet opgelost is, en eventueel een extra opmerking toe te voegen. Let op: je keuze is finaal en onomkeerbaar!</td>
									</tr>
									<tbody>
										<tr class="legende">
											<td>Datum</td>
											<td>Inhoud</td>
											<td colspan="2"></td>
										</tr>
										<?
										foreach ($list as $formulier) {
											if (strtotime($formulier->getDatum()) < (time() - (7 * 24 * 60 * 60))) { // aangepast langer dan 7 dagen geleden
												?>
												<tr id="row_<?=$formulier->getId();?>"><td><?=$formulier->getDatum();?></td><td><?=$formulier->getSamenvatting();?></td><td class="img klik"><img alt="doorgeven" class="bewerk" title="Dit herstelformulier positief evalueren" src="images/icon_accept.gif" onclick="evalueerPositief('<?=$formulier->getId();?>');"/></td><td class="img klik"><img alt="doorgeven" class="bewerk" title="Dit herstelformulier negatief evalueren" src="images/action_stop.gif" onclick="evalueerNegatief('<?=$formulier->getId();?>');"/></td></tr>
												<?
											}
										}
										?>
									</tbody>
								</table>
								<?
						} else throw new Exception("Unauthorized access!"); // TODO: gepaste exception
					} else throw new Exception("Unauthorized access!"); // TODO: gepaste exception
					?>
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