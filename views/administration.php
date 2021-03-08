<?php
//si session connecter retourne la page d'accueil
$title = "Mon Gite.com -ADMINISTRATION-";
require "Models/Gites.php";
//Instance de la classe gites
$gite = new Gites();
?>
 <h1 class="text-center text-success">ADMINISTRATION</h1>
        <div class="text-center">
            <a href="index.php?url=ajouter_gites" class="btn btn-info">Ajouter un gite</a>
        </div>
<?php
//Appel de la methode pour lister tous les gites
$gite->getAllGiteAdmin();
?>



