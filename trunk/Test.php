<?php
$kamer = $_GET['kamer'];
$basis = "12565";
$v = substr($kamer, 0, -2);
$tel = $basis + $v*55;
$v = substr($kamer, -2);
$tel += $v;
echo $tel;
?>