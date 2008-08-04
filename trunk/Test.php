<?php
require_once 'classes/LDAP.class.php';
$ldap_conn = new LdapRepair();
print_r($ldap_conn->getUserInfo("rdumont"));

?>