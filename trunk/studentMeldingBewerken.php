<?
	session_start(); 
	require_once 'classes/exceptions/BadParameterException.class.php';
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Veld.class.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Status.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Taal.class.php';
	
	require_once 'classes/Header.class.php';
	$auth = new Auth(true);
	if (!$auth->getUser()->isStudent()) 
		throw new AccessException();
	$taal = new Taal();
	
	// Input sanitizing
	$formid = $_GET['formid'];
	if (!is_numeric($formid) || $formid < 0)
		throw new BadParameterException();
		
	$formulier = new Herstelformulier($formid);
	if ($formulier->getStudent()->getId() != $auth->getUser()->getId())
		throw new Exception(); // TODO: gepaste exception 
		
	if ($formulier->getStatus()->getValue() != "ongezien")
		throw new Exception(); // TODO: gepaste exception
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
	    <script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/bewerkMelding.js?formid=<?=$_GET['formid'];?>" id="javascriptfile"></script>	    
	</head>
	<body>
		<?new Header(array("#"), array("Melding bewerken")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu(); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div id="success" style="display:none"><?=$taal->msg('succes_melding_bewerkt') ?></div>
				<div id="beforecontent">
				<?
				$user = NULL;
				$currentHome = NULL;
				if ($auth->getUser()->isStudent()) {
					$user = $auth->getUser();
					$currentHome = $user->getHome();
				}
				
				?>
				<form id='meldingform'>
				<table>
						<tr class="tabelheader"><td colspan="4"><? printf($taal->msg('herstelformulier_homenaam'),$currentHome->getKorteNaam()); ?></td></tr>
						<?
							$lijst = Veld::getHomeForm($currentHome);

							for($i=0; $i < sizeof($lijst);$i++){
								$veld = $lijst[$i];
								$nieuweCategorie = $veld->getCategorie();
								$nieuweLocatie = $nieuweCategorie->getLocatie();
								if (!isset($huidigeLocatie) || ($huidigeLocatie->getValue() != $nieuweLocatie->getValue())) {
									$huidigeLocatie = $nieuweLocatie;
									echo("<tr class='subheader' id='locatie_".$huidigeLocatie->getValue()."'><td colspan='4'>".$huidigeLocatie->getValue()."</td></tr>");
								}
								if (!isset($huidigeCategorie) || ($huidigeCategorie->getNaamNL() != $nieuweCategorie->getNaamNL())) {
									$huidigeCategorie = $nieuweCategorie;
									echo("<tr class='subsubheader klik ".$huidigeLocatie->getValue()."' id='cat_".$huidigeCategorie->getId()."' onclick='showGroup(".$huidigeCategorie->getId().");'><td width='12px' id='collapse_".$huidigeCategorie->getId()."'>+</td><td colspan='3'>".$huidigeCategorie->getNaam()."</td></tr>");
									echo("<tr class='legende ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()."' style='display:none'><td></td><td>Defect</td><td>".$taal->msg('naam')."</td><td></td></tr>");
								}
								echo("<tr class='klik ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()."' id='item_".$veld->getId()."' onclick='checkItem(".$veld->getId().");' style='display:none'><td></td><td><input id='check_".$veld->getId()."' type='checkbox' name='".$veld->getId()."' onclick='checkItem(".$veld->getId().");'/></td><td>".$veld->getNaam()."<td></tr>");
							}
						?>
				</table>
				<div><label for="opmerking"><?=$taal->msg('opmerking') ?>:</label><div><textarea name="opmerking" id="opmerking" cols="50" rows="8"></textarea></div></div>
				<div><button name="submit" id="submit" type="submit"><?=$taal->msg('verzenden') ?></button></div>
				</form>
				</div>				
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
		
		<!--login aan de rechterkant-->
		<? if($auth->isLoggedIn()){ ?>
			<div id="login-act">
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" ><?=$taal->msg('afmelden') ?></a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen"><?=$taal->msg('aanmelden') ?></a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>