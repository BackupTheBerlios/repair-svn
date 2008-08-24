<?
//TODO: de 2 klassen hierboven mergen
require_once 'classes/Home.class.php';
require_once 'Auth.class.php';
require_once 'Taal.class.php';

class Menu{
	private $categorie;
	private $huidigePagina;
	public function __construct($categorie, $huidigePagina) {
		$this->huidigePagina = $huidigePagina;
		$this->categorie = $categorie;
		try{
			$a = new Auth(false);
			$taal = new Taal();
			echo("<div id='navigationhome'><div id='mainnav'><ul>");
			if($a->isLoggedIn()){//zijn we ingelogd?
				if($a->getUser()->isPersoneel()){//zijn we personeel?
						echo self::generateItem("personeelAdmin.php", "Beheer", true);
						if($categorie == "Beheer"){//submenu beheer
							echo"<ul>";
							echo(self::generateItem("personeelAdminHomes.php","Beheer Homes"));
							echo(self::generateItem("personeelAdminBeheerders.php","Beheer Beheerders"));
							$lijst = $a->getUser()->getHomesLijst();
							foreach($lijst as $home){
								echo(self::generateItem("personeelAdmin.php?homeId=".$home->getId(),"Beheer Home ".$home->getKorteNaam()));
							}
							echo"</ul></li>";
						}
						echo self::generateItem("#", "Statistieken");
						echo self::generateItem("personeelOverzicht.php", "Overzicht");
					}
					else{//we zijn student
						echo self::generateItem("index.php", $taal->msg('Index'));
						echo self::generateItem("studentOverzicht.php", $taal->msg('Overzicht'));
						echo self::generateItem("studentMeldingToevoegen.php", $taal->msg('defect_melden'));
					}
			}
			else{//we zijn niet ingelogd
				echo self::generateItem(Auth::getLoginURL(), $taal->msg('aanmelden'));
				echo self::generateItem("studentMeldingToevoegen.php", $taal->msg('defect_melden'));
			}
			echo("</ul></div><div class='visualClear'></div></div>");
		}
		catch (Exception $e){
			//doe niets, anders krijgen we een error lus (Error.php genereert ook een menu...)
		}
	}
	
	public function generateItem($url, $naam, $open=false){
		$active = $url == $this->huidigePagina ? "active" : "";
		$open = ($naam == $this->categorie) && $open ? "open" : "";
		$sluitTag = !$open ? "</li>" : "";
		return "<li class='$active $open'><a href='$url'>$naam</a>$sluitTag";
	}
}
?>