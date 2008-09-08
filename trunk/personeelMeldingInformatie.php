<?
	session_start();
	require_once 'classes/Config.class.php';
	require_once 'BadParameterException.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
	$taal = new Taal();
	$auth = new Auth(false);
	if(!$auth->getUser()->isPersoneel())
		throw new AccessException();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel');?></title>
	    <style type="text/css" media="all">@import url(reset.css);</style>
		<style type="text/css" media="all">@import url(screen.css);</style>
		<style type="text/css" media="print">@import url(print.css);</style>
		<style type="text/css" media="all">@import url(ploneCustom.css);</style>
		
		<!-- Internet Explorer 6 CSS Fixes -->
		<!--[if IE 6]>
			        <style type="text/css" media="all">@import url(ie6.css);</style>
		<![endif]-->
		
		<!-- Internet Explorer 7 CSS Fixes -->
		<!--[if IE 7]>
			        <style type="text/css" media="all">@import url(ie7.css);</style>
		<![endif]-->
		
		<meta http-equiv="imagetoolbar" content="no" />
		
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/personeelMeldingInformatie.js"></script>
		<? if ($_GET['formid']==""){
				echo("<meta http-equiv='refresh' content='0;url=personeelOverzicht.php'>");
				die();
			}?>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Overzicht"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div id="success" style="display:none"><h1>Succes</h1><p>Dit herstelformulier werd als hersteld ge&#235valueerd. Klik <a href="personeelOverzicht.php">hier</a> om terug te gaan naar het overzicht.</p></div>
					<div id="negatiefsuccess" style="display:none"><h1>Succes</h1><p>Dit herstelformulier werd als niet-hersteld ge&#235valueerd. Klik <a href="personeelOverzicht.php">hier</a> om terug te gaan naar het overzicht.</p></div>
					<div id="error" style="display:none"><h1>Fout</h1><p>Er is een fout opgetreden bij het evalueren van dit herstelformulier, probeer het later opnieuw.</p></div>
					<div id='beforecontent'>
						<h1>Meer informatie</h1>
						<p class="disclaimer">Hier vindt u meer informatie over het geselecteerde herstelformulier, met bijhorende informatie over dezelfde student en/of dezelfde kamer. Indien er nog acties beschikbaar zijn voor het herstelformulier wordt dit aangegeven door &#233&#233n of meerdere icoontjes: het doorgeven-icoontje (<img src="images/page_edit.gif"/>), positief-evalueren-icoontje (<img src="images/icon_accept.gif"/>) en het negatief-evalueren-icoontje (<img src="images/action_stop.gif"/>). Indien er geen acties zichtbaar zijn, is dit herstelformulier afgewerkt.</p>
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
								<td>Home</td>
								<td>Kamer</td>
							</tr>
							<tr>
								<td><?=$formulier->getDatum();?></td>
								<td><?=$formulier->getStudent()->getAchternaam()." ".$formulier->getStudent()->getVoornaam();?></td>
								<td>Home <?=$formulier->getKamer()->getHome()->getKorteNaam();?></td>
								<td><?=$formulier->getKamer()->getKamernummerLang();?></td>
							</tr>
							<tr><td colspan="4" class="unityheader">Gemelde defecten:</td></tr>
							<?
							foreach ($formulier->getVeldenlijst() as $veldid) {
								$veld = new Veld($veldid);
								?>
								<tr class="unity">
									<td></td>
									<td><? 
										if($veld->getCategorie()->getLocatie()->getValue()=="Kot") 
											echo "Kamer ".$formulier->getKamer()->getKamernummerLang();
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
								<td>Opmerking door student:</td>
								<td colspan="3"><?=$formulier->getOpmerking();?></td>
							</tr>
							<?
							if ($formulier->getStatus()->getValue() == "ongezien" || $formulier->getStatus()->getValue() == "gedaan") {
							?>
							<tr id="acties">
								<td colspan="3"><p align="right">Meer acties:</p></td>
								<td>
								<?
								if ($formulier->getStatus()->getValue() == "ongezien") {
								?>
								<a href='personeelMeldingDoorgeven.php?formid=<?=$formulier->getId()?>'><img class="klik" src="images/page_edit.gif" alt="Dit herstelformulier doorgeven" title="Dit herstelformulier doorgeven"/></a>&nbsp;&nbsp;
								<? 
								} 
								if ($formulier->getStatus()->getValue() == "gedaan") {
								?>
								<img class="klik" src="images/icon_accept.gif" alt="Dit herstelformulier positief evalueren" title="Dit herstelformulier positief evalueren" onclick="evalueerPositief('<?=$formulier->getId();?>');"/>&nbsp;&nbsp;<img class="klik" src="images/action_stop.gif" alt="Dit herstelformulier negatief evalueren" title="Dit herstelformulier negatief evalueren" onclick="evalueerNegatief('<?=$formulier->getId() ?>');"/>
								<?
								}
								?>
								</td>
							</tr>
							<tr id="new_row" style="display:none">
								<td>Aangepaste opmerking:</td>
								<td colspan="2"><textarea name="opmerking" cols="50" rows="8"><?=$formulier->getOpmerking() ?></textarea></td>
								<td><img alt="doorgeven" class="bewerk klik" title="Deze opmerking doorsturen" src="images/icon_accept.gif" onclick="zendOpmerking('<?=$formulier->getId()?>');"/></td>
							</tr>
							<? 
							} else {
							?>
							<tr id="acties">
								<td colspan="4"><p align="right">Dit herstelformulier is afgewerkt.</td>
							</tr>
							<? } ?>
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
												<td><?=$form->getKamer()->getKamernummerLang();?></td>
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
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>