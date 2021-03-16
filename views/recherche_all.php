<?php
require "Models/Recherche.php";
$gite = new Recherche();

?>

<form action=""  method="post">
        <!--
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="form-group">
                <label for="date_arrivee">Date d'arrivée</label>
                <input type="date"  name="date_arrivee" class="form-control">
            </div>
            <div class="form-group">
                <label for="date_depart">Date de depart</label>
                <input type="date"  name="date_depart" class="form-control">
            </div>
        </div>
        -->
            <label for="prix">Fourchette de prix par nuit</label>
            <select class="form-control" name="prix" id="nbr_chambre">
                <option value="1">0 €</option>
                <option value="2">10 - 100 €</option>
                <option value="3">100 - 500 €</option>
                <option value="4">500 - 1000 €</option>
                <option value="5">+ de 1000 €</option>
            </select>

                <label for="nbr_chambre">Nombre de chambre</label>
                <select class="form-control" name="nbr_chambre" id="nbr_chambre">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>

            <button name="btn_search_by_items" type="submit" class="btn btn-outline-warning mt-2">Rechercher</button>
</form>

<?php

if(isset($_POST['btn_search_by_items'])){
    $gite->searchGitesByItems();
}

var_dump("Prix :" .$_POST['prix']);
var_dump("Nombre de chambre :" .$_POST['nbr_chambre']);