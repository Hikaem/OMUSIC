<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(!empty($_POST)){ //Si l'user selectionne le bouton submit execution de la tâche on attribue les variables qu'il a rentré
    
  $nouveau_email = htmlspecialchars($_POST['nouveau_email']);
  $id=$_SESSION['id'];

  $req = $conn1->prepare('UPDATE utilisateurs SET email = ? WHERE id_utilisateurs = ?;');  
  $req->execute([$nouveau_email, $id]); 

  $_SESSION['email'] = $nouveau_email;
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
					<h1 class="">Veuillez inserer votre nouvelle adresse E-mail :</h1>
				</div>

				<form method="POST" class="input">

					<div class="input">
					<?php
					echo '<input  class="input" type="email" placeholder="E-mail" required name="nouveau_email" value="'.stripslashes($_SESSION['email']).'">' 
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
