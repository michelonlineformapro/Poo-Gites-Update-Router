<?php

$title = "GITE.COM -DÉTAILS-";
ob_start();
echo "Votre gite est reserver";
require "Models/GitesModel.php";
$db = new Gites();
$db->getPDO();
$db->disabledGite();

$content = ob_get_clean();
require "views/template.php";