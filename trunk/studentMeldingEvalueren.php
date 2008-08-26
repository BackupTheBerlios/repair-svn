<?
	session_start();
	require_once 'classes/Config.class.php';
	require_once 'BadParameterException.class.php';
	require_once 'AccessException.php';
	require_once 'Herstelformulier.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(true);
	if(!$auth->getUser()->isStudent())
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
		<script type="text/javascript" src="js/evaluatieMelding.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Melding"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div id="success" style="display:none"><?=$taal->msg('succes_melding_bewerkt') ?></div>
					<div id="error" style="display:none"><h1><?=$taal->msg('fout')?></h1><?=$taal->msg('error_melding_evalueren') ?></div>
					<div id="opmerkingvertaling" style="display:none"><?=$taal->msg('opmerking') ?></div>
					<div id='beforecontent'>
						<? 
						if($auth->isLoggedIn()) { 
							if($auth->getUser()->isStudent()) {
									// Toon listing van alle formulieren die als "gedaan" gemarkeerd zijn en die geevalueerd moeten worden
									$list = Herstelformulier::getEvaluationList($auth->getUser()->getId());
									?>
									<h1><?=$taal->msg('evaluatie_titel') ?></h1>
									<p class="disclaimer"><?=$taal->msg('disclaimer_evaluatie_melding') ?></p>
									<table>
										<tbody>
											<tr class="legende">
												<td><?=$taal->msg('datum');?></td>
												<td><?=$taal->msg('inhoud');?></td>
												<td colspan="2"></td>
											</tr>
											<?
											foreach ($list as $formulier) {
												?>
													<tr id="row_<?=$formulier->getId();?>"><td><?=$formulier->getDatum();?></td><td><?=$formulier->getSamenvatting();?></td><td class="img"><img alt="doorgeven" class="bewerk klik" title="Dit herstelformulier positief evalueren" src="images/icon_accept.gif" onclick="evalueerPositief('<?=$formulier->getId();?>');"/></td><td class="img"><img alt="doorgeven" class="bewerk klik" title="Dit herstelformulier negatief evalueren" src="images/action_stop.gif" onclick="evalueerNegatief('<?=$formulier->getId();?>');"/></td></tr>
													<?
											}
											?>
										</tbody>
									</table>
									<?
							} else throw new AccessException("only students can evaluate repairforms");
						} else throw new AccessException("you have to be logged in");
						?>
					</div>
				</div>	
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>	
	</body>
</html>