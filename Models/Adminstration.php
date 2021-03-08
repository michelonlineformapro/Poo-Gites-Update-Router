<?php

//Appel du fichier de la classe de connexion
require "Database.php";

class Adminstration extends Database
{
    private $email_admin;
    private $password_admin;

    public function  adminLogin(){

        //Connexion a la base de données a l'aide de l'instance de la classe mere (database)
        //Et appel de sa methode puyblic getPDO()

        $db = $this->getPDO();

        //Verifie si admin est deja connexté

        if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
            header('Location: http://localhost/newgites/');
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
                    echo "erreru le mot passe ne match pas";
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
}