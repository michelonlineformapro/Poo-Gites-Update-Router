<?php
$title = "Mon Gites.com -Détails du Gite-";
//Appel du fichier model
require "Models/Gites.php";
//Instance de la classe gite
$gites = new Gites();

?>
    <h1 class="alert-success p-5 text-center text-dark mt-3">Votre réservation doit être validée !</h1>
    <h2 class="text-center text-danger"><b>Récapitulatif de votre réservation :</b></h2>
    <form method="post">
        <div class="text-center">
            <button name="disableGite" href="accueil" class="btn btn-info">Retour à la page d'acueil</button>
        </div>
    </form>

<?php
$id_gite = $_GET['id'];
$gites->recapGiteById($id_gite);

//Desactivé le gite
if(isset($_POST['disableGite'])){
    $gites->disabledGite();
}else{
    echo "<p class='alert-warning p-2'>Votre demande est validée vous disposé d'un droit de retractation de 15 jours</p>";
    echo "<a class='btn btn-success' href='#'>Condition générale de ventes (CGV)</a>";
}

?>
