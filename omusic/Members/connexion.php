<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(isset($_POST['submit'])){ //Si l'user selectionne le bouton submit execution de la tâche
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['mdp']);

        
        $requser = $conn1->prepare('SELECT * FROM utilisateurs WHERE email =?;');  //On recupere les identifiants de la table utilisateurs et on les compares à celles entrees
        $requser->execute([$email]);  //mise en tableau des valeurs
        $emailexist = $requser->rowCount();
        if($emailexist == 1){  //Verifie si l'email et/ou le mdp existe

            $userinfo = $requser->fetch();
            $pwd = $userinfo['mdp']; //On  recupere le mdp dans la table utilisateurs
            if(password_verify($mdp, $pwd)){  //On verifie si le mdp entrée est similaire au hash dans la table 
                $_SESSION['id'] = $userinfo['id_utilisateurs'];
                $_SESSION['pseudo'] = $userinfo['pseudo'];
                $_SESSION['email'] = $userinfo['email'];
                $_SESSION['nom'] = $userinfo['nom'];
                $_SESSION['prenom'] = $userinfo['prenom'];
                $_SESSION['ville'] = $userinfo['ville'];
                $_SESSION['code_postal'] = $userinfo['code_postal'];
                $_SESSION['adresse'] = $userinfo['adresse'];
                $_SESSION['telephone'] = $userinfo['telephone'];
                $_SESSION['mdp'] = $userinfo['mdp'];
                header("Location: /RT/1projet24/omusic/Index/page_accueil/Accueil.php");  //Envoie vers le la page client avec l'id de l'utilisateur
            }else{
                $erreur = "Mauvais identifiant et/ou mot de passe !";
            }
        }else{ //sinon affichage d'un message erreur
            $erreur = "Utilisateur inconnu";    
        }
    
}

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Connexion | Espace membre</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  </head>
  <body>

    <form method="POST" action="">
     
      <h1>Se connecter</h1>
      
      <div class="inputs">
        <input type="email" placeholder="Email" required name="email"/>
        <input type="password" name="mdp" id="myInput" class="form-control" placeholder="Mot de passe" required autocomplete="off">
      </div>

        <button type="submit" name="submit" class="btn btn-primary btn-block">Se connecter</button>
        <div class="forgetPWD">
            <input type="checkbox" onclick="myFunction()" class="ShowPass">Voir mot de passe
        </div>
        <div class="MDP-oublie"><a href="/RT/1projet24/omusic/Members/mdp_oublie/resetMdp.php">Mot de passe oublié?</a></div> <!-- Lien hypertexte vers mot de passe oublié -->

      </div>
      <p class="inscription">Toujours pas <span>Membre ?</span> <span> <a href="/RT/1projet24/omusic/Members/inscription.php"> Inscris-toi.</a></span></p>


      <div class="erreur"><?php if(isset($erreur)){echo $erreur;}?></div>



    </form>
  </body>
  <script src="/RT/1projet24/omusic/Admin/JS/script.js"></script>
</html>