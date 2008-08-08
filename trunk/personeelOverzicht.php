<? 
	session_start(); 
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Status.class.php';
	require_once 'classes/Personeel.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Auth.class.php';
	$auth = new Auth(true);
	if (!$auth->getUser()->isPersoneel())
		throw new AccessException();
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
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='index.php'>Dringende Herstellingen</a> &gt; Overzicht
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu("overzicht"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<div>
					<h1>Overzicht</h1>
					<table>
						<tr class="tabelheader"><td colspan="6">Overzicht van herstellingen die niet afgewerkt zijn</td></tr>
						<?
						$lijst = Herstelformulier::getList(0, new Status("ongezien"));
						$size = sizeof($lijst);
						if ($size > 0) {
						?>
						<tr class="subheader"><td colspan="6">Ongeziene herstellingen</td></tr>
						<tbody>
							<tr class="legende">
								<td></td>
								<td>Datum</td>
								<td>Inhoud</td>
							</tr>
						<?
							for($i=0; $i < $size;$i++){
								$form = $lijst[$i];
								echo("<tr id='row_".$form->getId()."'><td></td><td>");
								$timestamp = strtotime($form->getDatum());
								$parsedDate = date("d-m-Y @ H:i",$timestamp);
								echo($parsedDate);
								echo("</td><td>".$form->getSamenvatting()."</td>");
								echo("<td colspan='2' class='img'><a href='doorgevenMelding.php?formid=".$form->getId()."'><img alt='doorgeven' class='bewerk' title='Dit herstelformulier doorgeven' src='images/page_edit.gif'/></a></td></tr>");
							}
						 ?>
						</tbody>
						<?
						}
						
						$lijst = Herstelformulier::getList(0, new Status("gedaan"));
						$size = sizeof($lijst);
						if ($size > 0) {
 						?>
						<tr class="subheader"><td colspan="6">Doorgegeven herstellingen die nog niet afgesloten zijn</td></tr>
						<tbody>
							<tr class="legende"><td></td><td>Datum</td><td>Inhoud</td></tr>
							<?
							for($i=0; $i < $size; $i++){
								$form = $lijst[$i];
								echo("<tr id='row_".$form->getId()."'><td></td><td>");
								$timestamp = strtotime($form->getDatum());
								$parsedDate = date("d-m-Y @ H:i",$timestamp);
								echo($parsedDate);
								echo("</td><td>".$form->getSamenvatting()."</td>");
								echo("<td colspan='4'></td>");
							}
						 ?>
						</tbody>
						<? } ?>
					</table>
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
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 </div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>