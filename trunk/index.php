<a href="pages/help.php">klik</a>
<?
$s = "test";
echo $s;
require_once 'classes/Student.class.php';
$o = new Student(1);
echo $o->getGebruikersnaam();
?>