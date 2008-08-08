<?php
require_once 'Taal.class.php';
class Header{
	public function __construct($urls=array(), $namen=array()){
		$taal = new Taal();
		echo("<div id='logo'><img src='images/logo.gif' width='200' height='60' alt='Logo Universiteit Gent' usemap='#linklogo' /><map name='linklogo' id='linklogo'><area shape='rect' coords='60,0,142,60' href='http://www.ugent.be' alt='Startpagina Universiteit Gent' /></map></div>");
		echo("<div id='siteid'><img src='images/siteid-portal.jpg' width='300' height='80' alt='Portaalsite Universiteit Gent' /><a href='index.php' class='text' >".$taal->msg('titel')."</a></div>");
		echo("<div id='utility'><a href='veranderTaal.php?vorige=".$_SERVER['PHP_SELF']."'>".$taal->msg('andere_taal')."</a> | <a href='#'>Contact</a> | <a href='#' onclick='window.print()'>Print</a></div>");
		echo("<div id='breadcrumb'> <a href='index.php'>".$taal->msg('dringende_herstellingen')."</a>");
		foreach($urls as $key =>$url)
			echo(" &gt; <a href='$url'>".$namen[$key]."</a>");
		echo("</div>");
	}
}
?>