<?php
require_once 'Taal.class.php';
require_once 'Auth.class.php';
class Header{
	public function __construct(){
		$taal = new Taal();
		$auth = new Auth(false);
		echo("<div id='topbar'> <div id='language'><ul class='swapUnderline'>");
		if (!$auth->isLoggedIn() || ($auth->isLoggedIn() && !$auth->getUser()->isPersoneel())) {
			if($taal->getTaal()=="nl"){
				echo("<li class='selected'> NL</li>");
				echo("<li class='last-child'><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."'>EN</a></li>");
			}
			else{
				echo("<li><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."'>NL</a></li>");
				echo("<li class='selected last-child'> EN</li>");
			}
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
				<h1> <a href='http://www.ugent.be/nl' title='Universiteit Gent'><img src='images/universiteit_gent.gif' alt='Universiteit Gent'/> </a> </h1> 
				<h2> <a href='index.php'>Online Herstelformulier</a></h2>
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