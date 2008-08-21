<? 
	session_start(); 
	require_once 'classes/Config.class.php';	
	require_once 'Herstelformulier.class.php';
	require_once 'Taal.class.php';
	require_once 'Topmenu.class.php';
	require_once 'Header.class.php';
	require_once 'Auth.class.php';
	$auth = new Auth(false);
	$taal = new Taal();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
	<head>
		<base href="http://www.ugent.be/nl/" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title><?=$taal->msg('titel');?></title>
		<link rel="shortcut icon" type="image/x-icon" href="http://www.ugent.be/favicon.ico" />
		<style type="text/css" media="all">
		@import url(reset.css);
		</style>
		<style type="text/css" media="all">
		@import url(screen.css);
		</style>
		<style type="text/css" media="print">
		@import url(print.css);
		</style>
		
		<style type="text/css" media="all">
		@import url(ploneCustom.css);
		</style>
		
		<!-- Internet Explorer 6 CSS Fixes -->
		<!--[if IE 6]>
			        <style type="text/css" media="all">@import url(ie6.css);</style>
			    <![endif]-->
		
		<!-- Internet Explorer 7 CSS Fixes -->
		<!--[if IE 7]>
			        <style type="text/css" media="all">@import url(ie7.css);</style>
			    <![endif]-->
		
		<!-- syndication -->
		
		
		<!-- meta (http-equiv) -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
		
		<meta content="2007-09-14 11:39:49" name="DC.date.created" />
		<meta content="text/plain" name="DC.format" />
		<meta content="admin" name="DC.creator" />
		<meta content="Folder" name="DC.type" />
		<meta content="2007-12-30 07:09:35" name="DC.date.modified" />
		
		<!-- javascript -->
		<!-- Plone ECMAScripts -->
		
		<script type="text/javascript" src="js/ploneScripts9699.js"></script>
		<script type="text/javascript" src="js/ploneScripts1110.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="topbar">
				<div id="language">
					<ul class="swapUnderline">
						<li class="selected">NL</li>
						<li class="last-child"><a href="http://www.ugent.be/en">EN</a></li>
					</ul>
				</div>
				<div id="user">
					<ul class="swapUnderline">
						<li><a class="Logintext" href="<?=$auth->getLoginURL();?>">Aanmelden </a></li>
						<li class="last-child"><a href="http://www.ugent.be/nl/search_form" class="advanced" accesskey="5">Intern zoeken</a></li>
					</ul>
				</div>
			</div>
	
			<div id="header">
				<div id="headerleft">
					<h1><a href="http://www.ugent.be/nl" title="Universiteit Gent"> <img src="http://www.ugent.be/images/universiteit_gent.gif" /> </a></h1>
				</div>
				<div id="headerright">
					<div id="search">
						<form name="searchform" action="http://www.google.nl/cse" id="searchbox_{017123110772135953352:-rmqgoskg1q}">
							<input type="hidden" name="cx" value="017123110772135953352:-rmqgoskg1q" />
							<input type="hidden" name="cof" value="FORID:0" /> <input type="hidden" name="ie" value="utf-8" /> 
							<input type="hidden" name="oe" value="utf-8" />	
							<input type="text" name="q" size="20" id="search-input" /> 
							<input type="submit" name="sa" value="Zoeken" />
						</form>
					</div>
					
					<!-- id="utility" -->
					<div id="utility">
						<ul>
							<li id="telefoonboek" class="last-child"><a	href="http://www.ugent.be/nl/phonebook_form" accesskey="" title="Telefoonboek">Telefoonboek</a> <span>&#124;</span></li>
							<li id="az-index" class="last-child"><a href="http://www.ugent.be/nl/az-index" accesskey="" title="AZ index">AZ	index</a> <!--<span>&#124;</span>--></li>
						</ul>
					</div>
				</div>
			</div>
	
			<div id="breadcrumb" class="swapUnderline"><span>U bent hier:</span> <a	class="br-act" href="http://www.ugent.be/nl">Home</a></div>
	
			<div class="hidden">
				<!-- Skip to navigation  --> 
				<a accesskey="7" href="#pagenavigation">Skip to navigation</a> 
				<!-- Skip to top navigation  -->
				<a href="http://www.ugent.be/nl#portlet-navigation-tree">Skip to navigation</a>
			</div>
	
			<div id="main">
			<!--  <div id="navigation"> -->
				<div class="hidden">
					<h2><a name="pagenavigation" id="pagenavigation">Paginanavigatie</a></h2>
				</div>
				<div id="navigationhome">
					<div id="mainnav">
						<ul>
							<li><a href="http://www.ugent.be/nl/univgent" title="">Over de UGent</a></li>
							<li><a href="http://www.ugent.be/nl/onderwijs" title="">Onderwijs en studie</a></li>
							<li><a href="http://www.ugent.be/nl/onderzoek" title="">Onderzoek</a></li>
							<li><a href="http://www.ugent.be/nl/werken" title="">Werken aan UGent</a></li>
							<li><a href="http://www.ugent.be/nl/voorzieningen" title="">Voorzieningen</a></li>
							<li><a href="http://www.ugent.be/nl/nieuwsagenda" title="">Actueel</a></li>
						</ul>
					</div>
					<dl class="facet">
						<dt><a href="http://www.ugent.be/nl/studenten"> <span>...voor studenten</span></a></dt>
					</dl>
					<dl class="facet">
						<dt><a href="http://www.ugent.be/nl/personeel"> <span>...voor medewerkers</span> </a></dt>
					</dl>
					<dl class="facet">
						<dt><a href="http://www.ugent.be/nl/alumni"> <span>...voor alumni</span></a></dt>
					</dl>
					<dl class="facet">
						<dt><a href="http://www.ugent.be/nl/pers"> <span>...voor journalisten</span></a></dt>
					</dl>
					<dl class="facet">
						<dt><a href="http://www.ugent.be/nl/bedrijven"> <span>...voor bedrijven</span></a></dt>
					</dl>
					
					<div class="visualClear"></div>
					<!-- End left column --> 
					<!-- </div> -->
				</div>
	
				<div id="content" class="small">
					<? if($auth->isLoggedIn()){ //we zijn ingelogd
					if($auth->getUser()->isStudent()){//Student?>
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
							
							<table>
								<tr class="tabelheader"><td colspan="6"><?=$taal->msg('overzicht_herstellingen') ?></td></tr>
								<?
									$lijst = Herstelformulier::getLatest($auth->getUser()->getId());
									for($i=0; $i < sizeof($lijst);$i++){
										$form = $lijst[$i];
										$nieuweStatus = $form->getStatus();
										if (!isset($huidigeStatus) || ($nieuweStatus->getValue() != $huidigeStatus->getValue())) {
											if (isset($huidigeStatus)) echo("</tbody>");
											$huidigeStatus = $nieuweStatus;
											echo("<tr class='subheader klik' onclick=\"showGroup('".$huidigeStatus->getValue()."');\"><td width='12px' id='collapse_".$huidigeStatus->getValue()."'>-</td><td colspan='5'>");
											echo($huidigeStatus->getUitleg());
											echo ("</td></tr>");
											echo("<tr class='legende ".$huidigeStatus->getValue()."'><td></td><td>".$taal->msg('datum')."</td><td colspan='3'>".$taal->msg('inhoud')."</td></tr>");
										}
										echo("<tr class='".$huidigeStatus->getValue()."' id='row_".$form->getId()."'><td></td><td>");
										$timestamp = strtotime($form->getDatum());
										$parsedDate = date("d-m-Y @ H:i",$timestamp);
										echo($parsedDate);
										echo("</td><td>".$form->getSamenvatting()."</td>");
										if ($form->getStatus()->getChangeable())
											echo("<td class='img'><a href='studentMeldingBewerken.php?formid=".$form->getId()."'><img alt='bewerken' class='bewerk' title='Dit herstelformulier bewerken' src='images/page_edit.gif'/></a></td><td class='img'><img class='klik verwijder' alt='verwijderen' title='Dit herstelformulier verwijderen' src='images/page_delete.gif' onclick=\"verwijder('".$form->getId()."');\"/></td>");
										else
											echo("<td colspan='4'></td>");
										echo("</tr>");
									}
									echo("</tbody>");
								 ?>
							</table>
							
						</div>
					<?}
					else{//personeel?>
						<h1>Welkom <?=$auth->getUser()->getVoornaam() ?></h1>
						<table>
							<tr class="tabelheader"><td colspan="6">Overzicht van herstellingen die niet afgewerkt zijn</td></tr>
							<?
							$lijst = Herstelformulier::getList(0, new Status("ongezien"));
							$size = sizeof($lijst);
							if ($size > 0) {
							?>
							<tr class="subheader"><td colspan="5">Ongeziene herstellingen</td></tr>
							<tbody>
								<tr class="legende">
									<td></td>
									<td>Datum</td>
									<td>Inhoud</td>
									<td></td>
									<td></td>
								</tr>
							<?
								for($i=0; $i < $size;$i++){
									$form = $lijst[$i];
									echo("<tr id='row_".$form->getId()."'><td></td><td>");
									$timestamp = strtotime($form->getDatum());
									$parsedDate = date("d-m-Y @ H:i",$timestamp);
									echo($parsedDate);
									echo("</td><td>".$form->getSamenvatting()."</td>");
									echo("<td class='img'><a href='personeelMeldingDoorgeven.php?formid=".$form->getId()."'><img alt='Doorgeven Herstelformulier' class='bewerk' title='Dit herstelformulier doorgeven' src='images/page_edit.gif'/></a></td>");
									echo("<td></td>");
									echo("</tr>");
								}
							 ?>
							</tbody>
							<?
							}
							
							$lijst = Herstelformulier::getList(0, new Status("gedaan"));
							$size = sizeof($lijst);
							if ($size > 0) {
	 						?>
							<tr class="subheader"><td colspan="5">Doorgegeven herstellingen die nog niet afgesloten zijn</td></tr>
							<tbody>
								<tr class="legende"><td></td><td>Datum</td><td>Inhoud</td><td></td><td></td></tr>
								<?
								for($i=0; $i < $size; $i++){
									$form = $lijst[$i];
									echo("<tr id='row_".$form->getId()."'><td></td><td>");
									$timestamp = strtotime($form->getDatum());
									$parsedDate = date("d-m-Y @ H:i",$timestamp);
									echo($parsedDate);
									echo("</td><td>".$form->getSamenvatting()."</td>");
									echo("<td></td>");
									echo("<td class='img'><a href='personeelMeldingInformatie.php?formid=".$form->getId()."'><img alt='Meer Informatie' title='Meer informatie over dit herstelformulier' src='images/externesite.gif'/></a></td>");
									echo("</tr>");
								}
							 ?>
							</tbody>
							<? } ?>
						</table>
					<?}
						} 
						else{ //niet ingelogd?>
							<div>
								<h1><?=$taal->msg('welkom');?></h1>
								<p><?=$taal->msg('welkom_niet_aangemeld');?></p>
							</div>				
						<?}?>
       			</div>
				
				<div id="sidebar">
					&nbsp;
				</div>  
			</div>
	
			<!-- topanchor -->
			<div id="topanchor">
				<a name="top" id="top">&nbsp;</a>
			</div>
	
			<!-- <div metal:use-macro="here/analyze_macros/macros/google_analytics">
	             Google analytics code
	        </div> -->
		</div>
	
		<div class="visualClear"></div>
	
		<div id="footer-wrap">
			<div id="footer">
				<ul id="copyright" class="swapUnderline">
					<li><span class="byline_author">Reacties op de inhoud</span>: <a class="byline_author" href="mailto:portaal@ugent.be?SUBJECT=PORTAAL%20http://www.ugent.be/nl">portaal@ugent.be</a></li>
					<li><?=$taal->msg('footer');?></li>
				</ul>
				<ul class="swapUnderline" id="meta">
					<div>
						<li><a href="http://www.ugent.be/nl/voorzieningen/ict/portaal">Over deze site</a></li>	
						<li><a href="http://www.ugent.be/nl/phonebook_form">Telefoonboek</a></li>
						<li><a href="http://www.ugent.be/nl/az-index">AZ index</a></li>
						<li><a href="http://www.ugent.be/nl/disclaimer">Disclaimer</a></li>
					</div>
				</ul>
			</div>
		</div>
	</body>
</html>