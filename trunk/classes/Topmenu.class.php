<?php
require_once 'Auth.class.php';
class Topmenu {
	private $type;
	public function __construct($type="") {
		$this->type = $type;
		try {
			$a = new Auth(false);
			echo("<div id='mainnav'><ul>");
			if(!$a->isLoggedIn()){//we zijn niet ingelogd
				echo self::generateMenuItem(Auth::getLoginURL(), "login", "Inloggen", 1);
				echo self::generateMenuItem("studentMeldingToevoegen.php", "melding", "Defect melden");
			}
			else{
				if($a->getUser()->isPersoneel()){//we zijn personeel
					echo self::generateMenuItem("personeelAdmin.php", "beheer", "Beheer", 1);
					echo self::generateMenuItem("#", "statistieken", "Statistieken");
					echo self::generateMenuItem("personeelOverzicht.php", "overzicht", "Overzicht");
				}
				else{//we zijn student
					echo self::generateMenuItem("overzicht.php", "overzicht", "Overzicht", 1);
					echo self::generateMenuItem("studentMeldingToevoegen.php", "melding", "Defect melden");
				}
			}
			echo("</ul></div>");
		}
		catch (Exception $e) {
			//echo $e;
		}
		
	}
	
	public function generateMenuItem($url, $type, $name, $first=0){
		$f = $first==1 ? "class='first'" : "";
		$a = $type==$this->type ? "id='selected'" : "";
		return "<li $f $a><a href='$url'>$name</a></li>";
	}
}

?>
