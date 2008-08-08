<?
	session_start(); 
	require_once 'classes/exceptions/AccessException.php';
	require_once 'classes/Veld.class.php';
	require_once 'classes/Herstelformulier.class.php';
	require_once 'classes/Status.class.php';
	require_once 'classes/Auth.class.php';
	require_once 'classes/Topmenu.class.php';
	require_once 'classes/Header.class.php';
	require_once 'classes/Taal.class.php';
	$auth = new Auth(true);
	if (!$auth->getUser()->isStudent()) 
		throw new AccessException();
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Online Herstelformulier</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/nieuweMelding.js"></script>	    
	</head>
	<body>
		<?new Header(array("#"), array("Defect melden")); ?>
		
		<!--main content-->
		<div id="container">
		
			<!--horizontale navigatiebalk bovenaan-->
			<?new Topmenu("melding"); ?>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				<div id="success" style="display:none"><?=$taal->msg('succes_melding_toegevoegd')?></div>
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
						<tr class="tabelheader"><td colspan="4">Herstelformulier <?=$currentHome->getKorteNaam(); ?></td></tr>
						<?
							$lijst = Veld::getHomeForm($currentHome);

							for($i=0; $i < sizeof($lijst);$i++){
								$veld = $lijst[$i];
								$nieuweCategorie = $veld->getCategorie();
								$nieuweLocatie = $nieuweCategorie->getLocatie();
								if (!isset($huidigeLocatie) || ($huidigeLocatie->getValue() != $nieuweLocatie->getValue())) {
									//if (isset($huidigeLocatie)) echo("</tbody>");
									$huidigeLocatie = $nieuweLocatie;
									//echo("<tr class='subheader klik' id='locatie_".$huidigeLocatie->getValue()."' onclick=\"showLocatie('".$huidigeLocatie->getValue()."');\"><td width='12px' id='collapse_".$huidigeLocatie->getValue()."'>+</td><td colspan='3'>".$huidigeLocatie->getValue()."</td></tr>");
									echo("<tr class='subheader' id='locatie_".$huidigeLocatie->getValue()."'><td colspan='4'>".$huidigeLocatie->getValue()."</td></tr>");
								}
								if (!isset($huidigeCategorie) || ($huidigeCategorie->getNaamNL() != $nieuweCategorie->getNaamNL())) {
									//if (isset($huidigeCategorie)) echo("</tbody>");
									$huidigeCategorie = $nieuweCategorie;
									echo("<tr class='subsubheader klik ".$huidigeLocatie->getValue()."' id='cat_".$huidigeCategorie->getId()."' onclick='showGroup(".$huidigeCategorie->getId().");'><td width='12px' id='collapse_".$huidigeCategorie->getId()."'>+</td><td colspan='3'>".$huidigeCategorie->getNaamNL()."/".$huidigeCategorie->getNaamEN()."</td></tr>");
									//echo("<tbody id='group_cat_".$huidigeCategorie->getId()."' style='display:none'>");
									echo("<tr class='legende ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()."' style='display:none'><td></td><td>Defect</td><td>Naam Nederlands</td><td>Naam Engels</td></tr>");
								}
								echo("<tr class='klik ".$huidigeLocatie->getValue()." ".$huidigeCategorie->getId()."' id='item_".$veld->getId()."' onclick='checkItem(".$veld->getId().");' style='display:none'><td></td><td><input id='check_".$veld->getId()."' type='checkbox' name='".$veld->getId()."' onclick='checkItem(".$veld->getId().");'/></td><td>".$veld->getnaamNL()."</td><td>".$veld->getnaamEN()."</td></tr>");
							}
						?>
				</table>
				<div><label for="opmerking">Opmerking:</label><div><textarea name="opmerking" id="opmerking" cols="50" rows="8"></textarea></div></div>
				<div><button name="submit" id="submit" type="submit">Submit</button></div>
				</form>
				</div>				
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste in opdracht van de <a href="http://www.ugent.be/nl/voorzieningen/huisvesting">Afdeling Huisvesting</a></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
					
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt>Handige links</dt>
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
			 <?=$auth->getUser()->getGebruikersnaam() ?>&nbsp;-&nbsp;<a href="logout.php" title="uitloggen" >afmelden</a>
		 	</div>
		<? } else{ ?>
			<div id="login">
				<a href="<?=$auth->getLoginURL() ?>" title="inloggen">aanmelden</a>
		 	</div>
		<?} ?>
		 
		 
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>