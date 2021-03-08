<?php
//Appel du fichier class Database
require "Database.php";

class Gites extends Database
{
    //Creation de propriéte de la classe Gites
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
                    <a href="index.php?url=details_gite&id=<?= $row['id'] ?>" class="btn btn-outline-info">Plus d'infos</a>
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
                        <a href="index.php?url=administration" class="btn btn-outline-danger mt-2">RETOUR</a>
                        <?php
                    }else{
                        ?>
                        <a href="index.php?url=accueil" class="btn btn-outline-danger mt-2">RETOUR</a>
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
                    <p class="alert-success p-2"><?=  $date_a->format('d-m-Y à H:i:s')?></p>

                    <p><b>Date de depart : </b></p>
                    <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y à H:i:s')?></p>

                </div>
            </div>
        </div>
        <?php


    }

    public function addGite(){
        $db = $this->getPDO();
        if(isset($_POST['nom_gite'])){
            $nom_gite = $_POST['nom_gite'];
        }

        if(isset($_POST['description_gite'])){
            $description_gite = $_POST['description_gite'];
        }

        if(isset($_POST['img_gite'])){
            $img_gite = $_POST['img_gite'];
        }

        if(isset($_POST['nbr_chambre'])){
            $nbr_chambre = $_POST['nbr_chambre'];
        }

        if(isset($_POST['nbr_sdb'])){
            $nbr_sdb= $_POST['nbr_sdb'];
        }

        if(isset($_POST['zone_geo'])){
            $zone_geo = $_POST['zone_geo'];
        }

        if(isset($_POST['prix'])){
            $prix = $_POST['prix'];
        }

        if(isset($_POST['disponible'])){
            $disponible = $_POST['disponible'];
        }

        if(isset($_POST['date_arrivee'])){
            $date_arrivee = $_POST['date_arrivee'];
        }

        if(isset($_POST['date_depart'])){
            $date_depart = $_POST['date_depart'];
        }

        if(isset($_POST['type_gite'])){
            $type_gite = $_POST['type_gite'];
        }

        try{
            $db = $this->getPDO();
            $req = $db->prepare("INSERT INTO gites (nom_gite, description_gite, img_gite, nbr_chambre, nbr_sdb, zone_geo, prix, disponible, date_arrivee, date_depart, gite_category) VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
            $req->bindParam(1, $nom_gite);
            $req->bindParam(2, $description_gite);
            $req->bindParam(3, $img_gite);
            $req->bindParam(4, $nbr_chambre);
            $req->bindParam(5, $nbr_sdb);
            $req->bindParam(6, $zone_geo);
            $req->bindParam(7, $prix);
            $req->bindParam(8, $disponible);
            $req->bindParam(9, $date_arrivee);
            $req->bindParam(10, $date_depart);
            $req->bindParam(11, $type_gite);
            $insert = $req->execute(array($nom_gite, $description_gite, $img_gite, $nbr_chambre, $nbr_sdb, $zone_geo, $prix, $disponible, $date_arrivee, $date_depart, $type_gite));
            if($insert){
                header("Location: http://localhost/newgites/index.php?url=administration");
                var_dump($req);
                return $req;
            }else{
                echo "<p class='alert-danger p-3'>Une erreur est survenue durant l'ajout du gite, merci de verifié tous les champs !</p>";
            }

        }catch (PDOException $e){
            echo "Erreur : Merci de vérifié les données du formulaire";
        }


    }

    public function updateGite(){
        $db = $this->getPDO();

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

        $sql = "UPDATE gites SET nom_gite = ?, description_gite = ?, img_gite = ?, nbr_chambre = ?, nbr_sdb = ?, zone_geo = ?, prix = ?, disponible = ?, date_arrivee = ?, date_depart = ?, gite_category = ? WHERE id = ?";
        $id = $_GET['id'];
        $req = $db->prepare("SELECT * FROM gites WHERE id = ?");
        $req->fetch(PDO::FETCH_ASSOC);
        $update = $update = $db->prepare($sql);
        $update->bindParam(1, $this->nom_gite);
        $update->bindParam(2, $this->description_gite);
        $update->bindParam(3, $this->img_gite);
        $update->bindParam(4, $this->nbr_chambre);
        $update->bindParam(5, $this->nbr_sdb);
        $update->bindParam(6, $this->zone_geo);
        $update->bindParam(7, $this->prix);
        $update->bindParam(8, $this->disponible);
        $update->bindParam(9, $this->date_arrivee);
        $update->bindParam(10, $this->date_depart);
        $update->bindParam(11, $this->type_gite);
        $maj = $update->execute(
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

    public function giteToDelete($id){

        $db = $this->getPDO();
        $req = $db->prepare("SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category WHERE gites.id = ? ");
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

        public function deleteGite(){
            $db = $this->getPDO();
            $id = $_GET['id'];
            $sql = "DELETE FROM gites WHERE id = ?";
            $req = $db->prepare($sql);
            $req->bindParam(1, $id);
            $req->execute(array($id));
            if ($req) {
                header("Location: http://localhost/newgites/index.php?url=administration");
            } else {
                echo "<p class='alert-warning p-2'>Une erreur est survenue duarant la supression de cet élément.</p>";
            }
        }
        public function avalableGite(){
            $today = date("Y-m-d");

            $db = $this->getPDO();
            //SELECT * FROM gites WHERE  date_arrivee  > '".$date_start."' AND date_depart < '".$date_end."' AND nbr_chambre = '".$nbr_chambre."
            $req = $db->query("SELECT * FROM gites WHERE date_depart < '".$today."' AND disponible = 1");
            ?>
            <div class="row">
                <?php
                foreach ($req as $row){
                    /*
                    echo "Date du jour :" .$today;
                    echo "Date de depart :" .$row['date_depart'];
                    */
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


    public function sortGiteByDate(){
        $db = $this->getPDO();
        $today = date("d-m-Y");

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

    public function recapGiteById($id){
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

    public function disabledGite(){
        $db = $this->getPDO();
        $sql = "UPDATE gites SET disponible=0 WHERE id = ?";
        $changeStatus = $db->prepare($sql);
        $id = (isset($_GET['id']) ? $_GET['id'] : '');
        $changeStatus->bindParam(1, $id);
        $res = $changeStatus->execute();
        if($res){
            echo "<p class='alert-success p-3'>Votre commande est bien validée</p>";
            echo "<a class='btn btn-success' href='accueil'>Retour</a>";
        }else{
            echo "<p class='alert-danger p-3'>Une erreur est survenue lors de la reservation, merci de verifié vos email !</p>";
        }
    }

}