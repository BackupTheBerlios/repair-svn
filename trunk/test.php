<?php
require_once 'classes/LDAP.class.php';
$l = new LdapRepair();
echo"<pre>";
print_r($l->getUserInfo2("bmesuere"));
echo"</pre>";
?>