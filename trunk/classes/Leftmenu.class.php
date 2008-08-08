<?php
require_once 'classes/Home.class.php';
require_once 'Auth.class.php';
class Leftmenu {
	
	private $type;
	private $huidigePagina;
	
	public function __construct($type, $huidigePagina) {
		$a = new Auth(false);
		if(!$a->isLoggedIn()) die();//TODO: eventueel de opsplitsing maken tussen personeel en studenten menu
		$this->huidigePagina = $huidigePagina;
		$this->type = $type;
		echo "<div id='leftnav'>
			<dl id='nav'>
				<dt>Herstelformulier</dt>
				<dd><ul>";
					//beheer
					if($huidigePagina=="personeelAdmin.php")
						echo "<li id='selected'><a href='personeelAdmin.php'>Beheer</a></li>";
					else
						echo "<li><a href='personeelAdmin.php'>Beheer</a></li>";
					if($type == "Beheer"){
						echo("<li class='subnav'><ul>");
						echo(self::generateSubMenuItem("personeelAdminHomes.php","Beheer Homes"));
						echo(self::generateSubMenuItem("personeelAdminBeheerders.php","Beheer Beheerders"));
						$lijst = Home::getHomes();
						foreach($lijst as $home){
							echo(self::generateSubMenuItem("personeelAdmin.php?homeId=".$home->getId(),"Beheer Home ".$home->getKorteNaam()));
						}
						echo("</ul></li>");
					}
					
					//statistieken
					if($huidigePagina=="statistieken.php")
						echo "<li id='selected'><a href='statistieken.php'>Statistieken</a></li>";
					else
						echo "<li><a href='statistieken.php'>Statistieken</a></li>";
					if($type == "statistieken"){
					}
					
				echo "</ul></dd>
			</dl>
			
			<dl class='facet'>
				<dt>Handige links</dt>
				<dd><ul>
					<li><a href='http://helpdesk.ugent.be'>&#187; Helpdesk</a></li>
					<li><a href='http://www.ugent.be/nl/voorzieningen/huisvesting'>&#187; Huisvesting</a></li>
					<li><a href='https://minerva.ugent.be/'>&#187; Minerva</a></li>
				</ul></dd>
			</dl>
		</div>";
	}
	
	public function generateSubMenuItem($url, $titel){
		$return = "<li";
		if($url==$this->huidigePagina) $return .= " id='selected'";
		$return .= "><a href='$url'>$titel</a></li>";
		return $return;
	}
}

?>
