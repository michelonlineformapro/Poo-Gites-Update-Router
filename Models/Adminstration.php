<?php

//Appel du fichier de la classe de connexion
require "Database.php";

class Adminstration extends Database
{
    private $email_admin;
    private $password_admin;

    //Pour utilisateur
    private $pseudo_user;
    private $email_user;
    private $password_user;


    public function  adminLogin(){

        //Connexion a la base de données a l'aide de l'instance de la classe mere (database)
        //Et appel de sa methode puyblic getPDO()

        $db = $this->getPDO();

        //Verifie si admin est deja connexté

        if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
            header('Location: http://localhost/newgites/administration');
        }else{
            header('Location: http://localhost/newgites/connexion');
        }

        //Verification des champ du formulaire

        if(isset($_POST['email_admin']) && !empty($_POST['email_admin'])){
            $this->email_admin = htmlspecialchars(strip_tags($_POST['email_admin']));
        }else{
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }

        if(isset($_POST['password_admin']) && !empty($_POST['password_admin'])){
            $this->password_admin = htmlspecialchars(strip_tags($_POST['password_admin']));
        }else{
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }

        if(!empty($_POST['email_admin']) && !empty($_POST['password_admin'])){
            //Requète de connexion
            $sql = "SELECT * FROM admin WHERE email_admin = ? AND password_admin = ?";

            //Requète préparée
            $stmt = $db->prepare($sql);

            //Bind des paramètre

            $stmt->bindParam(1, $_POST['email_admin']);
            $stmt->bindParam(2, $_POST['password_admin']);
            //Attention ici 2 paramètres a liés
            $stmt->execute();

            if($stmt->rowCount() >= 1){
                //CReer une variavle qui liste (recherche) tous les element
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_admin = $row['id_admin'];
                //Recup de email
                $this->email_admin = $row['email_admin'];
                $hashed_password = $row['password_admin'];

                //Verif que le mot passe encrypté match
                if(password_verify($_POST['password_admin'], $hashed_password)){
                    echo "Le mot passe est bon";
                }else{
                    echo "erreur le mot passe ne match pas";
                }

                if($_POST['email_admin'] == $row['email_admin'] && $_POST['password_admin'] == $row['password_admin']){
                    //Demarre la seesion
                    session_start();
                    //Booléen pour verifié si on est connecté
                    $_SESSION['connecter'] = true;
                    $_SESSION['id_admin'] = $id_admin;
                    $_SESSION['email_admin'] = $this->email_admin;
                    //La redirection
                    header('Location: http://localhost/newgites/index.php?url=administration');
                }else{
                    echo "erreur email et mot passe pas bon";
                }
            }else{
                echo "<p class='alert-danger mt-3 p-2'>Erreur de connexion, merci de verifié votre email et mote de passe</p>";
            }
        }else{
            echo "Merci de remplir tous les champs";
        }


    }

    public function  userLogin(){

        //Connexion a la base de données a l'aide de l'instance de la classe mere (database)
        //Et appel de sa methode puyblic getPDO()

        $db = $this->getPDO();

        //Verifie si admin est deja connexté

        if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
            ?>
            <h1>Bonjour <?= $_POST['email_user'] ?></h1>
            <?php
        }else{
            echo "<p class='alert-warning mt-2 p-2'>Vous n'ètes âs encore inscrit sur notre site
                    <a href='inscription' class='btn btn-info'>S'incrire</a>
                </p>";
        }

        //Verification des champ du formulaire

        if(isset($_POST['email_user']) && !empty($_POST['email_user'])){
            $this->email_user = htmlspecialchars(strip_tags($_POST['email_user']));
        }else{
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }

        if(isset($_POST['$password_user']) && !empty($_POST['$password_user'])){
            $this->password_user = htmlspecialchars(strip_tags($_POST['$password_user']));
        }else{
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }

        if(!empty($_POST['email_user']) && !empty($_POST['password_user'])){
            //Requète de connexion
            $sql = "SELECT * FROM users WHERE email = ? AND password = ?";

            //Requète préparée
            $stmt = $db->prepare($sql);

            //Bind des paramètre

            $stmt->bindParam(1, $_POST['email_user']);
            $stmt->bindParam(2, $_POST['password_user']);
            //Attention ici 2 paramètres a liés
            $stmt->execute();

            if($stmt->rowCount() >= 1){
                //CReer une variavle qui liste (recherche) tous les element
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $row['id']; //id de la table users de phpmyadmin
                //Recup de email
                $_POST['email_user'] = $row['email_user'];
                $_POST['password_user'] = $row['password_user'];


                if($_POST['email_user'] == $row['email_user'] && $_POST['password_user'] == $row['password_user']){
                    //Demarre la seesion
                    session_start();
                    //Booléen pour verifié si on est connecté
                    $_SESSION['connecter_user'] = true;
                    $_SESSION['id_user'] = $id;
                    $_SESSION['email_user'] = $this->email_user;
                    //La redirection
                    echo "<h2 class='alert-success p-2'>Bienvenue" .$_SESSION['email_user']. "</h2>";
                }else{
                    echo "<p class='alert-danger p-2'>erreur email et mot passe ne sont pas correct !</p>";
                }
            }else{
                echo "<p class='alert-danger mt-3 p-2'>Erreur de connexion, merci de verifié votre email et mote de passe</p>";
            }
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir tous les champs</p>";
        }
        var_dump($this->email_user);
        var_dump($this->password_user);


    }


    public function registerUser(){
        $db = $this->getPDO();

        //Vérification des champs du formulaire

        if(isset($_POST['pseudo_user'])){
            $this->pseudo_user = $_POST['pseudo_user'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de renter votre nom d'utilisateur</p>";
        }

        if(isset($_POST['email_user'])){
            $this->email_user = $_POST['email_user'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de renter votre email d'utilisateur</p>";
        }

        if(isset($_POST['password_user'])){
            $this->password_user = $_POST['password_user'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de renter votre mot de passe d'utilisateur</p>";
        }

        $sql = "INSERT INTO users (email, password, pseudo) VALUES (?,?,?)";

        $insert_user = $db->prepare($sql);

        $insert_user->bindParam(1, $this->email_user);
        $insert_user->bindParam(2, $this->password_user);
        $insert_user->bindParam(3, $this->pseudo_user);

        $insert_user->execute(array($this->email_user, $this->password_user, $this->pseudo_user));

        if($insert_user){
            header("Location: http://localhost/newgites/accueil");
        }else{
            echo "<p class='alert-danger p-2'>Une erreur est survenue, merci de verifié et de remplir tous les champs !</p>";
        }



    }
}