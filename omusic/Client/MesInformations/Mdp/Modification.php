<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(!empty($_POST)){ //Si l'user selectionne le bouton submit execution de la tâche on attribue les variables qu'il a rentré
    
  $nouveau_mdp = htmlspecialchars($_POST['nouveau_mdp']);
  $mdpConf = htmlspecialchars($_POST['nouveau_mdp_confirmation']);  
  $mdp = htmlspecialchars($_POST['mdp']);
  $pwd = $_SESSION['mdp'];


  if(password_verify($mdp, $pwd)){
  		if ($nouveau_mdp == $mdpConf) {
  			 $req = $conn1->prepare('UPDATE utilisateurs SET mdp = ? WHERE id_utilisateurs = ?;');  
 				 $req->execute([password_hash($nouveau_mdp, PASSWORD_DEFAULT), $_SESSION['id']]); 
				 $_SESSION['mdp'] = $nouveau_mdp;
				 header("location: /RT/1projet24/omusic/Client/PageClient.php");
			}
			else {
				$erreur="Le nouveau mot de passe et la confirmation sont différent ! ";
			}
 	}
 	else {
 		$erreur = "votre mot de passe est incorrecte !";
 	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>modification</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="modification">
				<div class="modif_h1">
					<h1 class="">Veuillez inserer votre nouveau mot de passe :</h1>
				</div>

				<form method="POST" class="input">
					<div class="input">
						<input  class="input" type="password" placeholder="Tapez votre mot de passe" required name="mdp"> 
						<input  class="input" type="mdp" placeholder="Tapez votre nouveau mot de passe" required name="nouveau_mdp"> 
						<input class="input" type="mdp" placeholder="Confirmer votre nouveau mot de passe" required name="nouveau_mdp_confirmation">
					</div>

					<div class="button">
						<button type="submit" name="submit" class="enregistrer">Enregistrer</button>
				</form>
					<a href="/RT/1projet24/omusic/Client/PageClient.php">Annuler</a>
					</div>
					<div class="erreur"><?php if(isset($erreur)){echo $erreur;} ?></div>
	</div>
</body>
</html>

