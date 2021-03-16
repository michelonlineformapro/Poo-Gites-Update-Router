<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php?url=accueil">
        <img id="logo_gite" src="assets/img/logo.png">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="accueil">ACCUEIL <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="rechercher">RECHERCHE AVANCÉE</a>
            </li>
            <!--Si un utilisateur est connecter-->
            <li class="nav-item">
                <?php
                //On demarre la session

                //si session connecter retourne la page d'accueil
                if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                    ?>
                    <h4 class="text-danger mt-1"><b style="color: #2c4f56;font-size: 14px">Vous êtes connectez en tant que  :</b> <?= $_SESSION['email_user']  ?></h4>

                    <?php
                }else{
                    ?>
                    <a class="nav-link" href="#"></a>
                    <?php
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                //On demarre la session

                //si session connecter retourne la page d'accueil
                if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
                ?>
                <a class="nav-link" href="index.php?url=administration">ADMINISTRATION</a>
                <?php
                }else{
                ?>
                <a class="nav-link" href="#"></a>
                <?php
                }
                ?>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <a class="nav-link btn btn-secondary mr-3" href="incription">INSCRIPTION</a>
            <?php
            if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true || isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                ?>
                <a class="nav-link btn btn-danger" href="index.php?url=deconnexion">DECONNEXION</a>
                <?php
            }else{
                ?>
                <a class="nav-link btn btn-warning" href="index.php?url=connexion">CONNEXION</a>
                <?php
            }
            ?>

        </form>
    </div>
</nav>
