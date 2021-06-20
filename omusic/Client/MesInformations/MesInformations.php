

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mes Informations</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1 class="info_h1">Mes Informations</h1>
	<h2 class="info_h2">Bonjour <?php echo $_SESSION['prenom']." ". $_SESSION['nom']?> et bienvenue sur votre page client !</h2>

	<div class="info_body">
				<div class="info">
					<div class="a" id="1">Nom et prénom :</div>
					<div class="b" id="1"><?php echo $_SESSION['prenom']." ". $_SESSION['nom']?></div>
					<div class="c" id="1"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Nom&Prenom/Modification.php" class="modif">Modifier</a></button></div>
				</div>
				<div class="info">
					<div class="a" id="2">E-Mail :</div>
					<div class="b" id="2"><?php echo $_SESSION['email']?></div>
					<div class="c" id="2"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Email/Modification.php" class="modif">Modifier</a></button></div>
				</div>
			
				<div class="info">
					<div class="a" id="3">Ville :</div>
					<div class="b" id="3"><?php echo $_SESSION['ville']?></div>
					<div class="c" id="3"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Ville/Modification.php" class="modif">Modifier</a></button></div>
				</div>
				<div class="info">
					<div class="a" id="4">Code postal :</div>
					<div class="b" id="4"><?php echo $_SESSION['code_postal']?></div>
					<div class="c" id="4"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Code_Postal/Modification.php" class="modif">Modifier</a></button></div>
				</div>
				<div class="info">
					<div class="a" id="5">Adresse :</div>
					<div class="b" id="5"><?php echo $_SESSION['adresse']?></div>
					<div class="c" id="5"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Adresse/Modification.php" class="modif">Modifier</a></button></div>
				</div>
				<div class="info">
					<div class="a" id="6">Téléphone :</div>
					<div class="b" id="6"><?php echo $_SESSION['telephone']?></div>
					<div class="c" id="6"><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/telephone/Modification.php" class="modif">Modifier</a></button></div>
				</div>
				<div class="info">
					<div class="mdp" id="7">Modifier votre mot de passe :</div>
					<div class="c" ><button type="submit" name="submit" class="button"><a href="/RT/1projet24/omusic/Client/MesInformations/Mdp/Modification.php" class="modif">Modifier</a></button></div>
				</div>
	</div>
</body>
</html>

