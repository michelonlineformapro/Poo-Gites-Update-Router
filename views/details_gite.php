<?php
$title = "Mon Gites.com -Détails du Gite-";
//Appel du fichier model
require "Models/Gites.php";
//Instance de la classe gite
$gites = new Gites();

?>
<h1 class="text-center text-danger"><b>DÉTAILS DU GITE</b></h1>
<?php
$id_gite = $_GET['id'];
$gites->getGiteById($id_gite);


?>

