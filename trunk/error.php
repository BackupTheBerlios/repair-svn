<? 
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
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
			<?new Header(array("index.php","#"), array("Index", "Error")); ?>
			<div id="main">
				<?new Menu(""); ?>
				<div id="content" class="small">
					<h1><?=$taal->msg('fout') ?></h1>
					<p><?=$e ?></p>
					<p><?=$taal->msg('fout_disclaimer') ?></p>
				</div>		
			</div>		
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>