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
					<h1><?=$taal->msg('adresaanpassen') ?></h1>
					<p><?=$taal->msg('adresaanpassen_disclaimer'); ?></p>
					<form class="bodyform" method="post">
			        <fieldset>
			          <legend><?=$taal->msg('gegevens');?></legend>
			          <div>
			            <label><?=$taal->msg('naam');?></label>
			            <input name="naam" type="text"/>
			          </div>
			          <div>
			            <label><<?=$taal->msg('voornaam');?></label>
			            <input name="voornaam" type="text"/>
			          </div>
			          <div>
			            <label><?=$taal->msg('studentennummer');?></label>
			            <input name="studnummer" type="text"/>
			          </div>
			          <div>
			            <label><?=$taal->msg('email'); ?></label>
			            <input name="email" type="text"/>
			          </div>
			          <div>
			            <label><?=$taal->msg('home'); ?></label>
			            <input name="home" type="text"/>
			          </div>
			          <div>
			            <label><?=$taal->msg('kamernummer'); ?></label>
			            <input name="kamer" type="text"/>
			          </div>
			          <input type="submit" value="<?=$taal->msg('versturen');?>"/>
			        </fieldset>
			      </form>
			    <?} 
			    else{
			    
			    	$mailer = new Mailer();
					$mailer->setHTMLCharset("UTF-8");
					$mailer->setFrom($_POST['email']);
					$mailer->setCc($_POST['email']);
					$mailer->setSubject("adreswijziging");
					$mailer->setText("Beste,\n\nIs het mogelijk van de kotadres gegevens van de volgende student aan te passen?\n\n".$_POST['voornaam']." ".$_POST['naam']."\nStudentennummer: ".$_POST['studnummer']."\nKotadres:\n".$_POST['home'].", kamernummer ".$_POST['kamer']."\n\n\n==========\nDeze e-mail werd gegenereerd door het Online Herstelformulier van de Afdeling Huisvesting");
					$mailer->send(array("mesuerebart@gmail.com"));//helpdesk.studadmin@UGent.be
			    	
			    	?>
			    <h1><?=$taal->msg('adresaanpassen'); ?></h1>
				<p><?=$taal->msg('adresaanpassen_submitted'); ?></p>
			    <?} ?>
				</div>		
			</div>		
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>
