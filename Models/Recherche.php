<?php

require "Gites.php";

class Recherche extends Gites{
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

    public function searchGitesByItems(){
        $db = $this->getPDO();

        $prix_null = 0;
        $prix_min = 10;
        $prix_med = 100;
        $prix_med2 = 500;
        $prix_high = 1000;

        if(isset($_POST['nbr_chambre']) && !empty($_POST['nbr_chambre'])){
            $this->nbr_chambre = $_POST['nbr_chambre'];
        }

        if(isset($_POST['prix']) && !empty($_POST['prix'])){
            $this->prix = $_POST['prix'];

            if($this->prix == 1){
                $this->prix = $prix_null;
            }
            if($_POST['prix'] == 2){
                $this->prix = $prix_min;
            }
            if ($_POST['prix'] == 3){
                $this->prix = $prix_med;
            }
            if ($_POST['prix'] == 4){
                $this->prix = $prix_med2;
            }
            if ($_POST['prix'] == 5){
                $this->prix = $prix_high;
            }
        }


        var_dump($this->prix);


        $today = date("Y-d-m");
        $sql = "SELECT * FROM gites WHERE `date_depart` BETWEEN '$today' AND `date_arrivee` AND nbr_chambre = ? AND prix <= ?";
        $req = $db->prepare($sql);


        $req->bindParam(1, $this->nbr_chambre);
        $req->bindParam(2, $this->prix);
        $req->execute(array($this->nbr_chambre, $this->prix));
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
                        <p><b>Type de logement :</b><b class="text-info"><?= $row['gite_category'] ?></b></p>
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
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
        </div>
            <?php
    }
}

