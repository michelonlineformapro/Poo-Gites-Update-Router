<?php
    $title = "Mon Gite.com - Inscription -";
    require "Models/Adminstration.php";
    $user = new Adminstration();
?>

<h1 class="text-info">Inscription</h1>
<form method="post">
    <div class="form-group">
        <label for="email_pseudo">Votre nom d'utilisateur</label>
        <input type="text" class="form-control" name="pseudo_user" placeholder="Votre pseudo" />
    </div>

    <div class="form-group">
        <label for="emmail_user">Votre nom d'utilisateur</label>
        <input type="email" required class="form-control" name="email_user" placeholder="Votre email" />
    </div>

    <div class="form-group">
        <label for="password_user">Votre mot de passe</label>
        <input type="password" required class="form-control" name="password_user" placeholder="Votre mot de passe" />
    </div>

    <div class="form-group">
        <button type="submit"  class="btn btn-info" name="btn_add_user">S'inscrire</button>
    </div>
    <a href="accueil" class="btn btn-warning">Retour</a>
</form>

<?php
if(isset($_POST['btn_add_user'])){
    $user->registerUser();
}else{
    echo "<p class='alert-warning p-2 mt-3'>Merci de remplir tous les champs du formulaire</p>";
}