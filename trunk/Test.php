<?php
session_start();
//session_destroy();
//print_r($_SESSION);
/*require_once 'classes/Student.class.php';
echo "<pre>";
print_r(new Student(3));
echo "</pre>";
require_once 'classes/LDAP.class.php';
$ldap_conn = new LdapRepair();
print_r($ldap_conn->getUserInfo("bmesuere")); echo "<br/>";
print_r($ldap_conn->getUserInfo("sidooms"));echo "<br/>";
print_r($ldap_conn->getUserInfo("craemdon"));echo "<br/>";
print_r($ldap_conn->getUserInfo("jsollie"));echo "<br/>";
print_r($ldap_conn->getUserInfo("hhallez"));echo "<br/>";
print_r($ldap_conn->getUserInfo("nvictor"));echo "<br/>";
print_r($ldap_conn->getUserInfo("jhuvaere"));echo "<br/>";
print_r($ldap_conn->getUserInfo("epittoor"));echo "<br/><br/>";

$ldap_conn->connect();
		$ldap_conn->bind();
		$ldap_conn->search("uid=cstal");
		print_r($ldap_conn->get_entries());

echo "<br/><br/>";

$ldap_conn->connect();
		$ldap_conn->bind();
		$ldap_conn->search("uid=nvictor");
		print_r($ldap_conn->get_entries());*/
 require_once 'classes/LDAP.class.php';
require_once 'classes/Home.class.php';

//data ophalen
$ldap = new LdapRepair();
$ldap->connect();
$ldap->bind();
$ldap->search("cn=Joni Vandenberghe");
$data = $ldap->get_entries();
echo"<pre>";
print_r($data);
echo"</pre>";
?>