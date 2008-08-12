<?php
require_once 'classes/Config.class.php';
require_once 'Herstelformulier.class.php';
require_once 'Status.class.php';
require_once 'Mailer.class.php';

// overloop alle herstelformulieren die voldoen aan evaluatiecriteria
$list = Herstelformulier::getEvaluationList();
// mail user
foreach ($list as $formulier) {
	echo $formulier->getId()."<br/>";
}

// doorzenden naar Homemanager als er nieuwe herstelformulieren zijn
$list = Herstelformulier::getList(0, new Status("ongezien"));
if (sizeof($list) == 0) {
	echo sizeof($list)." ongeziene herstelformulieren.";
}

$mailer = new Mailer();
$mailer->setFrom("bert.vandeghinste@gmail.com");
$mailer->setSubject("cron test");
$mailer->setPriority("high");
$mailer->setText("testje!");
$return = $mailer->send(array("bert.vandeghinste@gmail.com"));

echo $return;        

?>