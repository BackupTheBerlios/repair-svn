<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
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

		<meta http-equiv="imagetoolbar" content="no" />
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/personeelAdminHomes.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Beheer"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div>
						<h1>Beheer Homes</h1>
						<p class='disclaimer'>Hier kunt u homes toevoegen en bewerken. Klik op het <img src="images/page_edit.gif"/>-icoon om een bestaande Home aan te passen, klik op het <img src="images/page_delete.gif"/>-icoon om een bestaande Home te verwijderen. Onderaan heeft u ook de mogelijkheid om een nieuwe Home toe te voegen.</p>
						<table>
							<tr class="tabelheader"><td colspan="9">Beheer Homes</td></tr>
							<tr class="legende"><td>id</td><td>Korte naam</td><td>Lange naam</td><td>Adres</td><td>Verdiepen</td><td>Kamer prefix</td><td>LDAP naam</td><td></td><td></td></tr>
							<?
								$homes = Home::getHomes();
								foreach($homes as $home){
									$id = $home->getId();
									// TODO: aantalKamersPerVerdiep en basisTelefoonnummer toevoegen
									echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='korteNaam_$id'>".$home->getKorteNaam()."</td><td class='edit' id='langeNaam_$id'>".$home->getLangeNaam()."</td><td class='edit adres' id='adres_$id'>".$home->getAdres()."</td><td class='edit verdiep' id='verdiepen_$id'>".$home->getVerdiepen()."</td><td class='edit prefix' id='kamerPrefix_$id'>".$home->getKamerPrefix()."</td><td class='edit' id='ldapNaam_$id'>".$home->getLdapNaam()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
								}
								echo("<tr><td></td><td class='edit' id='korteNaam'><input class='naam' type='text'/></td><td class='edit' id='langeNaam'><input class='naam' type='text'/></td><td class='edit' id='adres'><input class='adres' type='text'/></td><td class='edit' id='verdiepen'><input class='verdiep' type='text'/></td><td class='edit' id='kamerPrefix'><input class='prefix' type='text'/></td><td class='edit' id='ldapNaam'><input class='naam' type='text'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
							?>
						</table>
					</div>
				</div>		
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>