<?php
require_once 'classes/Student.class.php';
$q = new Student(2);

echo $q->is_valid_email_address("test@test.com");

echo "<br/><br/>";
/*
 * testje
 */
require_once 'classes/VeldList.php';
print_r(VeldList::getHomeForm(1));
?>