<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(!empty($_POST)){ //Si l'user selectionne le bouton submit execution de la tâche on attribue les variables qu'il a rentré
    
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $mdpConf = htmlspecialchars($_POST['mdpConf']);

    if ($mdp != $mdpConf) {
      	$erreur = "Les mots de passe sont différents !";
    }else {
      $reqemail = $conn1->prepare('SELECT email FROM utilisateurs WHERE email = ? ;');  //On recupere les email de la table utilisateurs 
      $reqemail->execute(array($email));  //mise en tableau des valeurs
      $emailexist = $reqemail->rowCount();
      if($emailexist != 0){  //Verifie si l'email est déja utilisé ou non 
        $erreur = "L'adresse E-mail est déjà utilisée !";
      }else {
          $req = $conn1->prepare('INSERT INTO utilisateurs (nom, prenom, email, mdp) VALUES (?,?,?,?);');
          $req->execute([$nom, $prenom, $email, password_hash($mdp, PASSWORD_DEFAULT)]);
          header("Location: /RT/1projet24/omusic/Members/reussi.php"); 
    }   
  }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
  <form method="post">
     
    <h1>Inscription | Vos informations</h1>
    
    <div class="inputs">
      <input type="text"  pattern="[a-zA-Zéàâë]*"placeholder="Nom" name="nom" required/>
      <input type="text" pattern="[a-zA-Zéàâë]*" placeholder="Prenom" name="prenom" required/>
      <input type="email" placeholder="Email" name="email" required/>
      <input type="password" placeholder="Mot de passe" name="mdp" required>
      <input type="password" placeholder="Confirmer le mot de passe" name="mdpConf" required>
    </div>
  
    <div align ="center">
      <button type="submit">S'enregistrer</button>
      <p>Déjà Membre ? <a href="/RT/1projet24/omusic/Members/connexion.php">Se connecter</a></p>
    </div>
    <div class="erreur"><?php if(isset($erreur)){echo $erreur;} ?></div>
  </form>
</body>
</html> 