<?php
require_once 'classes/Config.class.php';
require_once 'Herstelformulier.class.php';
require_once 'Status.class.php';
require_once 'Mailer.class.php';
require_once 'Student.class.php';
require_once 'Personeel.class.php';
require_once 'Home.class.php';

$from = "Online Herstelformulier <huisvesting@UGent.be>";

$email_student_subject_nl = "[Online herstelformulier] Controle herstelling";
$email_student_body_nl = "Beste,\n\nE�n van uw herstellingen werd een eindje geleden doorgegeven aan de hersteldienst. Graag hadden wij van u gehoord of deze herstelling uitgevoerd is en of u nog opmerkingen heeft. Met deze informatie kunnen we onze diensten verbeteren. Gelieve daarom in te loggen op https://herstelformulier.ugent.be en ze zo te evalueren.\n\nDank bij voorbaat,\nAfdeling Huisvesting.";
$email_student_subject_en = "[Online Repairform] Repair check";
$email_student_body_en = "Dear,\n\nWe notified the repairteam of the defects you reported and we still need to hear from you if the repairs were successfull. We can use this information to improve our service. Can you please login onto https://herstelformulier.ugent.be and evaluate them that way.\n\nThanks in advance,\nHousing Department.";

// overloop alle herstelformulieren die voldoen aan evaluatiecriteria
$list = Herstelformulier::getEvaluationList();
// mail user
foreach ($list as $formulier) {
	$student = $formulier->getStudent();
	$ldap = new LdapRepair();
	$userinfo = $ldap->getUserInfo($student->getGebruikersnaam());
	if (isset($userinfo['homeId'])) { // deze student zit hier nog 
		$mailer = new Mailer();
		$mailer->setCc("bert.vandeghinste+herstel@gmail.com,mesuerebart+herstel@gmail.com");
		$mailer->setHTMLCharset("UTF-8");
		$mailer->setFrom($from);
		$email_student_subject = ($student->getTaal() == "nl")?$email_student_subject_nl:$email_student_subject_en;
		$email_student_body = ($student->getTaal() == "nl")?$email_student_body_nl:$email_student_body_en;
		
		$mailer->setSubject($email_student_subject);
		$mailer->setText($email_student_body);
		//$mailer->send(array($student->getEmail()));
	}
}

// doorzenden naar Homemanager als er nieuwe herstelformulieren zijn
/*$list = Herstelformulier::getList(0, new Status("ongezien"));
$count = array();
foreach ($list as $formulier) {
	$count[$formulier->getHome()->getId()] = $count[$formulier->getHome()->getId()] + 1;
}

$beheerders = Personeel::getBeheerders();
foreach ($beheerders as $personeel) {
	$mailer = new Mailer();
	$mailer->setHTMLCharset("UTF-8");
	$mailer->setFrom($from);

	$homes = $personeel->getHomesLijst();
	foreach ($homes as $home) {
		$id = $home->getId();
		if (isset($count[$id]) && ($count[$id] > 0)) {
			// $personeel is homemanager van een home die een mail moet krijgen over $count[$id] ongeziene formulieren
			$mailer->setSubject("[Herstelformulieren] ".$count[$id]." ongezien");
			$mailer->setText("Beste,\n\nEr zijn sinds gisteren ".$count[$id]." herstelformulieren bijgekomen uit ".$home->getLangeNaam()." die nog bekeken moeten worden. Gelieve hiervoor in te loggen op https://chaos.ugent.be/test_herstelformulier/repair/index.php .");
			//$mailer->send(array($personeel->getEmail()));
		}			
	}
}*/
?>