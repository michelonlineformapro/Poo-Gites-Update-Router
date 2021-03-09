<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Appel de autoloader de classe
require "vendor/autoload.php";

class Reservation
{
    public function reserverGite(){
        //Insatnce de la classe phpmailer
        $mail = new PHPMailer();
        try {
            //Config pour mailtrap
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Autorise le debug
            $mail->isSMTP(); //Utilisation du service mail transfer protocole
            $mail->Host = 'smtp.mailtrap.io'; //Appel du host mailtrap
            $mail->SMTPAuth = true; //Autorise et impose un user name + password
            $mail->Username = '1e9a0eeda636b9'; //Generer lors de la création du compte mailTrap = dans l'espace mailtrap roue crantée + smtp setting -> zendFramework https://mailtrap.io/inboxes/1163067/messages
            $mail->Password = '64faa6d7e0bd01'; // Idem pour le mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //La Transport Layer Security (TLS) ou « Sécurité de la couche de transport »
            $mail->Port = 2525; //Port pour mailtrap sinon ->587 ou 465 pour `PHPMailer::ENCRYPTION_SMTPS` et gmail
            $mail->setLanguage('fr', '../vendor/phpmailer/phpmailer/language/');
            $mail->CharSet = 'UTF-8';

            //Envoyeur et destinataire
            $mail->setFrom('locagite@gite.com', 'Annonces Administration');
            $mail->addAddress('locagite@gite.com', 'Administrateur Annonces Games.com');
            $mail->addReplyTo('locagite@gite.com', 'Annonces Administration');
            //Connexion et requete PDO get by ID
            $user = "root";
            $pass = "";
            $db = new PDO("mysql:host=localhost;dbname=phpmvc;charset=utf8;", $user, $pass);
            $query = "SELECT * FROM gites INNER JOIN category_gites ON gites.gite_category = category_gites.id_category WHERE gites.id = ?";
            $req = $db->prepare($query);
            $id = $_GET['id'];
            $req->bindParam(1, $id);
            $req->execute();

            //Contenu du mail
            $mail->isHTML(true);
            $destinataire = $_POST['email_user'];
            $mail->Subject = "Validation de votre resevation du gite sur locagite@gite.com";
            //Boucle de lecture pour retrouver le token ID
            while ($datas = $req->fetch()) {
                //Stock de l'id dans une variable
                $emailId = $datas['id'];
                //Url du liens de validation
                $url = "http://localhost/newgites/confirmer_reservation&id=$emailId";
                //Contenus du mail
                $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html">
        <title>Votre reservation chez locagite.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="color: #6cc3d5;">
    <div style="color: #6cc3d5; padding: 20px;">

        <img src="https://qiwo-indie-games.alwaysdata.net/assets/images/2.jpg" style="display: block; border-radius: 100%" width="50px" height="50px">
        <h3 style="color: #1D2326">LOCA-GITES.COM</h3>
        <!--INFOS DE DEBUG -->
        <p>ICI URL DU GITE A RESERVER : ' . $url . '</p>
        <p>ICI ID DU GITE A RESERVER: ' . $emailId . '  </p>
    </div>
    <div style="padding: 20px;">
        <h1>Loca-gite.com</h1>
        <h2>Vous : '.$destinataire.'</h2>
        <p>Vous avez déposé une demande de reservation (ET C BIEN)  avec le liens suivant</p><br />
        <p>Recapitulatif de votre commande</p>
        <p>Nom du gite :<b style="color: #2c4f56">'.$datas['nom_gite'].'</b></p>
        <p>Description du gite :<b style="color: #2c4f56"> '.$datas['description_gite'].'</b></p>
        <p>Image du gite :<img src="https://www.leboupere.fr/medias/2016/02/Logo-gite.png"/></p>
        <p>Prix par semaine du gite :<b style="color: #2c4f56"> '.$datas['prix'].' €</b></p>
        <p>Nombre de chambre :<b style="color: #2c4f56"> '.$datas['nbr_chambre'].'</b></p>
        <p>Nombre de salle de bain :<b style="color: #2c4f56"> '.$datas['nbr_sdb'].'</b></p>
        <p>Zone géographique :<b style="color: #2c4f56"> '.$datas['zone_geo'].'</b></p>
        <p>Date arrivée :<b style="color: #2c4f56"> '.$datas['date_arrivee'].'</b></p>
        <p>Date départ :<b style="color: #2c4f56"> '.$datas['date_depart'].'</b></p>
        <p>Description du gite :<b style="color: #2c4f56"> '.$datas['type'].'</b></p>
        <p>Toutes fois vous avez la possibilité d\'annuler ou de confirmer votre commande</p>
        <br /><br />
        <a href="' . $url . '" style="background-color: darkred; color: #F0F1F2; padding: 20px; text-decoration: none;">Confimer la reservation de votre gite</a><br />
        <br />
        <p>Merci d\'utiliser notre site web</p>
        <p>Cordialement : Loca-gite.com: Michael MICHEL : Administrateur</p>    
    </div>
    </body>
    </html>
    ';
                $mail->body = "MIME-Version: 1.0" . "\r\n";
                $mail->body .= "Content-type:text/html;charset=utf8" . "\r\n";
            }

            $mail->send();

        }catch (Exception $e){
            echo "<p class='alert-danger p-3'>Erreur lors de la tentative d'envoi de l'email {$mail->ErrorInfo}</p>";
        }

    }
}