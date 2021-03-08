<?php


class Database
{
    private $host = "localhost";
    private $dbname = "phpmvc";
    private $user = "root";
    private $pass = "";

    public function getPDO(){
        try {
            $db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8", $this->user, $this->pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connexion a PDO";
            //Retourne la propriété $dbpour etre utlisé dans autres fichier
            return $db;

        }catch (PDOException $e){
            echo "erreur de connexion " .$e->getMessage();
        }
    }

}