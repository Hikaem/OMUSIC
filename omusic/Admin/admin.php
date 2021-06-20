<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(isset($_POST['submit'])){ //Si l'user selectionne le bouton submit execution de la tâche
    $pseudo = htmlspecialchars($_POST['pseudo']); //Htmlspecialchars permet de convertir au format html des entrées dans des inputs afin de "bloquer" des injections sql par input
    $mdp = htmlspecialchars($_POST['mdp']);

        if(!empty($pseudo) && !empty($mdp)){ //Verification que les informations sont remplies, sinon $erreur pour signaler l'oublie.
        
        $requser = $conn1->prepare('SELECT id_admin, mdp, pseudo FROM admintable WHERE pseudo = ? ;');  //On recupere les identifiants de la table admitable et on les compares à celles entrees
        $requser->execute(array($pseudo));  //mise en tableau des valeurs
        $pseudoexist = $requser->rowCount();
        if($pseudoexist == 1){  //Verifie si le pseudo et/ou le mdp existe

            $userinfo = $requser->fetch();
            $pwd = $userinfo['mdp']; //On  recupere le mdp dans la table admintable
            if(password_verify($mdp, $pwd)){  //On verifie si le mdp entree est similaire au hash dans la table 
                $_SESSION['id'] = $userinfo['id_admin'];
                $_SESSION['pseudo'] = $userinfo['pseudo'];
                header("Location: /RT/1projet24/omusic/Admin/Dashboard/dashboard.php?id=".$_SESSION['id']);  //Envoie vers le dashboard
            }else{
                $erreur = "Mauvais identifiant et/ou mot de passe";
            }
        }else{ //sinon affichage d'un message erreur
            $erreur = "Mauvais identifiant et/ou mot de passe";
        }
    }else{
        $erreur = "Erreur, veuillez remplir tous les champs !"; //Peut remplacer la fonction required dans HTML.
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/RT/1projet24/omusic/Admin/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"> <!-- icone pour affiche mdp-->
    <title>Connexion | Administrateur</title>
</head>         
    <body id="connexion">
        
        <div class="split-screen">
            <div class="left">
                <section class="copy">
                    <h1>Espace d'administration</h1>
                    <p>Vous êtes sur le point d'acceder à la page d'administration</p>
                </section>
            </div> 
            <div class="login-form">
                <form action="" method="POST">
                    
                    <!-- AlertBox -->
                    <?php 
                        if(isset($erreur)){  ?>
                            <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <?php echo $erreur; ?>
                            </div>
                        <?php } ?>
                    <!-- Fin alertbox -->

                    <h2 class="text-center">Connexion</h2>
                    <p>Connexion à l'espace d'administration</p>       
                    
                    <!-- Input saisie information Identifiant -->
                    <div class="form-group">
                        <label for="fname">Identifiant</label>
                        <input type="text" name="pseudo" class="form-control" placeholder="Identifiant" required autocomplete="off"> <!-- Input pour le pseudo -->
                    </div>
                    <!-- Fin Input saisie information Identifiant -->

                    <!-- Input saisie information Mot de passe -->
                    <div class="form-group">
                        <label for="fmdp">Mot de passe</label>
                        <input type="password" name="mdp" id="myInput" class="form-control" placeholder="Mot de passe" required autocomplete="off"> <!-- Input pour le mdp -->   
                    </div>
                    <!-- Fin Input saisie information Identifiant -->
                    
                    <!-- Checkbox pour "afficher le mot de passe" -->
                    <div class="forgetPWD">
                        <input type="checkbox" onclick="myFunction()" class="ShowPass">Voir mot de passe
                    </div>
                    <!-- Fin Checkbox pour "afficher le mot de passe" -->
                    
                    <div class="MDP-oublie"><a href="/RT/1projet24/omusic/Admin/mdp_oublie/resetMdp.php">Mot de passe oublié?</a></div> <!-- Lien hypertexte vers mot de passe oublié -->
                    
                    <div class="form-group"><br>
                        <button type="submit" name="submit" class="connexion-btn">Connexion</button> <!-- Boutton pour l'envoie -->
                    </div>

                    <!-- Lien vers la page d'accueil -->
                    <section class="copy-legal">
                        <p><span class="small">Retourner vers la page <a href="../Index/page_accueil/Accueil.php">d'accueil</a></span></p>
                    </section>   
                    <!-- Fin Lien vers la page d'accueil -->
                </form>
            </div>
        </div>
    </body>
<script src="/RT/1projet24/omusic/Admin/JS/script.js"></script>
</html>



<!-- O'MUSIC made by Arthur & Evan / RT1-C -->