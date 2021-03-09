<?php

$title = "GITE.COM -DÉTAILS-";

echo "Votre gite est reserver";
require "Models/GitesModel.php";
$db = new Gites();

$db->disabledGite();

