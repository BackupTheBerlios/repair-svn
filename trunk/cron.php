<?php
require_once 'classes/Config.class.php';
require_once 'Herstelformulier.class.php';

// overloop alle herstelformulieren die voldoen aan evaluatiecriteria
$list = Herstelformulier::getEvaluationList();
// mail user
foreach ($list as $formulier) {
	echo $formulier->getId()."<br/>";
}
?>