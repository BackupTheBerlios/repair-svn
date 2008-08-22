<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Veld.class.php';
	require_once 'Locatie.class.php';
	require_once 'Home.class.php';
	require_once 'Auth.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Taal.class.php';
	$taal = new Taal();
	$auth = new Auth(true);
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
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/personeelAdmin.js"></script>
	</head>
	<body>
		<!--main content-->
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<!--horizontale navigatiebalk bovenaan-->
				<?new Menu("Beheer", "personeelAdmin.php"); ?>
				<!--de inhoud van de pagina-->
				<div id="content" class="small">
					<div>
						<h1>Beheer</h1>
						<?if($_GET['homeId']=="") {?>
							<p>U kunt de herstelformulieren van volgende homes aanpassen:</p><ul>
							<?
								$lijst = $auth->getUser()->getHomesLijst();
								foreach($lijst as $home)
									echo "<li><a href='personeelAdmin.php?homeId=".$home->getId()."'>Home ".$home->getKorteNaam()."</a></li>"
							 ?>
							 </ul>
							 <p>U kunt ook <a href='personeelAdminBeheerders.php'>beheerders aanmaken</a> en <a href='personeelAdminHomes.php'>homes aanmaken en bewerken</a></p>
						<?}
						else{ 
							$currentHome = new Home($_GET['homeId']);	
							$locaties = Locatie::getAllValues();
							echo("<p>Hieronder kunt u het herstelformulier van Home ".$currentHome->getKorteNaam()." aanpassen.</p>");
							?>
							<table>
								<tr class="tabelheader"><td colspan="5">Herstelformulier <?=$currentHome->getKorteNaam(); ?></td></tr>
								<?
								foreach ($locaties as $index => $locatie) {
								?>
								<tr class="subheader"><td colspan="5"><?=$locatie->getValue(); ?></td></tr>
								<tr class="legende"><td>Naam Nederlands</td><td>Naam Engels</td><td>Categorie</td><td></td><td></td></tr>
								<?
									$lijst = Veld::getHomeLocationFields($currentHome,$locatie);
									foreach($lijst as $veld){
										$id = $veld->getId();
										echo("<tr id='".$id."_".$locatie->getValue()."'><td class='edit' id='naamNL_$id'>".$veld->getnaamNL()."</td><td class='edit' id='naamEN_$id'>".$veld->getnaamEN()."</td><td class='select' id='categorie_$id'>".$veld->getCategorie()->getNaamNL()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
									}
									echo("<tr id='".$locatie->getValue()."_".$_GET['homeId']."'><td class='edit' id='naamNL_".$locatie->getValue()."'><input type='text'/></td><td class='edit' id='naamEN_".$locatie->getValue()."'><input type='text'/></td><td class='dd select' id='categorie_".$locatie->getValue()."'></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
								}
								?>
							</table>
						<?} ?>
					</div>
				</div>		
			</div>
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>