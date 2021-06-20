
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mes Informations</title>
	<link rel="stylesheet" type="text/css" href="style_info.css">
</head>
<body>
	<h1 class="info_h1">Mes Informations</h1>
	<h2 class="info_h2">Bonjour <?php echo $_SESSION['prenom']." ". $_SESSION['nom']?> et bienvenue sur votre page client !</h2>
	<form method="POST">
	<div>
		<ul>
			<li>
				<div class="info">
					<div class="a" id="1">Nom et prénom :</div>
					<div class="b" id="1"><?php echo $_SESSION['prenom']." ". $_SESSION['nom']?></div>
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="2">E-Mail :</div>
					<div class="b" id="2"><?php echo $_SESSION['email']?></div>
					
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="3">Ville :</div>
					<div class="b" id="3"><?php echo $_SESSION['ville']?></div>
					
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="4">Code postal :</div>
					<div class="b" id="4"><?php echo $_SESSION['code_postal']?></div>
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="5">Adresse :</div>
					<div class="b" id="5"><?php echo $_SESSION['adresse']?></div>
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="6">Téléphone :</div>
					<div class="b" id="6"><?php  echo '<input type="nouveau_telephone"  required name="nouveau_telephone" value="'.stripslashes($_SESSION['telephone']).'">'?></div>
				</div>
			</li>
			<li>
				<div class="info">
					<div class="a" id="7">Mot de passe :</div>
					<div class="b" id="7"><?php echo $_SESSION['mdp']?></div>
				</div>
			</li>
		</ul>
	</div>
	<button type="submit" name="submit" class="btn btn-primary btn-block">Enregistrer</button>
	</form>
	<button type="annuler" name="annuler" class="btn btn-primary btn-block"><a href="/RT/1projet24/omusic/Client/PageClient.php">Annuler</a></button>
</body>
</html>

