<? 
	session_start(); 
	require_once 'classes/Config.class.php';	
	require_once 'Herstelformulier.class.php';
	require_once 'Taal.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	$taal = new Taal();
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
		<script type="text/javascript" src="js/studentOverzicht.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu(""); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<? if($auth->isLoggedIn()){ //we zijn ingelogd
						if($auth->getUser()->isStudent()){//Student?>
							<div>
								<h1><?=$taal->msg('welkom');?></h1>
								<?
								$list = Herstelformulier::getEvaluationList($auth->getUser()->getId());
								if (sizeof($list) > 0) {
								?>
								<div id="spotlight" class="spotlight">
									<div class="sectiontitle">
        								<h2><?=$taal->msg('herstelformulieren_te_evalueren_titel')?></h2>
    								</div>
    								<div class="columns">		
		       							<p class="disclaimer"><?=$taal->msg('herstelformulieren_te_evalueren_disclaimer') ?></p>
	  	  								<p class="readmore">
	           								<a href="studentMeldingEvalueren.php"><?=$taal->msg('herstelformulieren_te_evalueren_evalueer') ?></a>	
	        							</p>
									</div>
								</div>
								<?
								}
								?>
								<p>
									<? printf($taal->msg('welkom_naam_home_kamer'),$auth->getUser()->getVoornaam(),$auth->getUser()->getHome()->getKorteNaam(),$auth->getUser()->getKamer()->getKamernummerLang());?>
									<br/><?=$taal->msg('keuze_opties'); ?>
								</p>
								<ul>
									<li><?=$taal->msg('meld_nieuw_defect');?></li>
									<li><?=$taal->msg('overzicht_aanvragen');?></li>
								</ul>
								<div id="verwijderconfirm" style="display:none"><?=$taal->msg('confirm_verwijder') ?></div>
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
											echo("<tr class='".$huidigeStatus->getValue()."' id='row_".$form->getId()."'><td></td><td class='langedatum'>");
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
						<?}
						else{//personeel?>
							<h1>Welkom <?=$auth->getUser()->getVoornaam() ?></h1>
							<p class="disclaimer">Hier ziet u eerst en vooral de herstellingen die u nog niet doorgegeven heeft. Klik op het <img src="images/page_edit.gif"/>-icoontje om het herstelformulier te bekijken, en het eventueel door te geven. Helemaal onderaan vindt u de herstellingen die al doorgegeven zijn, maar die nog niet ge&#235valueerd werden door de student. Indien nodig voor het type probleem, kan u die evaluatie zelf doen via het <img src="images/externesite.gif"/>-icoontje.</p>
							<table>
								<tr class="tabelheader"><td colspan="6">Overzicht van herstellingen die niet afgewerkt zijn</td></tr>
								<?
								$lijst = Herstelformulier::getList(0, new Status("ongezien"));
								$size = sizeof($lijst);
								if ($size > 0) {
								?>
								<tr class="subheader"><td colspan="5">Ongeziene herstellingen</td></tr>
								<tbody>
									<tr class="legende">
										<td></td>
										<td>Datum</td>
										<td>Inhoud</td>
										<td></td>
										<td></td>
									</tr>
								<?
									for($i=0; $i < $size;$i++){
										$form = $lijst[$i];
										echo("<tr id='row_".$form->getId()."'><td></td><td class='langedatum'>");
										$timestamp = strtotime($form->getDatum());
										$parsedDate = date("d-m-Y @ H:i",$timestamp);
										echo($parsedDate);
										echo("</td><td>".$form->getSamenvatting()."</td>");
										echo("<td class='img'><a href='personeelMeldingDoorgeven.php?formid=".$form->getId()."'><img alt='Doorgeven Herstelformulier' class='bewerk' title='Dit herstelformulier doorgeven' src='images/page_edit.gif'/></a></td>");
										echo("<td></td>");
										echo("</tr>");
									}
								 ?>
								</tbody>
								<?
								}
								
								$lijst = Herstelformulier::getList(0, new Status("gedaan"));
								$size = sizeof($lijst);
								if ($size > 0) {
		 						?>
								<tr class="subheader"><td colspan="5">Doorgegeven herstellingen die nog niet afgesloten zijn</td></tr>
								<tbody>
									<tr class="legende"><td></td><td>Datum</td><td>Inhoud</td><td></td><td></td></tr>
									<?
									for($i=0; $i < $size; $i++){
										$form = $lijst[$i];
										echo("<tr id='row_".$form->getId()."'><td></td><td class='langedatum'>");
										$timestamp = strtotime($form->getDatum());
										$parsedDate = date("d-m-Y @ H:i",$timestamp);
										echo($parsedDate);
										echo("</td><td>".$form->getSamenvatting()."</td>");
										echo("<td></td>");
										echo("<td class='img'><a href='personeelMeldingInformatie.php?formid=".$form->getId()."'><img alt='Meer Informatie' title='Meer informatie over dit herstelformulier' src='images/externesite.gif'/></a></td>");
										echo("</tr>");
									}
								 ?>
								</tbody>
								<? } ?>
							</table>
						<?}
					} 
					else{ //niet ingelogd?>
						<div>
							<h1><?=$taal->msg('welkom');?></h1>
							<p><?=$taal->msg('welkom_niet_aangemeld');?></p>
						</div>				
					<?}?>
					
				</div>		
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>