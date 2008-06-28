<a href="pages/help.php">klik</a><br/>
<?
require_once 'classes/Student.class.php';
$o = new Student("", "alfred", "2008-06-26 19:46:23", "emailadres@gmail.com", "en", 2, "91.02.130.232", "14987");
echo $o->getEmail()."<br/>";
echo $o->getHome()->getKorteNaam();
?>