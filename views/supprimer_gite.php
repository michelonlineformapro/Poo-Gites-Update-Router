<?php
//si session connecter retourne la page d'accueil
$title = "Mon Gite.com - SUPPRIMER -";
require "Models/Gites.php";
//Instance de la classe gites
$gite = new Gites();

?>
<h1 class="alert-danger mt-3 p-4 text-center text-warning">ATTENTION VOUS ETES SUR LE POINT DE SUPPRIMER LE GITE : </h1>
<?php
$id_gite = $_GET['id'];
$gite->giteToDelete($id_gite);
?>
<form action="" method="post">
    <button type="submit" name="confirm_delete_gite" class="btn btn-danger mt-3">CONFIMER LA SUPRESSION DU GITE ?</button>
</form>

<?php

if(isset($_POST['confirm_delete_gite'])) {
    $gite->deleteGite();

}
