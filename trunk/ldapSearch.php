<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Menu.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
	$auth = new Auth(true);
	if(!$auth->getUser()->isPersoneel())
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
		<script type="text/javascript" src="js/ldap.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("index.php", "#"), array("Index", "Ldap")); ?>
			<div id="main">
				<?new Menu("Ldap"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<h1>LDAP</h1>
					<p class="disclaimer">LDAP zoekfunctie voor intern gebruik</p>
					<table class="overzicht">
							<tr class="tabelheader"><td colspan="5">LDAP</td></tr>
							<tr class="legende"><td>Username</td><td>Voornaam</td><td>Familienaam</td><td>Home</td><td>Kamer</td></tr>
							<tr class="filter"><td><input type="text" id="uid"/></td><td><input type="text" id="givenname"/></td><td><input type="text" id="sn"/></td><td><input type="text" id="ugentdormstreetaddress"/></td><td><input type="text" id="ugentdormpostaladdress"/></td></tr>
							<tbody id="inhoud"></tbody>
					</table>
					<p id="paginering"></p>
				</div>				
			</div>
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>
