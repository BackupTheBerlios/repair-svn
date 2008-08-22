<?php
require_once 'Taal.class.php';
require_once 'Auth.class.php';
class Header{
	public function __construct(){
		$taal = new Taal();
		$auth = new Auth(false);
		/*echo("<div id='logo'><img src='images/logo.gif' width='200' height='60' alt='Logo Universiteit Gent' usemap='#linklogo' /><map name='linklogo' id='linklogo'><area shape='rect' coords='60,0,142,60' href='http://www.ugent.be' alt='Startpagina Universiteit Gent' /></map></div>");
		echo("<div id='siteid'><img src='images/siteid-portal.jpg' width='300' height='80' alt='Portaalsite Universiteit Gent' /><a href='index.php' class='text' >".$taal->msg('titel')."</a></div>");
		echo("<div id='utility'><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."'>".$taal->msg('andere_taal')."</a> | <a href='#'>Contact</a> | <a href='#' onclick='window.print()'>Print</a></div>");
		echo("<div id='breadcrumb'> <a href='index.php'>".$taal->msg('dringende_herstellingen')."</a>");
		foreach($urls as $key =>$url)
			echo(" &gt; <a href='$url'>".$namen[$key]."</a>");
		echo("</div>");*/
		echo("<div id='topbar'> <div id='language'><ul class='swapUnderline'>");
		if($taal->getTaal()=="nl"){
			echo("<li class='selected'> NL</li>");
			echo("<li class='last-child'><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."'>EN</a></li>");
		}
		else{
			echo("<li><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."'>NL</a></li>");
			echo("<li class='selected last-child'> EN</li>");
		}
		echo("</ul></div><div id='user'><ul class='swapUnderline'>");
		if(!$auth->isLoggedIn())
			echo("<li class='last-child'><a class='Logintext advanced' href='".Auth::getLoginURL()."'> ".$taal->msg('aanmelden')."</a></li>");
		else
			echo("<li class='last-child member'>".$auth->getUser()->getGebruikersnaam()."&nbsp;-&nbsp;<a class='Logintext' href='logout.php'' title='uitloggen'' >".$taal->msg('afmelden')."</a></li>");
		echo("</ul> 
			</div> 
		</div> ");
		echo("<div id='header'> 
			<div id='headerleft'> 
				<h1> <a href='http://www.ugent.be/nl' title='Universiteit Gent'><img src='http://www.ugent.be/images/universiteit_gent.gif' /> </a> </h1> 
			</div> 
			<div id='headerright'> </div> 
		</div> ");
		echo("<div id='breadcrumb' class='swapUnderline'>
			<span>".$taal->msg('u_bent_hier')."</span>
			<a class='br-act' href='#'>Home</a> 
		</div> ");
		
	}
}
?>

            
