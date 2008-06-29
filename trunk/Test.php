<?php
/**
 * Opvragen van een Herstelformulierenlijst voor gebruiker met userId 1
 */
require_once 'classes/HerstelformulierList.class.php';
$lijstje = HerstelformulierList::getList(1);

print_r($lijstje);

echo "<br/><br/>";

/**
 * Opvragen van een herstelformulierenlijst voor gebruiker met userId 1 en status Ongezien
 */
$lijstje = HerstelformulierList::getList(1, new Status("gezien"));
print_r($lijstje);
?>