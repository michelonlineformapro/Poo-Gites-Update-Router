<?php
session_start();
ob_start();
//Utilisation de la variable superglobale $_GET['']

if(isset($_GET['url'])){
    $url = $_GET['url'];
}else{
    $url = "accueil";
}

if(!isset($_GET['url']) || empty($_GET['url'])){

}

if($_GET['url'] === ''){
    $url = 'accueil';
}


//Appel des vues

// url nom du dossier/index.php?url=accueil

if($url === 'accueil'){
    require 'views/accueil.php';
}elseif ($url === 'connexion'){
    require 'views/connexion.php';
}elseif ($url === 'deconnexion'){
    require 'views/deconnexion.php';
}elseif (isset($_SESSION['connecter']) && $_SESSION['connecter'] === true && $url === "administration"){
    require 'views/administration.php';
}elseif (isset($_SESSION['connecter']) && $_SESSION['connecter'] === true && $url === "ajouter_gites"){
    require "views/ajouter_gites.php";
}elseif ($url === "details_gite" && isset($_GET['id']) && $_GET['id'] > 0){
    require "views/details_gite.php";
}elseif (isset($_SESSION['connecter']) && $_SESSION['connecter'] === true && $url === "supprimer_gite" && isset($_GET['id']) && $_GET['id'] > 0){
    require "views/supprimer_gite.php";
}elseif (isset($_SESSION['connecter']) && $_SESSION['connecter'] === true && $url === "maj_gite" && isset($_GET['id']) && $_GET['id'] > 0){
    require "views/maj_gite.php";
}elseif ($url === "rechercher_gite"){
    require "views/recherche_gite.php";
}elseif ($url === "reservation" && isset($_GET['id']) && $_GET['id'] > 0){
    require 'views/reservation.php';
}elseif ($url === "confirmer_reservation"){
    require "views/confirmer_reservation.php";
}elseif ($url === "incription"){
    require "views/inscription.php";
}elseif (isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true && $url === "ajouter_commentaire" && isset($_GET['id']) && $_GET['id'] > 0){
    require "views/ajouter_commentaire.php";
}elseif ($url === "rechercher"){
    require "views/recherche_all.php";
}


elseif($url !=  '#:[\w]+)#'){
    require 'views/404.php';
}



$content = ob_get_clean();
require "template.php";

