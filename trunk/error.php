<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'Topmenu.class.php';
	require_once 'Header.class.php';
	require_once 'Taal.class.php';
	
	$taal = new Taal();
	
	if(isset($_SESSION['error'])) {
		$e = $_SESSION['error'];
		// TODO: zend mail
	}
	else
		$e = $taal->msg('geen_error');
		
	$_SESSION['error']=NULL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel') ?></title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<?new Header(array("#"), array("Error")) ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<h1><?=$taal->msg('fout') ?></h1>
				<p><?=$e ?></p>
				<p><?=$taal->msg('fout_disclaimer') ?></p>
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer"><?=$taal->msg('footer') ?></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt><?=$taal->msg('handige_links') ?></dt>
				<dd><ul>
					<li><a href="http://helpdesk.ugent.be">&#187; Helpdesk</a></li>
					<li><a href="http://www.ugent.be/nl/voorzieningen/huisvesting">&#187; Huisvesting</a></li>
					<li><a href="https://minerva.ugent.be/">&#187; Minerva</a></li>
				</ul></dd>
			</dl>				
		</div>
		 
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>