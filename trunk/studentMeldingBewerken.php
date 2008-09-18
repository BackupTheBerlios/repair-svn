<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'BadParameterException.class.php';
	require_once 'AccessException.php';
	require_once 'Veld.class.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Status.class.php';
	require_once 'Auth.class.php';
	require_once 'Menu.class.php';
	require_once 'Taal.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	
	
	$auth = new Auth(true);
	if (!$auth->getUser()->isStudent()) 
		throw new AccessException();
	$taal = new Taal();
	
	// Input sanitizing
	$formid = $_GET['formid'];
	if (!is_numeric($formid) || $formid < 0)
		throw new BadParameterException("Parameter ".htmlspecialchars($formid)." is niet geldig");
		
	$formulier = new Herstelformulier($formid);
	if ($formulier->getStudent()->getId() != $auth->getUser()->getId())
		throw new AccessException("editting student should be original author");
		
	if ($formulier->getStatus()->getValue() != "ongezien")
		throw new BadParameterException("only unseen repairforms can be editted");
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
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/bewerkMelding.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("index.php","#"), array("Index", "Melding_bewerken")); ?>
			<div id="main">
				<?new Menu("Melding"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div id="success" style="display:none"><?=$taal->msg('succes_melding_bewerkt') ?></div>
					<div id="error" style="display:none"><h1><?=$taal->msg('fout')?></h1><?=$taal->msg('error_melding_bewerkt') ?></div>
					<div id="beforecontent">
					<?
					$user = NULL;
					$currentHome = NULL;
					if ($auth->getUser()->isStudent()) {
						$user = $auth->getUser();
						$currentHome = $user->getHome();
					}
					
					?>
					<h1><?=$taal->msg('herstelformulier_bewerken') ?></h1>
					<p class="disclaimer"><?=$taal->msg('herstelformulier_bewerken_disclaimer') ?></p>
					<form id='meldingform'>
					<table>
							<tr class="tabelheader"><td colspan="4"><? printf($taal->msg('herstelformulier_homenaam'),$currentHome->getKorteNaam()); ?></td></tr>
							<?
									$huidigeLijst = Veld::getHomeForm($currentHome); // array<Veld>
									$ingevuldeLijst = $formulier->getVeldenlijst(); // array<VeldID>
									// vergelijking van huidigelijst met ingevuldeLijst. Alle velden van huidigeLijst moeten overblijven + velden die in ingevuldeLijst zitten zonder duplicates te maken
									
									$allesok = true;
									foreach($ingevuldeLijst as $veldid){
										$veld = new Veld($veldid);
										if ($veld->getVerwijderd())
											$allesok = false;
									}
									
									if(!$allesok){
										// TODO: een treffelijk algoritme voor dit probleem
										foreach($ingevuldeLijst as $veldid) {
											$veld = new Veld($veldid);
											$positie = 0; // positie om het Veld in te voegen in HuidigeLijst (adhv de Locatie en categorie)
											if ($veld->getVerwijderd()) { // veld zal niet in huidigeLijst zitten
												for ($i = 0; $i < sizeof($huidigeLijst); $i++) {
													$huidigVeld = $huidigeLijst[$i];
													if ($huidigVeld->getCategorie()->getLocatie() == $veld->getCategorie()->getLocatie() &&
														$huidigVeld->getCategorie()->getNaamNL() == $veld->getCategorie()->getNaamNL())
														$positie = $i;
												}
												array_splice($huidigeLijst, $positie, 0, array($veld));
											}
										}
									}
									
									foreach ($huidigeLijst as $veld) {
										$nieuweCategorie = $veld->getCategorie();
										$nieuweLocatie = $nieuweCategorie->getLocatie();
										if (!isset($huidigeLocatie) || ($huidigeLocatie->getValue() != $nieuweLocatie->getValue())) {
											$huidigeLocatie = $nieuweLocatie;
											echo("<tr class='subheader' id='locatie_".$huidigeLocatie->getValue()."'><td colspan='4'>".$huidigeLocatie->getValue()."</td></tr>");
										}
										if (!isset($huidigeCategorie) || ($huidigeCategorie->getNaamNL() != $nieuweCategorie->getNaamNL())) {
											$huidigeCategorie = $nieuweCategorie;
											echo("<tr class='subsubheader klik ".$huidigeLocatie->getValue()."' id='cat_".$huidigeCategorie->getId()."' onclick='showGroup(".$huidigeCategorie->getId().");'><td width='12px' id='collapse_".$huidigeCategorie->getId()."'>+</td><td colspan='3'>".$huidigeCategorie->getNaam()."</td></tr>");
											echo("<tr class='legende ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()."' style='display:none'><td></td><td>Defect</td><td>".$taal->msg('naam')."</td><td></td></tr>");
										}
										echo("<tr class='klik ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()." DONTPrint' id='item_".$veld->getId()."' onclick='checkItem(".$veld->getId().");' style='display:none'><td></td><td><input id='check_".$veld->getId()."' class='inputCheckbox' type='checkbox' name='".$veld->getId()."' onclick='checkItem(".$veld->getId().");'/></td><td>".$veld->getNaam()."<td></tr>");
									}
							?>
					</table>
					<div><label for="opmerking"><?=$taal->msg('opmerking') ?>:</label><div><textarea name="opmerking" id="opmerking" cols="50" rows="8"></textarea></div></div>
					<div><button name="submit" id="submit" type="submit"><?=$taal->msg('verzenden') ?></button></div>
					</form>
					</div>				
				</div>		
			</div>		
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>