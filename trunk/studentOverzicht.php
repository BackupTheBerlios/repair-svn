<? 
	session_start(); 
	require_once 'classes/Auth.class.php';
	require_once 'classes/HerstelformulierList.class.php';
	$auth = new Auth(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
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
		
		<!--zoekveldje-->
		<div id="search">
			<form method="get" action="">
				<a href="#" class="advanced"/> 
				<input name="q" value="" class="searchinput" type="text" /> 
				<input type="submit" value="zoek" class="searchbutton" />
			</form>
		</div>
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='index.php'>Dringende Herstellingen</a> &gt; Overzicht
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<div id="mainnav">
				<ul>
					<li class="first" id="active"><a href="#">Overzicht</a></li>
					<li><a href="#">Defect melden</a></li>
					<li><a href="#">Statistieken</a></li>
				</ul>
			</div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<? if($auth->getUser()->isStudent()){ ?>
				<div>
					<h1>Overzicht</h1>
					<p>Welkom <?=$auth->getUser()->getVoornaam()?>, op deze pagina kunt u een overzicht vinden van de reeds ingediende herstelformulieren.</p>
					<table>
						<caption><em>Overzicht van de voorbije herstellingen</em></caption>
						<tr><th>Datum</th><th>Inhoud</th><th>Status</th></tr>
						<?
							$lijst = HerstelformulierList::getLatest($auth->getUser()->getId(), 5);
							for($i=0; $i < sizeof($lijst);$i++){
								$form = $lijst[$i];
								echo("<tr><td>".$form->getDatum()."</td><td>".$form->getKamer()->getKamernummerKort()."</td><td>".$form->getStatus()->getValue()."</td></tr>");
							}
						 ?>
					</table>
				</div>
				<?} else{ ?>
					<meta http-equiv="Refresh" content="0; URL=personeelOverzicht.php">			
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
			 &nbsp;-&nbsp;<a href="logout.php"><?=$auth->getUser()->getGebruikersnaam() ?></a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>">aanmelden</a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>