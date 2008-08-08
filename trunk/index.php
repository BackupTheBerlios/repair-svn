<? require_once 'classes/Herstelformulier.class.php';

require_once 'classes/Taal.class.php';
require_once 'classes/Topmenu.class.php';

	session_start(); 
	require_once 'classes/Auth.class.php';
	$auth = new Auth(false);
	$taal = new Taal("NL");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel');?></title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<!--logo linksboven-->
		<div id="logo"><img src="images/logo.gif" width="200" height="60" alt="Logo Universiteit Gent" usemap="#linklogo" /><map name="linklogo" id="linklogo"><area shape="rect" coords="60,0,142,60" href="http://www.ugent.be" alt="Startpagina Universiteit Gent" /></map></div>
		
		<!--pagina titel-->
		<div id="siteid"><img src="images/siteid-portal.jpg" width="300" height="80" alt="Portaalsite Universiteit Gent" /><a href="index.php" class="text" ><?=$taal->msg('titel');?></a></div>
		
		<!--linkjes rechtsboven-->
		<div id="utility">
			<a href="help.php">CSS</a> | <a href="#">English</a> | <a href="#">Contact</a> | <a href="#" onclick="window.print()">Print</a>
		</div>
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='index.php'><?=$taal->msg('dringende_herstellingen');?></a> &gt; Index
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<? if($auth->isLoggedIn()){ if($auth->getUser()->isStudent()){?>
				<div>
					<h1>Welkom</h1>
					<?
					$list = Herstelformulier::getEvaluationList($auth->getUser()->getId());
					if (sizeof($list) > 0)
						echo "<center><b>".$taal->msg('herstelformulieren_te_evalueren')."</b></center>";
					?>
					<p>
						<? printf($taal->msg('welkom_naam_home_kamer'),$auth->getUser()->getVoornaam(),$auth->getUser()->getHome()->getKorteNaam(),$auth->getUser()->getKamer()->getKamernummerKort());?>
						<br><?=$taal->msg('keuze_opties'); ?>
					</p>
					<ul>
						<li><?=$taal->msg('meld_nieuw_defect');?></li>
						<li><?=$taal->msg('overzicht_aanvragen');?></li>
					</ul>
				</div>
				<?}} else{ ?>
				<div>
					<h1>Welkom</h1>
					<p>Welkom op de online herstelformulier applicatie. Op deze website is het mogelijk om een herstelformulier digitaal in te vullen. Klik rechts op aanmelden om verder te gaan.</p>
				</div>				
				<?}?>
				
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