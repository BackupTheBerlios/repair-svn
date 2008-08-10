<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Topmenu.class.php';
	require_once 'Header.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
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
		<?new Header(array("#"), array($taal->msg('overzicht'))); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu("overzicht"); ?>
			
			<!-- Inhoud van de confirm box voor verwijdering -->
			<div id="verwijderconfirm" style="display:none"><?=$taal->msg('confirm_verwijder') ?></div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<? if($auth->getUser()->isStudent()){ ?>
				<div>
					<h1><?=$taal->msg('overzicht') ?></h1>
					<p><? printf($taal->msg('welkom_overzicht_naam'), $auth->getUser()->getVoornaam()); ?></p>
					<table>
						<tr class="tabelheader"><td colspan="6"><?=$taal->msg('overzicht_herstellingen') ?></td></tr>
						<?
							$lijst = Herstelformulier::getLatest($auth->getUser()->getId());
							for($i=0; $i < sizeof($lijst);$i++){
								$form = $lijst[$i];
								$nieuweStatus = $form->getStatus();
								if (!isset($huidigeStatus) || ($nieuweStatus->getValue() != $huidigeStatus->getValue())) {
									if (isset($huidigeStatus)) echo("</tbody>");
									$huidigeStatus = $nieuweStatus;
									echo("<tr class='subheader klik' onclick=\"showGroup('".$huidigeStatus->getValue()."');\"><td width='12px' id='collapse_".$huidigeStatus->getValue()."'>-</td><td colspan='5'>");
									echo($huidigeStatus->getUitleg());
									echo ("</td></tr>");
									echo("<tr class='legende ".$huidigeStatus->getValue()."'><td></td><td>".$taal->msg('datum')."</td><td colspan='3'>".$taal->msg('inhoud')."</td></tr>");
								}
								echo("<tr class='".$huidigeStatus->getValue()."' id='row_".$form->getId()."'><td></td><td>");
								$timestamp = strtotime($form->getDatum());
								$parsedDate = date("d-m-Y @ H:i",$timestamp);
								echo($parsedDate);
								echo("</td><td>".$form->getSamenvatting()."</td>");
								if ($form->getStatus()->getChangeable())
									echo("<td class='img'><a href='studentMeldingBewerken.php?formid=".$form->getId()."'><img alt='bewerken' class='bewerk' title='Dit herstelformulier bewerken' src='images/page_edit.gif'/></a></td><td class='img'><img class='klik verwijder' alt='verwijderen' title='Dit herstelformulier verwijderen' src='images/page_delete.gif' onclick=\"verwijder('".$form->getId()."');\"/></td>");
								else
									echo("<td colspan='4'></td>");
								echo("</tr>");
							}
							echo("</tbody>");
						 ?>
					</table>
				</div>
				<?} else{ ?>
					<meta http-equiv="Refresh" content="0; URL=personeelOverzicht.php">			
				<?}?>
				
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer"><?=$taal->msg('footer') ?></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt><?=$taal->msg('handige_links') ?></dt>
				<dd><ul>
					<li><a href="http://helpdesk.ugent.be">&#187; Helpdesk</a></li>
					<li><a href="http://www.ugent.be/nl/voorzieningen/huisvesting">&#187; Huisvesting</a></li>
					<li><a href="https://minerva.ugent.be/">&#187; Minerva</a></li>
				</ul></dd>
			</dl>				
		</div>
		
		<!--login aan de rechterkant-->
		<div id="login-act">
			<?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" ><?=$taal->msg('afmelden') ?></a>
		 </div>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>