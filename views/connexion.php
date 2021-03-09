<?php
$title = "Mon Gite.com -CONNEXION-";
require "Models/Adminstration.php";
//Instance dela classe Admin
$admin = new Adminstration();

?>
<h3 class="text-danger">Vous êtes : </h3>
<span>
    <a class="btn btn-outline-secondary" id="toggle-admin">Administateur</a>
<a class="btn btn-outline-info" id="toggle-user">Client</a>
</span>


<div id="form-admin">
<?php

if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
    header("Location:http://localhost/newgites/index.php?url=administration");
}else{
    ?>
    <h1 class="text-center text-warning">CONNEXION A VOTRE ESPACE ADMINISTRATION</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" name="email_admin" class="form-control" id="exampleInputEmail1" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password_admin" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
        </div>

        <input name="btn_valid_admin" type="submit" class="btn btn-primary" />

    </form>

    <?php
    if(isset($_POST['btn_valid_admin'])){
        $admin->adminLogin();
    }else{
        echo"<p class='alert-danger mt-3 p-3'>ICI UN SEUL ADMINISTRATEUR</p>";
    }
}
?>
</div>

<div id="form-user">
<?php


    if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
    header("Location:http://localhost/newgites/accueil");
    }else{
    ?>
    <h1 class="text-center text-secondary">CONNEXION A VOTRE ESPACE CLIENT</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" name="email_user" class="form-control" id="exampleInputEmail1" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password_user" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
        </div>

        <input name="btn_valid_user" type="submit" class="btn btn-primary" />

    </form>

<?php
if(isset($_POST['btn_valid_user'])){
    $admin->userLogin();
}else{
    echo"<p class='alert-info mt-3 p-3'>ICI PLUSIEURS CLIENTS</p>";
}

}
?>
</div>





