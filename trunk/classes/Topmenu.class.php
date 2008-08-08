<?php
require_once 'Auth.class.php';
class Topmenu {
	private $type;
	public function __construct($type="") {
		$this->type = $type;
		$a = new Auth(false);
		echo("<div id='mainnav'><ul>");
		if(!$a->isLoggedIn()){//we zijn niet ingelogd
			echo self::generateMenuItem(Auth::getLoginURL(), "login", "Inloggen", 1);
		}
		else{
			if($a->getUser()->isPersoneel()){//we zijn personeel
				echo self::generateMenuItem("personeelAdmin.php", "beheer", "Beheer", 1);
				echo self::generateMenuItem("#", "statistieken", "Statistieken");
			}
			else{//we zijn student
				echo self::generateMenuItem("overzicht.php", "overzicht", "Overzicht", 1);
				echo self::generateMenuItem("studentMeldingToevoegen.php", "melding", "Defect melden");
			}
		}
		echo("</ul></div>");
	}
	
	public function generateMenuItem($url, $type, $name, $first=0){
		$f = $first==1 ? "class='first'" : "";
		$a = $type==$this->type ? "id='selected'" : "";
		return "<li $f $a><a href='$url'>$name</a></li>";
	}
}

?>
