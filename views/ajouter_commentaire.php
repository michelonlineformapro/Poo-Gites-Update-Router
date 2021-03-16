
<?php
$title = "Mon Gites.com - AJOUTER Commentaire -";
//Appel du fichier model
require "Models/Gites.php";
//Instance de la classe gite
$gites = new Gites();


if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){

    ?>
    <h4 class="text-danger mt-1"><b>Bonjour  :</b> <?= $_SESSION['email_user'] ?></h4>
    <?php
        $email = $_SESSION['email_user'];
        $id = $_GET['id'];
    ?>
    <div class="main-container mt-3">
        <h1 class="text-info text-center">Ajouter un commentaire</h1>
        <form method="post">

            <div class="form-group">
                <input type="text" value="<?php $email ?>"  name="auteur_commentaire" placeholder="<?= $_SESSION['email_user'] ?>">
                <?php
                $_POST['auteur_commentaire'] = $email;
                var_dump($email);
                ?>
            </div>

            <div class="form-group">
                <label for="contenus_commentaire">Votre commentaire : </label>
                <textarea class="form-control" id="contenus_commentaire" name="contenus_commentaire" rows="5"></textarea>
            </div>

            <div class="form-group">
                <input type="text" value="<?= $id ?>"  name="gites_id">
            </div>

            <button type="submit" name="btn-add-comment" class="btn btn-outline-success">Ajouter un commentaire</button>
        </form>
    </div>

    <?php

    if(isset($_POST['btn-add-comment'])){
        $gites->addCommentToGite();
    }else{
        echo "<p class='alert-warning p-2'>Merci remplir tous les champs !</p>";
    }

}else{
    echo "<p class='alert-danger p-2'>Merci de vous connectez pour posyé un commentaire</p>";
}

?>



<?php


//$gites->addGite();

/*
var_dump($_POST['nom_gite']);
var_dump($_POST['description_gite']);
var_dump($_POST['img_gite']);
var_dump($_POST['nbr_chambre']);
var_dump($_POST['nbr_sdb']);
var_dump($_POST['zone_geo']);
var_dump($_POST['prix']);
var_dump($_POST['disponible']);
var_dump($_POST['date_arrivee']);
var_dump($_POST['date_depart']);
var_dump($_POST['type_gite']);
var_dump($_FILES);
*/

?>
