<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Home.class.php';
	require_once 'Personeel.class.php';
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
		<script type="text/javascript" src="js/personeelAdminBeheerders.js"></script>
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
						<h1>Beheer Personeel</h1>
						<p class='disclaimer'>Hier kunt u personeelsleden toevoegen en bewerken. Klik op het <img src="images/page_edit.gif"/>-icoon om de rechten van een beheerder aan te passen, klik op het <img src="images/page_delete.gif"/>-icoon om een bestaande beheerder deze rechten te ontnemen. Onderaan heeft u ook de mogelijkheid om een nieuwe beheerder toe te voegen. Daarvoor moet de volledige naam niet ingevuld worden, enkel de gebruikersnaam geleverd door DICT is genoeg.</p>
						<table>
							<tr class="tabelheader"><td colspan="8">Beheer Personeel</td></tr>
							<tr class="legende"><td>id</td><td>UgentID</td><td>Voornaam</td><td>Familienaam</td><td>Homes</td><td>email</td><td></td><td></td></tr>
							<?
								$personeel = Personeel::getBeheerders();
								foreach($personeel as $p){
									$id = $p->getId();
									echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='gebruikersnaam_$id'>".$p->getGebruikersnaam()."</td><td class='voornaam'>".$p->getVoornaam()."</td><td class='achternaam'>".$p->getAchternaam()."</td><td class='homes'>");
									$homes = $p->getHomesLijst();
									foreach($homes as $home){
										echo "Home ".$home->getKorteNaam()."<br/>";
									}
									echo("</td><td class='mails'>");
									echo("<input type='checkbox' class='inputCheckbox' disabled='true' id='mails_$id' value='".$p->getMails()."' "); echo $p->getMails()?"checked='".$p->getMails()."'":"" ; echo("/>");
									echo("</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'><img src='images/page_delete.gif' /></td></tr>");
								}
								echo("<tr><td>x</td><td class='edit' id='gebruikersnaam'><input type='text'/></td><td id='voornaam'></td><td id='achternaam'></td><td class='homes'>");
								$l = Home::getHomes();
								foreach($l as $home){
									echo("
									<label for='home_".$home->getId()."' ><input type='checkbox' id='home_".$home->getId()."' name='home_".$home->getId()."' class='Home ".$home->getKorteNaam()."' value='".$home->getId()."'/>Home ".$home->getKorteNaam()."</label><br/>");
								}
								echo("</td><td class='mails' id='mails'><input type='checkbox'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
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