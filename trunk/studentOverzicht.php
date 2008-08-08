<?

	session_start(); 
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/Taal.class.php';
	$auth = new Auth(true);
	if(!$auth->getUser()->isStudent())
		throw new AccessException();
	$taal = new Taal();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel') ?></title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/studentOverzicht.js"></script>
	</head>
	<body>
		<?new Header(array("#"), array("Overzicht")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu("overzicht"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<? if($auth->getUser()->isStudent()){ ?>
				<div>
					<h1>Overzicht</h1>
					<p>Welkom <?=$auth->getUser()->getVoornaam()?>, op deze pagina kunt u een overzicht vinden van de reeds ingediende herstelformulieren.</p>
					<table>
						<tr class="tabelheader"><td colspan="6">Overzicht van de voorbije herstellingen</td></tr>
						<?
							$lijst = Herstelformulier::getLatest($auth->getUser()->getId());
							for($i=0; $i < sizeof($lijst);$i++){
								$form = $lijst[$i];
								$nieuweStatus = $form->getStatus();
								if (!isset($huidigeStatus) || ($nieuweStatus->getValue() != $huidigeStatus->getValue())) {
									if (isset($huidigeStatus)) echo("</tbody>");
									$huidigeStatus = $nieuweStatus;
									echo("<tr class='subheader klik' id='status_".$huidigeStatus->getValue()."' onclick=\"showGroup('".$huidigeStatus->getValue()."');\"><td width='12px' id='collapse_".$huidigeStatus->getValue()."'>-</td><td colspan='5'>");
									echo($huidigeStatus->getUitleg());
									echo ("</td></tr>");
									echo("<tbody id='group_status_".$huidigeStatus->getValue()."'>");
									echo("<tr class='legende'><td></td><td>Datum</td><td>Inhoud</td></tr>");
								}
								echo("<tr id='row_".$form->getId()."'><td></td><td>");
								$timestamp = strtotime($form->getDatum());
								$parsedDate = date("d-m-Y @ H:i",$timestamp);
								echo($parsedDate);
								echo("</td><td>".$form->getSamenvatting()."</td>");
								if ($form->getStatus()->getChangeable())
									echo("<td class='img'><a href='studentMeldingBewerken.php?formid=".$form->getId()."'><img alt='bewerken' class='bewerk' title='Dit herstelformulier bewerken' src='images/page_edit.gif'/></a></td><td class='img'><img class='klik verwijder' alt='verwijderen' title='Dit herstelformulier verwijderen' src='images/page_delete.gif' onclick=\"verwijder('".$form->getId()."');\"/></td></tr>");
								else
									echo("<td colspan='4'></td>");
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
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 </div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>