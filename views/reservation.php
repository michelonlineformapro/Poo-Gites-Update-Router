<?php
$title = "GITE.COM -ACCUEIL-";

require  "Models/Reservation.php";
//Instance de la classe gites
//Instance de la classe resevation alias phpMailer config avec mailTrap
$emailValidation = new Reservation();

//Verifié la connexion de l'utilisateur

if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
    if(isset($_POST['validReservation'])){
        $emailValidation->reserverGite();
        echo "<h3 class='alert-success p-3 mt-3 text-danger'>Un email viens de vous etre envoyé, merci de verifié votre boite mail pour confirmer votre resevation</h3>";
    }else{
        echo "<p class='alert-warning p-3 mt-2'>Merci de remplir le formulaire avec votre email</p>";
    }

    ?>
    <div class="main-container">
        <h1 class="text-center text-info">RÉSERVATION</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="email_user">Merci d'entrer votre email</label>
                <input type="email" class="form-control" name="email_user" id="email_user" placeholder="Votre email@email.com">
            </div>
            <input type="submit" value="Reserver" name="validReservation" class="btn btn-outline-info"/>
        </form>
    </div>

    <?php

}else{
    echo "<p class='alert-warning p-5 mt-2'>Vous dévez etre un de nos clients pour reserver un gite, merci de vous inscrire ou de vous connectez !</p>";
}


