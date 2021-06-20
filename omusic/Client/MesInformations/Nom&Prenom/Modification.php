<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(!empty($_POST)){ //Si l'user selectionne le bouton submit execution de la tâche on attribue les variables qu'il a rentré
    
  $nouveau_nom = htmlspecialchars($_POST['nouveau_nom']);
  $nouveau_prenom = htmlspecialchars($_POST['nouveau_prenom']);
  $id=$_SESSION['id'];

  $req = $conn1->prepare('UPDATE utilisateurs SET nom = ?, prenom = ? WHERE id_utilisateurs = ?;');  
  $req->execute([$nouveau_nom, $nouveau_prenom, $id]); 

  $_SESSION['nom'] = $nouveau_nom;
  $_SESSION['prenom'] = $nouveau_prenom;
  header("location: /RT/1projet24/omusic/Client/PageClient.php");
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
					<h1 class="">Veuillez inserer votre nouveau nom et prénom :</h1>
				</div>

				<form method="POST" class="input">

					<div class="input">
					<?php
					echo '<input  class="input" type="text" pattern="[a-zA-Zéàâë]*" placeholder="Prénom" required name="nouveau_prenom" value="'.stripslashes($_SESSION['prenom']).'">'; 
					echo '<input class="input" type="text" pattern="[a-zA-Zéàâë]*" placeholder="Nom" required name="nouveau_nom" value="'.stripslashes($_SESSION['nom']).'">';
					?>
					</div>

					<div class="button">
						<button type="submit" name="submit" class="enregistrer">Enregistrer</button>
				</form>
						<a href="/RT/1projet24/omusic/Client/PageClient.php">Annuler</a>
					</div>
	</div>
</body>
</html>

