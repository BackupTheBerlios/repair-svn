<? 
	session_start(); 
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Status.class.php';
	require_once 'classes/Personeel.class.php';
	require_once 'classes/Leftmenu.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
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
		<?new Header(array("#"), array("Overzicht")); ?>
		
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
								<td></td>
							</tr>
						<?
							for($i=0; $i < $size;$i++){
								$form = $lijst[$i];
								echo("<tr id='row_".$form->getId()."'><td></td><td>");
								$timestamp = strtotime($form->getDatum());
								$parsedDate = date("d-m-Y @ H:i",$timestamp);
								echo($parsedDate);
								echo("</td><td>".$form->getSamenvatting()."</td>");
								echo("<td colspan='2' class='img'><a href='personeelMeldingDoorgeven.php?formid=".$form->getId()."'><img alt='doorgeven' class='bewerk' title='Dit herstelformulier doorgeven' src='images/page_edit.gif'/></a></td></tr>");
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
							<tr class="legende"><td></td><td>Datum</td><td>Inhoud</td><td></td></tr>
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
		<?new Leftmenu("overzicht", "personeelOverzicht.php") ?>
		
		<!--login aan de rechterkant-->
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 </div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>