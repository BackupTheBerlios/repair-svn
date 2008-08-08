<?
	session_start();
	require_once 'classes/exceptions/BadParameterException.class.php';
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Auth.class.php';
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
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/evaluatieMelding.js"></script>
	</head>
	<body>
		<!--logo linksboven-->
		<div id="logo"><img src="images/logo.gif" width="200" height="60" alt="Logo Universiteit Gent" usemap="#linklogo" /><map name="linklogo" id="linklogo"><area shape="rect" coords="60,0,142,60" href="http://www.ugent.be" alt="Startpagina Universiteit Gent" /></map></div>
		
		<!--pagina titel-->
		<div id="siteid"><img src="images/siteid-portal.jpg" width="300" height="80" alt="Portaalsite Universiteit Gent" /><a href="index.php" class="text" ><?=$taal->msg('titel'); ?></a></div>
		
		<!--linkjes rechtsboven-->
		<div id="utility">
			<a href="help.php">CSS</a> | <a href="#">English</a> | <a href="#">Contact</a> | <a href="#" onclick="window.print()">Print</a>
		</div>
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='index.php'><?=$taal->msg('dringende_herstellingen');?></a> &gt; Index
		</div>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div id='beforecontent'>
					<? 
					if($auth->isLoggedIn()) { 
						if($auth->getUser()->isStudent()) {
								// Toon listing van alle formulieren die als "gedaan" gemarkeerd zijn en die geevalueerd moeten worden
								$list = Herstelformulier::getEvaluationList($auth->getUser()->getId());
								?>
								<table>
									<tr class="tableheader">
										<td colspan="4"><?=$taal->msg('disclaimer_evaluatie_melding');?></td>
									</tr>
									<tbody>
										<tr class="legende">
											<td><?=$taal->msg('datum');?></td>
											<td><?=$taal->msg('inhoud');?></td>
											<td colspan="2"></td>
										</tr>
										<?
										foreach ($list as $formulier) {
											?>
												<tr id="row_<?=$formulier->getId();?>"><td><?=$formulier->getDatum();?></td><td><?=$formulier->getSamenvatting();?></td><td class="img klik"><img alt="doorgeven" class="bewerk" title="Dit herstelformulier positief evalueren" src="images/icon_accept.gif" onclick="evalueerPositief('<?=$formulier->getId();?>');"/></td><td class="img klik"><img alt="doorgeven" class="bewerk" title="Dit herstelformulier negatief evalueren" src="images/action_stop.gif" onclick="evalueerNegatief('<?=$formulier->getId();?>');"/></td></tr>
												<?
										}
										?>
									</tbody>
								</table>
								<?
						} else throw new Exception("Unauthorized access!"); // TODO: gepaste exception
					} else throw new Exception("Unauthorized access!"); // TODO: gepaste exception
					?>
				</div>
			</div>	
		</div>		
		
		<!--de footer-->
		<div id="footer"><?=$taal->msg('footer');?></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt><?=$taal->msg('handige_links');?></dt>
				<dd><ul>
					<li><a href="http://helpdesk.ugent.be">&#187; Helpdesk</a></li>
					<li><a href="http://www.ugent.be/nl/voorzieningen/huisvesting">&#187; Huisvesting</a></li>
					<li><a href="https://minerva.ugent.be/">&#187; Minerva</a></li>
				</ul></dd>
			</dl>				
		</div>
		
		<!--login aan de rechterkant-->
		<? if($auth->isLoggedIn()){ ?>
			<div id="login-act">
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" ><?=$taal->msg('afmelden');?></a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen"><?=$taal->msg('aanmelden');?></a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>