<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Auth.class.php';
	require_once 'Footer.class.php';
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
		
		<!-- syndication -->
		<!-- meta (http-equiv) -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
		
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/studentOverzicht.js"></script>
	</head>
	<body>
		<!--main content-->
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<!--horizontale navigatiebalk bovenaan-->
				<?new Menu("Overzicht", "studentOverzicht.php"); ?>
				<!--de inhoud van de pagina-->
				<div id="verwijderconfirm" style="display:none"><?=$taal->msg('confirm_verwijder') ?></div>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="http://www.ugent.be/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
				
					<? if($auth->getUser()->isStudent()){ ?>
					<div>
						<h1><?=$taal->msg('overzicht') ?></h1>
						<? 
						$l = Herstelformulier::getList($auth->getUser()->getId());
						$lijst = array();
						foreach ($l as $subl){
							$lijst = array_merge($lijst, $subl);
						}
						if (sizeof($lijst) > 0) {
						?>
						<p class="disclaimer"><? printf($taal->msg('welkom_overzicht_naam'), $auth->getUser()->getVoornaam()); ?></p>
						<table>
							<tr class="tabelheader"><td colspan="6"><?=$taal->msg('overzicht_herstellingen') ?></td></tr>
							<?
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
						<? } else { ?>
						<p align="justify"><?=$taal->msg('overzicht_niets') ?></p>
						<? } ?>
					</div>
					<?} else{ ?>
						<meta http-equiv="Refresh" content="0; URL=personeelOverzicht.php">			
					<?}?>
					
				</div>		
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>