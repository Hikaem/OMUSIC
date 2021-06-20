<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();


if(isset($_GET['section'])){ //Sert à la navigation entre les pages lors du forget pwd
    $section = htmlspecialchars($_GET['section']);
}else{
    $section = "";
}



if(isset($_POST['recup_submit'], $_POST['recup_email'])){ //Si le bouton submit et cliqué et le champ email est remplie execution des commandes.
    if(!empty($_POST['recup_email'])){ //verif si le champ email n'est pas vide
        $recup_email = htmlspecialchars($_POST['recup_email']); //Securisation du champ contre les injections sql
        if(filter_var($recup_email, FILTER_VALIDATE_EMAIL)){ //Verifie si l'entrée est un bien un format de mail
            $mail_exist = $conn1->prepare("SELECT id_admin FROM admintable where email = ?");  //On check si l'email existe dans la bdd
            $mail_exist->execute(array($recup_email)); //Stockage dans un tableau
            $mail_exist = $mail_exist->rowCount(); 
            if($mail_exist == 1){ //si le mail existe dans notre bdd
                $_SESSION['recup_email'] = $recup_email;
                $code = uniqid(true);  //Creation d'un code aléatoire et unique
                $_SESSION['recup_code'] = $code;

                $email_recup_exist = $conn1->prepare('SELECT id FROM mdpreset WHERE emailreset = ?'); //Selection de l'id dans la table
                $email_recup_exist->execute(array($recup_email));
                $email_recup_exist = $email_recup_exist->rowCount(); //calcul du nombre d'entrée dans la table mdpreset

                if($email_recup_exist == 1){ //Si l'id est recup on execute le code sinon on insert les données dans la table:
                    $recup_insert = $conn1->prepare('UPDATE mdpreset SET codereset = ? WHERE emailreset = ?');
                    $recup_insert->execute(array($code,$recup_email));
                }else{ //insertion des données de l'user dans la table mdpreset
                    $recup_insert = $conn1->prepare('INSERT INTO mdpreset(emailreset, codereset) VALUES (?, ?)');
                    $recup_insert->execute(array($recup_email,$code));
                }
                
            // Mise en forme du message avec la fonction mail() !
                $destinataire = $_POST["recup_email"];
                //$url = "https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Admin/mdp_oublie/resetMdp.php?section=code&code='.$code.'";  //url avec le code vers la page de resetMdp.php
  
                $headers = "From: O'MUSIC <no-reply@omusic.net>\r\n";
                $headers .= "MIME-version: 1.0\r\n";  
                $headers .= "Content-type: text/html; charset=utf-8";
                $headers .='Content-Transfer-Encoding: 8bit';
                
                $sujet = "Reinitialisation de votre mot de passe";
                
                $message = '<html>
                <head>
                  <title>Récupération de mot de passe - O\'MUSIC</title>
                  <meta charset="utf-8" />
                </head>
                <body>
                  <font color="#303030";>
                    <div align="center">
                      <table width="600px">
                        <tr>
                          <td>
                            
                            <div align="center"> <h1>Bonjour,</h1></div>
                            <p align="center">Nous avons bien reçu votre demande de mise à niveau de votre mot de passe. <br> Veuillez copier et coller le code joint ci-dessous sur la page de mise à niveau.
                            <br> Votre code de vérification : <b> '.$code.' </b> </p>
                            <p align="center"> A bientôt sur <a href="#">O\'MUSIC</a> !</p>
                            
                          </td>
                        </tr>
                        <tr>
                          <td align="center">
                            <font size="2">
                              Ceci est un email automatique, merci de ne pas y répondre
                            </font>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </font>
                </body>
                </html>';
                if( mail($destinataire, $sujet, $message, $headers) ){  //si le mail contient tous les elements il s'execute sinon erreur
                    echo 'Merci de regarder votre boite mail!';
                } else{ 
                        echo 'une erreur est survenu lors de l\'envoi du message';
                    }
                //Fin de la mise en forme du message    
                header('Location: https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Admin/mdp_oublie/resetMdp.php?section=code'); //Redirection vers la page de verification de code

            }else{
                $error = "Adresse email non enregistrée";
            }
        } else{
            $error = "Adresse email invalide";
        }
    }else{
        $error = "Veuillez entrer votre adresse email";
    }
}

if(isset($_POST['verif_submit'], $_POST['verif_code'])){ 
    if(!empty($_POST['verif_code'])){  //check si le contenu du champ "code" est rempli
        $verif_code = htmlspecialchars($_POST['verif_code']); //protection des données inscripte par l'user
        $verif_req = $conn1->prepare('SELECT * FROM mdpreset WHERE emailreset = ? AND codereset = ?'); //préparation de la requête
        $verif_req->execute(array($_SESSION['recup_email'],$verif_code));  //Execution du code avec les variables recupmail et code
        $verif_req=$verif_req->rowCount();
        if($verif_req == 1){  //Si l'user entre le bon code :
            $up_req = $conn1->prepare("UPDATE mdpreset SET confirme = 1 WHERE emailreset = ?"); //on remplace la valeur de confirme par 1
            $up_req->execute(array($_SESSION['recup_email']));
            header('Location:https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Admin/mdp_oublie/mdp_oublie.php?section=mdpform'); //Redirection vers la page de connexion
        }else{
            $error = "Code invalide" ;
        }
    }else{
        $error = "Veuillez entrez votre code de confirmation";
    }
}

if(isset($_POST['change_submit'])){
    if(isset($_POST['change_mdp'], $_POST['change_mdpc'])){
        //Requête pour bloquer l'access au mdpform si le code n'est pas entré
        $verif_confirme = $conn1->prepare('SELECT confirme FROM mdpreset WHERE emailreset = ?');
        $verif_confirme->execute(array($_SESSION['recup_email']));
        $verif_confirme = $verif_confirme->fetch();
        $verif_confirme = $verif_confirme['confirme'];
        //fin requête
        if($verif_confirme == 1){   //si le count dans la mdpreset est égale à 1 (nombre d'entrée dans la table) alors :
            $mdpNew = htmlspecialchars($_POST['change_mdp']);    //protection des données entrée
            $mdpRenew = htmlspecialchars($_POST['change_mdpc']);     //protection des données entrée
            if(!empty($mdpNew) AND !empty($mdpRenew)){    //verif que les champs soit remplis
                if($mdpNew == $mdpRenew){   //si les deux mdp sont identiques :
                    $mdpNew = password_hash($mdpNew,PASSWORD_DEFAULT);  //on crypte le mdp
                    $mdp_ins = $conn1->prepare('UPDATE admintable SET mdp = ? WHERE email = ?');
                    $mdp_ins->execute(array($mdpNew,$_SESSION['recup_email']));
                    $del_req = $conn1->prepare('DELETE FROM mdpreset WHERE emailreset = ?'); //on detruit les données précendente de la table mdpreset car plus utile
                    $del_req->execute(array($_SESSION['recup_email']));
                    header('Location:https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Admin/admin.php ');
                }else{
                    $error = "Vos mots de passes ne sont pas identique";
                }
            }else{
                $error = "Veuillez remplir tous les champs";
            }
        }else{
            $error = "Merci de valider votre code vérification joint par mail";
        }
    }else{
        $error = "Veuillez remplir tous les champs";
    }
}

require_once('mdp_oublie.php');

?>