<?php
require_once 'classes/LDAP.class.php';
$velden[]="uid";
$waarden[]="nvotten";
$filter = "";
		foreach ($waarden as $key =>$value){
			if($value!="")
				if(strlen($filter)==0)
					$filter = "(".$velden[$key]."=*".$value."*)";
				else
					$filter = "(&".$filter."(".$velden[$key]."=*".$value."*))";
		}
	$lijst = array();
	$ld = new LdapRepair();
	$ld->connect();
	$ld->bind();
	$ld->search($filter);
	$result = $ld->get_entries();
	echo"<pre>";
	print_r($result);
	echo"</pre>";
?>