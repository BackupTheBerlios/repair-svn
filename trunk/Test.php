<?php
require_once 'classes/Taal.class.php';
$taal = new Taal("EN");
echo $taal->msg('titel');
?>