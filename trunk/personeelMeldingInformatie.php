<?
	session_start();
	require_once 'classes/Config.class.php';
	require_once 'BadParameterException.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Topmenu.class.php';
	require_once 'Header.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
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
	</head>
	<body>
		<?new Header(array("#"), array("Melding Informatie")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<? new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div id='beforecontent'>
					<?
					$formid = $_GET['formid'];
					if (!is_numeric($formid) || $formid < 1) throw new BadParameterException("Formid werd foutief gebruikt");
					$formulier = new Herstelformulier($formid);
					?>
					<div id='informatietabel'>
						<table>
						<tr class="tabelheader"><td colspan="4">Melding</td></tr>
						<tr class="legende">
							<td>Datum ingave</td>
							<td>Student</td>
							<td>Kamer</td>
							<td>Telefoon</td>
						</tr>
						<tr>
							<td><?=$formulier->getDatum();?></td>
							<td><?=$formulier->getStudent()->getAchternaam()." ".$formulier->getStudent()->getVoornaam();?></td>
							<td>Home <?=$formulier->getKamer()->getHome()->getKorteNaam();?> kamer <?=$formulier->getKamer()->getKamernummerKort();?></td>
							<td><?=$formulier->getKamer()->getTelefoonnummer();?></td>
						</tr>
						<tr><td colspan="4"class="unityheader">Gemelde defecten:</td></tr>
						<?
						foreach ($formulier->getVeldenlijst() as $veldid) {
							$veld = new Veld($veldid);
							?>
							<tr class="unity">
								<td></td>
								<td><? 
									if($veld->getCategorie()->getLocatie()->getValue()=="Kot") 
										echo "Kamer ".$formulier->getKamer()->getKamernummerKort();
									else if($veld->getCategorie()->getLocatie()->getValue()=="Verdiep") 
										echo $veld->getCategorie()->getNaamNL()." ".$formulier->getKamer()->getVerdiep()."e";
									else
										echo $veld->getCategorie()->getNaamNL() ; 
								?></td>
								<td colspan="2"><?=$veld->getNaamNL();?></td>
							</tr>
							<?
						}
						?>
						<tr>
							<td>Opmerking:</td>
							<td colspan="3"><?=$formulier->getOpmerking();?></td>
						</tr>
						</table>
					</div>
					<?
					$lijst = Herstelformulier::getList($formulier->getStudent()->getId(), ""); 
					if (sizeof($lijst) > 0) {
					?>
					<div id="meerHerstellingen">
						<table>
							<tr class="tabelheader"><td colspan="4">Andere herstelformulieren van deze student</td></tr>
							<tr class="legende">
								<td>Datum ingave</td>
								<td>Status</td>
								<td>Kamer</td>
								<td></td>
							</tr>
							<?
							foreach ($lijst as $status => $formlist) {
								foreach ($formlist as $form) {
									if ($form->getId() != $formid) {
									?>
										<tr>
											<td><?=$form->getDatum(); ?></td>
											<td><?=$status;?></td>
											<td><?=$form->getKamer()->getKamernummerKort();?></td>
											<td><a href="personeelMeldingInformatie.php?formid=<?=$form->getId();?>"><img src="images/externesite.gif"/></a></td>
										</tr>
									<?
									}
								}
							}
							?>
						</table>
					</div>
					<?
					}
					
					$lijst = Herstelformulier::getKamerList($formulier->getKamer());
					if (sizeof($lijst) > 0) {
					?>
					<div id="meerHerstellingen">
						<table>
							<tr class="tabelheader"><td colspan="4">Andere herstelformulieren op deze kamer</td></tr>
							<tr class="legende">
								<td>Datum ingave</td>
								<td>Status</td>
								<td>Student</td>
								<td></td>
							</tr>
							<?
							foreach ($lijst as $form) {
								if ($form->getId() != $formid) {
									?>
									<tr>
										<td><?=$form->getDatum(); ?></td>
										<td><?=$status;?></td>
										<td><?=$form->getStudent()->getAchternaam()." ".$form->getStudent()->getVoornaam();?></td>
										<td><a href="personeelMeldingInformatie.php?formid=<?=$form->getId();?>"><img src="images/externesite.gif"/></a></td>
									</tr>
									<?
								}
							}
							?>
						</table>
					</div>
					<?
					}
					?>
				</div>
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav" class="DONTPrint">
					
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
			<div id="login-act" class="DONTPrint">
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 	</div>
		<? } else{ ?>
			<div id="login" class="DONTPrint">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen">aanmelden</a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>