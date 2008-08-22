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
		
		<!-- syndication -->
		<!-- meta (http-equiv) -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
	</head>
	<body>
		<!--main content-->
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<!--horizontale navigatiebalk bovenaan-->
				<?new Menu("Overzicht", "personeelMeldingInformatie.php"); ?>
				<!--de inhoud van de pagina-->
				<div id="content" class="small">
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
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>