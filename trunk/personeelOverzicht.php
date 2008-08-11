<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'LeftMenu.class.php';
	require_once 'Header.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/jquery/json.js"></script>
	    <script type="text/javascript" src="js/personeelOverzicht.js"></script>	
	</head>
	<body>	
		<?new Header(array("#"), array("Overzicht")); ?>	
		<div id="container">
			<div id="contenthome">
				<h1>Overzicht Herstelformulieren</h1>
				<table>
						<tr class="tabelheader"><td colspan="6">Herstelformulieren</td></tr>
						<tr class="legende"><td></td><td>id</td><td>Datum</td><td>Status</td><td>Kamer</td><td>Factuurnummer</td></tr>
						<tr class="filter"><td></td><td></td><td><input type="text" id="datum"/></td><td><input type="text" id="status"/></td><td><input type="text" id="kamer"/></td><td><input type="text" id="factuurnummer"/></td></tr>
						<tbody id="inhoud"></tbody>
				</table>
				<p id="paginering"></p>
				<p><a href="backendExport.php">Exporteer deze gegevens!</a></p>
			</div>				
					
			<!--de footer-->
			<div id="footer">&#169; 2008 Bart Mesuere in opdracht van het <a href="http://www.knokke-heist.be">Gemeentebestuur Knokke-Heist</a></div>
		</div>
		<? new LeftMenu("overzicht", "personeelOverzicht.php"); ?>
	</body>
</html>
