<?php
require_once 'classes/LDAP.class.php';
$ldap_conn = new LdapRepair();
print_r($ldap_conn);
$ldap_conn->connect();
$ldap_conn->bind();

$ldap_conn->search(null, "uid=bmesuere");

print_r($ldap_conn->get_entries());

?>