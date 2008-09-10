<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Veld.class.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Status.class.php';
	require_once 'Auth.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Taal.class.php';
	$auth = new Auth(true);
	if (!$auth->getUser()->isStudent()) 
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

		<meta http-equiv="imagetoolbar" content="no" />
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/nieuweMelding.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Melding"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div id="success" style="display:none"><? printf($taal->msg('succes_melding_toegevoegd_url'),"studentOverzicht.php"); ?></div>
					<div id="error" style="display:none"><h1><?=$taal->msg('fout')?></h1><?=$taal->msg('error_melding_toevoegen') ?></div>
					<div id="beforecontent">
					<h1><?=$taal->msg('herstelformulier_nieuw') ?></h1>
					<p class="disclaimer"><?=$taal->msg('herstelformulier_nieuw_disclaimer') ?></p>
					<?
					$user = NULL;
					$currentHome = NULL;
					if ($auth->getUser()->isStudent()) {
						$user = $auth->getUser();
						$currentHome = $user->getHome();
					}
					
					?>
					<form id='meldingform'>
					<table>
							<tr class="tabelheader"><td colspan="4"><? printf($taal->msg('herstelformulier_homenaam'),$currentHome->getKorteNaam()); ?></td></tr>
							<?
								$lijst = Veld::getHomeForm($currentHome);
	
								foreach($lijst as $veld) {
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
									echo("<tr class='klik ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()." ' id='item_".$veld->getId()."' onclick='checkItem(".$veld->getId().");' style='display:none'><td></td><td><input class='inputCheckbox' id='check_".$veld->getId()."' type='checkbox' name='".$veld->getId()."' onclick='checkItem(".$veld->getId().");'/></td><td>".$veld->getNaam()."</td><td></td></tr>");
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