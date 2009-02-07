<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Mailer.class.php';
	require_once 'Footer.class.php';
	require_once 'Taal.class.php';
	
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
	</head>
	<body>
		<div id="container">
			<?new Header(array("index.php","#"), array("Index", "Gegevens wijzigen")); ?>
			<div id="main">
				<?new Menu(""); ?>
				<div id="content" class="small">
				<?
					if(!isset($_POST['naam'])){
				?>
					<h1>Kot adres aanpassen</h1>
					<p>Op deze pagina kan je je correcte kotgegevens invullen en doorsturen naar de centrale studentenadministratie</p>
					<form class="bodyform" method="post">
			        <input type="hidden" name="hurl" value="http://escher.elis.ugent.be/firw/login/">
			        <input type="hidden" name="haid" value="5173">
			        <input type="hidden" name="hqs" value="">
			        <input type="hidden" name="hsg" value="2b5138aaaaed544e0159adb379308ed2">
			        <fieldset>
			          <legend>Gegevens</legend>
			          <div>
			            <label>Naam</label>
			            <input name="naam" type="text">
			          </div>
			          <div>
			            <label>Voornaam</label>
			            <input name="voornaam" type="text">
			          </div>
			          <div>
			            <label>Studentennummer</label>
			            <input name="studnummer" type="text">
			          </div>
			          <div>
			            <label>E-mail adres</label>
			            <input name="email" type="text">
			          </div>
			          <div>
			            <label>Home</label>
			            <input name="home" type="text">
			          </div>
			          <div>
			            <label>Kamernummer</label>
			            <input name="kamer" type="text">
			          </div>
			          <input type="submit" value="Deze gegevens versturen">
			        </fieldset>
			      </form>
			    <?} 
			    else{
			    
			    	$mailer = new Mailer();
					$mailer->setHTMLCharset("UTF-8");
					$mailer->setFrom($_POST['email']);
					$mailer->setCc($_POST['email']);
					$mailer->setSubject("adreswijziging");
					$mailer->setText("Beste,\n\nIs het mogelijk van de kotadres gegevens van de volgende student aan te passen?\n\n".$_POST['voornaam']." ".$_POST['naam']."\nStudentennummer: ".$_POST['studnummer']."\nKotadres home: ".$_POST['home']." kamernummer: ".$_POST['kamer']."\n\n\n==========\nDeze e-mail werd gegenereerd door het Online Herstelformulier van de Afdeling Huisvesting");
					$mailer->send("mesuerebart@gmail.com");//helpdesk.studadmin@UGent.be
			    	
			    	?>
			    <h1>Kot adres aanpassen</h1>
				<p>De ingevulde gegevens werden doorgemaild naar de studentenadministratie en er werd een kopie naar jezelf gestuurd. Hou er rekening mee dat het na het verwerken van de gegevens door de studentenadministratie het nog 24 uur kan duren nadat deze aanpassing zichtbaar is op deze website.</p>
			    <?} ?>
				</div>		
			</div>		
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>