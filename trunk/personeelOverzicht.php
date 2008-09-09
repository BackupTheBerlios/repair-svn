<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Menu.class.php';
	require_once 'Auth.class.php';
	require_once 'Taal.class.php';
	$auth = new Auth(true);
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
		<script type="text/javascript" src="js/personeelOverzicht.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Overzicht"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<h1>Overzicht Herstelformulieren</h1>
					<p class="disclaimer">Hier kunt u alle herstelformulieren opvragen, ook diegene die al afgehandeld zijn. Door in &#233&#233n van de velden bovenaan te typen, kan u filteren in de resultatenlijst.</p>
					<table class="overzicht">
							<tr class="tabelheader"><td colspan="8">Herstelformulieren</td></tr>
							<tr class="legende"><td></td><td>id</td><td>Datum</td><td>Kamer</td><td>Home</td><td>Persoon</td><td>Status</td><td>Referentienummer</td></tr>
							<tr class="filter"><td></td><td></td><td><input type="text" id="datum"/></td><td><input type="text" id="kamer"/></td><td><input type="text" id="korteNaam"/></td><td><input type="text" id="concat(voornaam, ' ',achternaam)"/></td><td><input type="text" id="status"/></td><td><input type="text" id="factuurnummer"/></td></tr>
							<tbody id="inhoud"></tbody>
					</table>
					<p id="paginering"></p>
					<p class="DONTPrint"><a href="personeelExporteer.php">Exporteer deze gegevens!</a></p>
				</div>				
			</div>
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>
