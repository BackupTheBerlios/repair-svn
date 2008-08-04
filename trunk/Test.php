<?php
require_once 'classes/LDAP.class.php';
$ldap_conn = new LdapRepair();
$ldap_conn->connect();
$ldap_conn->bind();

$ldap_conn->search("uid=bmesuere");

print_r($ldap_conn->get_entries());

?>