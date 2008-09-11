<? 
	session_start(); 
	require_once 'classes/Config.class.php';	
	require_once 'Herstelformulier.class.php';
	require_once 'Taal.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(true);
	$taal = new Taal();
	
	if (!$auth->getUser()->isPersoneel())
		throw new AccessException("");
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
			<?new Header(array("index.php","#"), array("Index", "Statistieken")); ?>
			<div id="main">
				<?new Menu(""); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<? if($auth->isLoggedIn()){ //we zijn ingelogd
						if ($auth->getUser()->isPersoneel()) { // personeel
						?>
							<h1>Statistieken</h1>
							<p class="disclaimer">Hier vindt u binnenkort de statistieken over deze applicatie.</p>
							<img src='graphs/tijd_formulier.php' alt='grafiekje'/>
						<?
						}
					}
					?>
				</div>		
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>