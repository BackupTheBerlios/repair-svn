<? 
	session_start(); 	
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Taal.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
	require_once 'classes/Auth.class.php';
	$auth = new Auth(false);
	$taal = new Taal();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel');?></title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<?new Header(array("#"), array("Index")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<? if($auth->isLoggedIn()){ if($auth->getUser()->isStudent()){?>
				<div>
					<h1><?=$taal->msg('welkom');?></h1>
					<?
					$list = Herstelformulier::getEvaluationList($auth->getUser()->getId());
					if (sizeof($list) > 0)
						echo "<center><b>".$taal->msg('herstelformulieren_te_evalueren')."</b></center>";
					?>
					<p>
						<? printf($taal->msg('welkom_naam_home_kamer'),$auth->getUser()->getVoornaam(),$auth->getUser()->getHome()->getKorteNaam(),$auth->getUser()->getKamer()->getKamernummerKort());?>
						<br/><?=$taal->msg('keuze_opties'); ?>
					</p>
					<ul>
						<li><?=$taal->msg('meld_nieuw_defect');?></li>
						<li><?=$taal->msg('overzicht_aanvragen');?></li>
					</ul>
				</div>
				<?}} else{ ?>
				<div>
					<h1><?=$taal->msg('welkom');?></h1>
					<p><?=$taal->msg('welkom_niet_aangemeld');?></p>
				</div>				
				<?}?>
				
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer"><?=$taal->msg('footer');?></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt><?=$taal->msg('handige_links'); ?></dt>
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
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" ><?=$taal->msg('afmelden'); ?></a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen"><?=$taal->msg('aanmelden');?></a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>