<?php
session_start();
require_once 'classes/Auth.class.php';
$auth = new Auth(false);
$auth->logOut();
?>