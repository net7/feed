<?php

// feed.thepund.it/?b=http://bur.local/api.php/tc/2
// Testato con: http://it.wikisource.org/wiki/Tre_luigini_inediti_di_Campi

try {
$s=new FusepoolScraper($_GET['fp']);
}
 catch (Exception $e) {
     echo $e->getMessage();
     die();
 }
 
 echo $s->getPunditContent();
 
?>
