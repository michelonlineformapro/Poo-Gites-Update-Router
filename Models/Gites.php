<?php
//Appel du fichier class Database
require "Database.php";

class Gites extends Database{
    //Creation des propriétes de la classe Gites
    private $id_gite;
    private $nom_gite;
    private $description_gite;
    private $img_gite;
    private $prix;
    private $nbr_chambre;
    private $nbr_sdb;
    private $zone_geo;
    private $disponible;
    private $date_arrivee;
    private $date_depart;
    private $type_gite;

    //Table commentaire
    private $auteur_commentaire;
    private $contenus_commentaire;
    private $gites_id;
    private $id_commentaire;


    //Methodes public de liste des gites (client)
    public function getAllGiteAdmin(){
$db = $this->getPDO();
$req = $db->query("SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category");
?>
<div class="row">
    <?php
    foreach ($req as $row){
        ?>

        <div class="col-4 mt-3">
            <div class="card">
                <img  src="<?= $row['img_gite'] ?>" class="card-img-top img-fluid" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-info"><?= $row['nom_gite'] ?></h5>
                    <p class="card-text"><b>Description : </b></p>
                    <p><?= $row['description_gite'] ?></p>
                    <p><b>Type de logement :</b><b class="text-info"><?= $row['type'] ?></b></p>
                    <p><b>Nombre de chambre : </b><b class="text-danger"><?= $row['nbr_chambre'] ?></b></p>
                    <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $row['nbr_sdb'] ?></b></p>
                    <p><b>Zone géographique : </b><b class="text-info"><?= $row['zone_geo'] ?></b></p>
                    <p><b>Prix à la semaine : </b><b class="text-success"><?= $row['prix'] ?> €</b></p>

                    <?php
                    $dispo = $row['disponible'];
                    if($dispo == false){
                        $dispo =  "NON";
                    }else{
                        $dispo = "OUI";
                    }
                    ?>

                    <p><b>Disponible : </b><b class="text-warning"><?= $dispo ?></b></p>
                    <?php
                    $date_a = new DateTime($row['date_arrivee']);
                    $date_d = new DateTime($row['date_depart']);
                    ?>
                    <p><b>Date d'arrivée : </b> </p>
                    <p class="alert-success p-2"><?=  $date_a->format('d-m-Y')?></p>

                    <p><b>Date de depart : </b></p>
                    <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y')?></p>
                    <a href="details_gite&id=<?= $row['id'] ?>" class="btn btn-outline-info">Plus d'infos</a>
                    <br /><br />
                    <a href="index.php?url=maj_gite&id=<?= $row['id'] ?>" class="btn btn-outline-warning">Editer le gite</a>
                    <br /><br />
                    <a href="index.php?url=supprimer_gite&id=<?= $row['id'] ?>" class="btn btn-outline-danger">Suprimer le gite</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<?php
    }
    //Récupéré un gite pai ID pour la page détails
    public function getGiteById($id){
        $db = $this->getPDO();
        $req = $db->prepare("SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category WHERE gites.id = ?");
        $id = $_GET['id'];
        $req->bindParam(1, $id);
        $req->execute();
        $res = $req->fetch();
        ?>
        <div>
            <h2 class="text-center text-warning"><?= $res['nom_gite'] ?></h2>
            <h3 class="text-center text-info">Type : <?= $res['type'] ?></h3>
            <div class="row mt-5">
                <div class="col-6">
                    <img width="100%" src="<?= $res['img_gite'] ?>" alt="<?= $res['nom_gite'] ?>" title="<?= $res['nom_gite'] ?>"/>
                        <a href="reservation&id=<?= $res['id'] ?>" class="btn btn-outline-info mt-3">RESERVER</a>
                    <br>
                    <?php
                    //On demarre la session
                    //si session connecter retourne la page d'accueil
                    if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
                        ?>
                        <a href="administration" class="btn btn-outline-danger mt-2">RETOUR</a>
                        <?php
                    }else{
                        ?>
                        <a href="accueil" class="btn btn-outline-danger mt-2">RETOUR</a>
                        <?php
                    }

                    //Si utilisateur est connecté on peu ajouter un commentaire
                    if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                        ?>
                        <a href="ajouter_commentaire&id=<?= $res['id'] ?>" class="btn btn-outline-danger mt-2">Ajouter un commentaire</a>
                        <?php
                    }else{
                        ?>
                        <p></p>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-6">
                    <p class="card-text"><b>Description : </b></p>
                    <p><?= $res['description_gite'] ?></p>
                    <p><b>Nombre de chambre : </b><b class="text-danger"><?= $res['nbr_chambre'] ?></b></p>
                    <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $res['nbr_sdb'] ?></b></p>
                    <p><b>Zone géographique : </b><b class="text-info"><?= $res['zone_geo'] ?></b></p>
                    <p><b>Prix à la semaine : </b><b class="text-success"><?= $res['prix'] ?> €</b></p>

                    <?php
                    $dispo = $res['disponible'];
                    if($dispo == false){
                        echo $dispo =  "NON";
                    }else{
                        echo  $dispo = "OUI";
                    }
                    ?>

                    <p><b>Disponible : </b><b class="text-warning"><?= $dispo ?></b></p>
                    <?php
                    $date_a = new DateTime($res['date_arrivee']);
                    $date_d = new DateTime($res['date_depart']);
                    ?>
                    <p><b>Date d'arrivée : </b> </p>
                    <p class="alert-success p-2"><?=  $date_a->format('d-m-Y')?></p>

                    <p><b>Date de depart : </b></p>
                    <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y')?></p>

                </div>
            </div>
        </div>
        <?php


    }
    //Ajouter un gite appélé dans la page ajouter_gites.php
    public function addGite(){

        //On verifie les champs du formulaires
        if(isset($_POST['nom_gite'])){
            $this->nom_gite = $_POST['nom_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nom du gite</p>";
        }

        if(isset($_POST['description_gite'])){
            $this->description_gite = $_POST['description_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ description du gite</p>";
        }

        if(isset($_POST['img_gite'])){
            $this->img_gite = $_POST['img_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ image du gite</p>";
        }

        if(isset($_POST['nbr_chambre'])){
            $this->nbr_chambre = $_POST['nbr_chambre'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nombre de chambre</p>";
        }

        if(isset($_POST['nbr_sdb'])){
            $this->nbr_sdb= $_POST['nbr_sdb'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nombre de salle de bain</p>";
        }

        if(isset($_POST['zone_geo'])){
            $this->zone_geo = $_POST['zone_geo'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ departement</p>";
        }

        if(isset($_POST['prix'])){
            $this->prix = $_POST['prix'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ prix du gite</p>";
        }

        if(isset($_POST['disponible'])){
            $this->disponible = $_POST['disponible'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ disponible</p>";
        }

        if(isset($_POST['date_arrivee'])){
            $this->date_arrivee = $_POST['date_arrivee'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date d'arrivée</p>";
        }

        if(isset($_POST['date_depart'])){
            $this->date_depart = $_POST['date_depart'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date de depart</p>";
        }

        if(isset($_POST['type_gite'])){
            $this->type_gite = $_POST['type_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ type de gite</p>";
        }
        //Verifié que la date d'arrivée n'est pas supérieur à la date départ ceci englobe le try catch
        if(isset($this->date_depart) > isset($this->date_arrivee)){
            echo "<p class='alert-danger p-2'>ATTENTION : la date d'arrivée est supérieur à la date de part !</p>";
        }
            //Connexion a PDO + requète SQL + requète préparée + execution
            try {
                $db = $this->getPDO();
                $req = $db->prepare("INSERT INTO gites (nom_gite, description_gite, img_gite, nbr_chambre, nbr_sdb, zone_geo, prix, disponible, date_arrivee, date_depart, gite_category) VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
                $req->bindParam(1, $this->nom_gite);
                $req->bindParam(2, $this->description_gite);
                $req->bindParam(3, $this->img_gite);
                $req->bindParam(4, $this->nbr_chambre);
                $req->bindParam(5, $this->nbr_sdb);
                $req->bindParam(6, $this->zone_geo);
                $req->bindParam(7, $this->prix);
                $req->bindParam(8, $this->disponible);
                $req->bindParam(9, $this->date_arrivee);
                $req->bindParam(10, $this->date_depart);
                $req->bindParam(11, $this->type_gite);
                $insert = $req->execute(array($this->nom_gite, $this->description_gite, $this->img_gite, $this->nbr_chambre, $this->nbr_sdb, $this->zone_geo, $this->prix, $this->disponible, $this->date_arrivee, $this->date_depart, $this->type_gite));
                //Si l'execution fonctionne
                //On fais une redirection Sinon on affiche une erreur
                if ($insert) {
                    header("Location: http://localhost/newgites/index.php?url=administration");
                } else {
                    echo "<p class='alert-danger p-3'>Une erreur est survenue durant l'ajout du gite, merci de verifié tous les champs !</p>";
                }

            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout du gites ! Merci de recommencer !";
            }

    }
    //Mise à jour  des gites en mode administrateur
    public function updateGite(){

        //Connexion à PDO
        $db = $this->getPDO();

        //Verif des champs du formulaires
        if(isset($_POST['nom_gite'])){
            $this->nom_gite = htmlspecialchars(strip_tags($_POST['nom_gite']));
        }

        if(isset($_POST['description_gite'])){
            $this->description_gite =htmlspecialchars(strip_tags($_POST['description_gite']));
        }

        if(isset($_POST['img_gite'])){
            $this->img_gite = htmlspecialchars(strip_tags($_POST['img_gite']));
        }

        if(isset($_POST['nbr_chambre'])){
            $this->nbr_chambre = htmlspecialchars(strip_tags($_POST['nbr_chambre']));
        }

        if(isset($_POST['nbr_sdb'])){
            $this->nbr_sdb = htmlspecialchars(strip_tags($_POST['nbr_sdb']));
        }

        if(isset($_POST['zone_geo'])){
            $this->zone_geo = htmlspecialchars(strip_tags($_POST['zone_geo']));
        }

        if(isset($_POST['prix'])){
            $this->prix = htmlspecialchars(strip_tags($_POST['prix']));
        }

        if(isset($_POST['disponible'])){
            $this->disponible = htmlspecialchars(strip_tags($_POST['disponible']));
        }

        if(isset($_POST['date_arrivee'])){
            $this->date_arrivee = htmlspecialchars(strip_tags($_POST['date_arrivee']));
        }

        if(isset($_POST['date_depart'])){
            $this->date_depart = htmlspecialchars(strip_tags($_POST['date_depart']));
        }

        if(isset($_POST['type_gite'])){
            $this->type_gite = htmlspecialchars(strip_tags($_POST['type_gite']));
        }

        //Requète SQL

        $sql = "UPDATE gites SET nom_gite = ?, description_gite = ?, img_gite = ?, nbr_chambre = ?, nbr_sdb = ?, zone_geo = ?, prix = ?, disponible = ?, date_arrivee = ?, date_depart = ?, gite_category = ? WHERE id = ?";
        //Recuperation de ID
        $id = $_GET['id'];
        //Requète préparée
        $req = $db->prepare("SELECT * FROM gites WHERE id = ?");
        //Recherche dans la table
        $req->fetch(PDO::FETCH_ASSOC);

        $req->bindParam(1, $this->nom_gite);
        $req->bindParam(2, $this->description_gite);
        $req->bindParam(3, $this->img_gite);
        $req->bindParam(4, $this->nbr_chambre);
        $req->bindParam(5, $this->nbr_sdb);
        $req->bindParam(6, $this->zone_geo);
        $req->bindParam(7, $this->prix);
        $req->bindParam(8, $this->disponible);
        $req->bindParam(9, $this->date_arrivee);
        $req->bindParam(10, $this->date_depart);
        $req->bindParam(11, $this->type_gite);
        $maj = $req->execute(
                array(
                        $this->nom_gite,
                    $this->description_gite,
                    $this->img_gite,
                    $this->nbr_chambre,
                    $this->nbr_sdb,
                    $this->zone_geo,
                    $this->prix,
                    $this->disponible,
                    $this->date_arrivee,
                    $this->date_depart,
                    $this->type_gite,
                    $id));

        if($maj){
            header("Location: http://localhost/newgites/administration");
            exit();
        }else{
            echo "<p class='alert-danger p-2'>Merci de verifié et remplir tous les champs !</p>";
        }

        //var_dump($update);


    }
    //Supprimer un gite
    public function giteToDelete($id){

        //Connexion à PDO
        $db = $this->getPDO();
        //Requète préparée + sql
        $req = $db->prepare("SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category WHERE gites.id = ? ");
        //Récupération de id dans url
        $id = $_GET['id'];
        //Loaison des paramètres
        $req->bindParam(1, $id);
        //Execution de la requète
        $req->execute();
        //Recherche dans la table
        $res = $req->fetch();
        //Reprise des valeurs du gite
        ?>
        <div>
            <h2 class="text-center text-warning"><?= $res['nom_gite'] ?></h2>
            <h3 class="text-center text-info">Type : <?= $res['type'] ?></h3>
            <div class="row mt-5">
                <div class="col-6">
                    <img width="100%" src="<?= $res['img_gite'] ?>" alt="<?= $res['nom_gite'] ?>" title="<?= $res['nom_gite'] ?>"/>
                </div>
                <div class="col-6">
                    <p class="card-text"><b>Description : </b></p>
                    <p><?= $res['description_gite'] ?></p>
                    <p><b>Nombre de chambre : </b><b class="text-danger"><?= $res['nbr_chambre'] ?></b></p>
                    <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $res['nbr_sdb'] ?></b></p>
                    <p><b>Zone géographique : </b><b class="text-info"><?= $res['zone_geo'] ?></b></p>
                    <p><b>Prix à la semaine : </b><b class="text-success"><?= $res['prix'] ?> €</b></p>
                </div>
            </div>
        </div>
        <?php
        }
    //Confirmation de supression du gite
    public function deleteGite(){
        //Connexion à PDO
            $db = $this->getPDO();
            //Récupération de ID
            $id = $_GET['id'];
            //Requète SQL
            $sql = "DELETE FROM gites WHERE id = ?";
            //Requète préparée
            $req = $db->prepare($sql);
            //Liaison des paramètres
            $req->bindParam(1, $id);
            //Execution de la requète
            $req->execute(array($id));
            //Si ca fonctionne
            if ($req) {
                header("Location: http://localhost/newgites/index.php?url=administration");
            } else {
                //Sinon on affiche une erreur
                echo "<p class='alert-warning p-2'>Une erreur est survenue duarant la supression de cet élément.</p>";
            }
        }
        //Afficher les gite disponible pour les visiteurs
    public function avalableGite(){
        //Stocké la date du jour
            $today = date("Y-m-d");
            //Connexion à PDO
            $db = $this->getPDO();

            //SELECT * FROM gites WHERE  date_arrivee  > '".$date_start."' AND date_depart < '".$date_end."' AND nbr_chambre = '".$nbr_chambre."
            //On affiche tous les gites dont la date de départ est < a la date du jour
            $req = $db->query("SELECT * FROM gites WHERE date_depart < '".$today."' AND disponible = 1");
            ?>
            <div class="row">
                <?php
                //Boucle de lecture
                foreach ($req as $row){
                    /*
                    echo "Date du jour :" .$today;
                    echo "Date de depart :" .$row['date_depart'];
                    */
                    //On affiche la bonne chaine de caractères en fonction du booleen 0 = false & 1 = true
                    $dispo = $row['disponible'];
                    //Si diponible  = 0
                    if($dispo == false) {
                        $dispo = "NON";
                    }else {
                        $dispo = "OUI";
                    }
                    ?>
                    <div id="gite-dispo" class="col-sm-12 col-lg-4 mt-3">
                        <div id="gite-card" class="card">
                            <h3 class="card-title text-info alert-warning p-2"><?= $row['nom_gite'] ?></h3>
                            <img  src="<?= $row['img_gite'] ?>" class="card-img-top img-fluid" alt="...">
                            <div class="card-body">
                                <p><b>Nombre de chambre : </b><b class="text-warning"><?= $row['nbr_chambre'] ?></b></p>
                                <?php
                                    $date_fin = new DateTime($row['date_depart']);

                                ?>
                                <p><b>Disponible depuis le : </b><b class="text-info"><?= $date_fin->format("d-m-Y") ?></b></p>
                                <a href="index.php?url=details_gite&id=<?= $row['id'] ?>" class="btn btn-outline-info mt-2">Plus d'infos</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                ?>
            </div>
            <?php
        }
    //Systeme de filtre par date a l'aide du formulaire de recherche
    public function sortGiteByDate(){
        $db = $this->getPDO();
        $today = date("d-m-Y");

        //Récupération des valeurs du formaulaire

        if(isset($_POST['date_arrivee'])){
            $date_start = $_POST['date_arrivee'];
        }
        if(isset($_POST['date_depart'])){

            $date_end = $_POST['date_depart'];
        }

        if(isset($_POST['nbr_chambre'])){
            $nbr_chambre = $_POST['nbr_chambre'];
        }
        /*
        var_dump($date_start);
        var_dump($date_end);
        var_dump($nbr_chambre);
        */
        //Ici on affiche les résultats ou les dates de départ dans la table sont inférieurs à la date entrée par l'utilisateur
        $search = $db->query("SELECT * FROM gites WHERE date_depart < '".$date_end."' AND nbr_chambre = '".$nbr_chambre."'");

        ?>

        <div class="row">
            <?php
            foreach ($search as $row){
                if($search  && $search->rowCount() > 0){
                ?>
                <div class="col-4 mt-3">
                    <div class="card" style="width: 22rem;">
                        <img  src="<?= $row['img_gite'] ?>" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-info"><?= $row['nom_gite'] ?></h5>
                            <p class="card-text"><b>Description : </b></p>
                            <p><?= $row['description_gite'] ?></p>
                            <p><b>Nombre de chambre : </b><b class="text-danger"><?= $row['nbr_chambre'] ?></b></p>
                            <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $row['nbr_sdb'] ?></b></p>
                            <p><b>Zone géographique : </b><b class="text-info"><?= $row['zone_geo'] ?></b></p>
                            <p><b>Prix à la semaine : </b><b class="text-success"><?= $row['prix'] ?> €</b></p>

                            <?php
                            $dispo = $row['disponible'];
                            if($dispo == false){
                                $dispo =  "NON";
                            }else{
                                $dispo = "OUI";
                            }
                            ?>

                            <p><b>Disponible : </b><b class="text-warning"><?= $dispo ?></b></p>
                            <?php
                            $date_a = new DateTime($row['date_arrivee']);
                            $date_d = new DateTime($row['date_depart']);
                            ?>
                            <p><b>Date d'arrivée : </b> </p>
                            <p class="alert-success p-2"><?=  $date_a->format('d-m-Y')?></p>

                            <p><b>Date de depart : </b></p>
                            <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y')?></p>
                            <a href="index.php?url=details_gite.php&id=<?= $row['id'] ?>" class="btn btn-outline-info">Plus d'infos</a>
                        </div>
                    </div>
                </div>

                <?php

                }else{
                    echo "<p class='alert-danger p-2'>Aucune offre ne correspond à vos critères de recherche</p>";
                }
            }
            ?>
        </div>
        <?php

    }
    //Méthode recapitulatif des données du gite réservé lorsque le visiteur valide la reservation dans l'email
    public function recapGiteById($id){
        //Connexion à PDO
        $db = $this->getPDO();
        //Requète SQL similaire à getGiteById sans les bouton de détails et de reservation
        $req = $db->prepare("SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category WHERE gites.id = ?");
        //Recup de l'ID
        $id = $_GET['id'];
        //Liaison des paramètres
        $req->bindParam(1, $id);
        //Execution de la requète
        $req->execute();
        //Listing des element trouvé
        $res = $req->fetch();
        ?>
        <div>
            <h2 class="text-center text-warning"><?= $res['nom_gite'] ?></h2>
            <h3 class="text-center text-info">Type : <?= $res['type'] ?></h3>
            <div class="row mt-5">
                <div class="col-6">
                    <img width="100%" src="<?= $res['img_gite'] ?>" alt="<?= $res['nom_gite'] ?>" title="<?= $res['nom_gite'] ?>"/>

                </div>
                <div class="col-6">
                    <p class="card-text"><b>Description : </b></p>
                    <p><?= $res['description_gite'] ?></p>
                    <p><b>Nombre de chambre : </b><b class="text-danger"><?= $res['nbr_chambre'] ?></b></p>
                    <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $res['nbr_sdb'] ?></b></p>
                    <p><b>Zone géographique : </b><b class="text-info"><?= $res['zone_geo'] ?></b></p>
                    <p><b>Prix à la semaine : </b><b class="text-success"><?= $res['prix'] ?> €</b></p>

                </div>
            </div>
        </div>
        <?php


    }
    //Le gite ne s'affiche plus lors de la confirmation de réservation
    public function disabledGite(){
        //Connexion à PDO
        $db = $this->getPDO();
        //Requète SQL de mise à jour le boolen disponible passe a 0 par gite concerné
        $sql = "UPDATE gites SET disponible = 0 WHERE id = ?";
        //Requète préparée
        $changeStatus = $db->prepare($sql);
        //Ternaire si id est recup sion id est vide
        $id = (isset($_GET['id']) ? $_GET['id'] : '');
        //Liaison des paramètres
        $changeStatus->bindParam(1, $id);
        //Execution de la requète
        $res = $changeStatus->execute();
        //Si ca marche
        if($res){
            echo "<p class='alert-success p-3'>Votre commande est bien validée</p>";
            echo "<a class='btn btn-success' href='accueil'>Retour</a>";
            header("Refresh: 5, http://localhost/newgites/accueil");
        }else{
            //Sinon on affiche une erreur
            echo "<p class='alert-danger p-3'>Une erreur est survenue lors de la reservation, merci de verifié vos email !</p>";
        }
    }
    //Si la date du jour est supérieur à la date de départ et que disponible est  = 0
    public function checkDateGite(){
        //Connexion a PDO
        $db = $this->getPDO();
        //Date du jour
        $today = date("d-m-Y");
        //On parcour tous les gites
        $sqlAll = "SELECT * FROM gites";
        $getAll = $db->query($sqlAll);
        foreach ($getAll as $row){
            //Si la date du jour est supérieur à la date de départ et que disponible est  = 0
            if($today > $row['date_depart'] && $row['disponible'] == 0){
                $sql = "UPDATE gites SET disponible = 1";
                //Requète préparée
                $updateDispoGite = $db->prepare($sql);
                //Execution de la requète
                $updateDispoGite->execute();
            }
        }
    }
    //Recherche de gite par mot clé dans nom_gite + description_gite + prix + category_gite
    public function  searchGiteByName(){
        //Connexion à PDO
        $db = $this->getPDO();

        //Recup de input recherche
        if(isset($_POST['recherche'])){
            $recherche = $_POST['recherche'];
        }else{
            $recherche = "";
            if(empty($recherche)){
                echo "<p class='alert-danger mt-2 p-2'>Merci d'enter un champ dans le barre de recherche</p>";
            }
        }

        $sql = "SELECT * FROM gites WHERE nom_gite LIKE '%$recherche%' OR description_gite LIKE '%$recherche%' OR prix LIKE '%$recherche%' OR gite_category LIKE '%$recherche%'";
        //Parcours des résultats
        $search = $db->query($sql);
        //Boucle de lecture
        foreach ($search as $row){
            ?>
            <div class="col-4 mt-3">
                <div class="card" style="width: 22rem;">
                    <img  src="<?= $row['img_gite'] ?>" class="card-img-top img-fluid" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-info"><?= $row['nom_gite'] ?></h5>
                        <p class="card-text"><b>Description : </b></p>
                        <p><?= $row['description_gite'] ?></p>
                        <p><b>Nombre de chambre : </b><b class="text-danger"><?= $row['nbr_chambre'] ?></b></p>
                        <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $row['nbr_sdb'] ?></b></p>
                        <p><b>Zone géographique : </b><b class="text-info"><?= $row['zone_geo'] ?></b></p>
                        <p><b>Prix à la semaine : </b><b class="text-success"><?= $row['prix'] ?> €</b></p>

                        <?php
                        $dispo = $row['disponible'];
                        if($dispo == false){
                            $dispo =  "NON";
                        }else{
                            $dispo = "OUI";
                        }
                        ?>

                        <p><b>Disponible : </b><b class="text-warning"><?= $dispo ?></b></p>
                        <?php
                        $date_a = new DateTime($row['date_arrivee']);
                        $date_d = new DateTime($row['date_depart']);
                        ?>
                        <p><b>Date d'arrivée : </b> </p>
                        <p class="alert-success p-2"><?=  $date_a->format('d-m-Y')?></p>

                        <p><b>Date de depart : </b></p>
                        <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y')?></p>
                        <a href="details_gite.php&id=<?= $row['id'] ?>" class="btn btn-outline-info">Plus d'infos</a>
                    </div>
                </div>
            </div>
            <?php
        }

    }
    //Afficher des commentaires par gite
    public function getCommentsByGite(){
        //Connexion à PDO
        $db = $this->getPDO();
        //Requète SQL selection de tous depuis la table commentaires ou la clé etrangère est a ID du gite trié par l'ID du commentaire
        $sql = "SELECT * FROM commentaires INNER JOIN gites ON commentaires.gites_id = gites.id WHERE commentaires.gites_id = ?";
        //Requète préparée
        $req = $db->prepare($sql);
        //Liaison récupération de l'ID dans URL
        $req->bindParam(1, $_GET['id']);
        //Execution de la requète
        $req->execute();
        //Départ de la liste
        ?>
        <ul class="list-group mt-2">
            <li class="list-group-item active">Commentaire : </li>
        <?php
        //Boucle de lecture des commentaires
        foreach ($req as $row){
            //Si on a des commentaires par ID
            if($row){
            ?>
                <li class="list-group-item">Nom de l'auteur : <b class="text-info"><?= $row['auteur_commentaire'] ?></b></li>
                <li class="list-group-item">Commentaire de l'auteur  : <b class="text-info"><?= $row['contenus_commentaire'] ?></b></li>
                <br>
        <?php

            }else{
                echo "<p class='alert-danger p-2 mt-2'>Aucun commentaire pour de gite</p>";
            }
        }
        ?>
        </ul>
        <?php
    }
    //Ajouter un commentaire au gite
    public function addCommentToGite(){
            //Connexion a pdo
            $db = $this->getPDO();
            //Recup des elements du formulaire
            //On verifie les champs du formulaires
            if(isset($_POST['auteur_commentaire'])){
                $this->auteur_commentaire = $_POST['auteur_commentaire'];
            }else{
                echo "<p class='alert-danger p-2'>Merci de remplir le champ auteur du commentaire</p>";
            }

            if(isset($_POST['contenus_commentaire'])){
                $this->contenus_commentaire = $_POST['contenus_commentaire'];
            }else{
                echo "<p class='alert-danger p-2'>Merci de remplir le champ contenu du commentaire</p>";
            }

            if(isset($_POST['gites_id']) && !empty($_POST['gites_id'])){
                $this->gites_id = htmlspecialchars(strip_tags($_POST['gites_id']));
            }else{
                echo "<p class='alert-danger p-2'>Merci de remplir le champs !</p>";
            }

            //Ici gites_id sera un champs caché et prendra l'id du gite passé dans URL
            $sql = "INSERT INTO commentaires (auteur_commentaire, contenus_commentaire, gites_id) VALUES (?,?,?)";
            $insert = $db->prepare($sql);
            $insert->bindParam(1, $this->auteur_commentaire);
            $insert->bindParam(2, $this->contenus_commentaire);
            $insert->bindParam(3, $this->gites_id);
            $insert->execute(array($this->auteur_commentaire, $this->contenus_commentaire, $this->gites_id));

            $id = $_GET['id'];

            if($insert){
                header("location:http://localhost/newgites/details_gite&id=$id");
            }else{
                echo "<p class='alert-danger p-2 mt-2'></p>";
        }
    }
}