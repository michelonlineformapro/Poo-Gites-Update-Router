<?php
$title = "GITE.COM -ACCUEIL-";

require  "Models/Reservation.php";
//Instance de la classe gites
//Instance de la classe resevation alias phpMailer config avec mailTrap
$emailValidation = new Reservation();
if(isset($_POST['validReservation'])){
    $emailValidation->reserverGite();
    echo "<h3 class='alert-success p-3 mt-3 text-danger'>Un email viens de vous etre envoyé, merci de verifié votre boite mail pour confirmer votre resevation</h3>";
}else{
    echo "<p class='alert-warning p-3'>Merci de remplir le formulaire avec votre email</p>";
}

?>
    <div class="main-container">
        <h1 class="text-center text-info">RÉSERVATION</h1>
        <div class="alert-info p-5">
            <p>Liens pour phpMailer</p>
            <a class="btn btn-warning" target="_blank" href="https://github.com/PHPMailer/PHPMailer">PhpMailer sur Github</a>
            <p>Liens pour mailTrap catcher d'amil chelou !</p>
            <a class="btn btn-success" href="https://mailtrap.io">MailTrap email en local chelou</a>
        </div>

        <form action="" method="post">
            <div class="form-group">
                <label for="email_user">Merci d'entrer votre email</label>
                <input type="email" class="form-control" name="email_user" id="email_user" placeholder="Votre email@email.com">
            </div>
            <input type="submit" value="Reserver" name="validReservation" class="btn btn-outline-info"/>
        </form>
    </div>

<?php
