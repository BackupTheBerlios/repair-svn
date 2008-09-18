<?
require_once 'classes/Home.class.php';
require_once 'Auth.class.php';
require_once 'Taal.class.php';

class Menu{
	private $categorie;
	private $huidigePagina;
	public function __construct($categorie) {
		$this->huidigePagina = basename($_SERVER['REQUEST_URI']);
		$this->categorie = $categorie;
		try{
			$a = new Auth(false);
			$taal = new Taal();
			echo("<div id='navigationhome'><div id='mainnav'><ul>");
			echo self::generateItem("index.php", $taal->msg('Index'));
			if($a->isLoggedIn()){//zijn we ingelogd?
				if($a->getUser()->isPersoneel()){//zijn we personeel?
						echo self::generateItem("personeelMeldingToevoegen.php", "Defect Melden");
						echo self::generateItem("personeelAdmin.php", "Beheer", true, true);
						if($categorie == "Beheer"){//submenu beheer
							echo"<ul>";
							echo(self::generateItem("personeelAdminHomes.php","Beheer Homes"));
							echo(self::generateItem("personeelAdminBeheerders.php","Beheer Beheerders"));
							echo(self::generateItem("personeelAdminCategorie.php","Beheer Categorieën"));
							$lijst = $a->getUser()->getHomesLijst();
							foreach($lijst as $home){
								echo(self::generateItem("personeelAdmin.php?homeId=".$home->getId(),"Home ".$home->getKorteNaam(), false, true));
							}
							echo"</ul></li>";
						}
						echo self::generateItem("personeelStatistiek.php", "Statistieken");
						echo self::generateItem("personeelOverzicht.php", "Overzicht", true);
						if($categorie == "Overzicht"){//submenu beheer
							echo"<ul>";
							echo(self::generateItem("personeelMeldingInformatie.php","Formulier"));
							echo"</ul></li>";
						}
					}
					else{//we zijn student
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
	
	public function generateItem($url, $naam, $open=false, $parameters=false){
		if($parameters)
			$u = $this->huidigePagina;
		else{
			$u = explode("?", $this->huidigePagina);
			$u=$u[0];
		}
		$active = $url == $u ? "active" : "";
		$open = ($naam == $this->categorie) && $open ? "open" : "";
		$sluitTag = !$open ? "</li>" : "";
		return "<li class='$active $open'><a href='$url'>$naam</a>$sluitTag";
	}
}
?>