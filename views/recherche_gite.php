<?php
$title = "Mon Gites.com -RESULTAT DE RECHERCHE-";
require "Models/Gites.php";
//Instance de la classe gites
$gite = new Gites();
?>
<h1>Résultat de la recherche</h1>
<?php

$gite->sortGiteByDate();
?>
