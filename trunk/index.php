<? 
	session_start(); 
	require_once 'classes/Auth.class.php';
	require_once 'classes/HerstelformulierList.class.php';
	$auth = new Auth(false);
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
		<div id="siteid"><img src="images/siteid-portal.jpg" width="300" height="80" alt="Portaalsite Universiteit Gent" /><a class="text" >Online Herstelformulier</a></div>
		
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
			<a href='index.php'>Dringende Herstellingen</a> &gt; Index
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<div id="mainnav">
				<ul>
					<li><a href="#">Overzicht</a></li>
					<li><a href="#">Statistieken</a></li>
				</ul>
			</div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<? if($auth->isLoggedIn()){ ?>
				<div>
					<h1>Welkom</h1>
					<p>Welkom <?=$auth->getUser()->getGebruikersnaam() ?>, </p>
					<table>
						<caption>Overzicht van de voorbije herstellingen</caption>
						<tr><th>Datum</th><th>Inhoud</th><th>Status</th></tr>
						<?
							$lijst = HerstelformulierList::getLatest($auth->getUser()->getId(), 5);
							print_r($lijst);
							for($i; $i < sizeof($lijst);$i++){
								$form = $lijst[$i];
								echo("<tr>".$form->getDatum()."<td><tr>".$form->getKamer()."<td><tr>".$form->getStatus()."<td></tr>");
							}
						 ?>
					</table>
				</div>
				<?} else{ ?>
				<div>
					<h1>Welkom</h1>
					<p>Welkom op de online herstelformulier applicatie. Klink rechts op aanmelden om een formulier in te vullen.</p>
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