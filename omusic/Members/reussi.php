<?php
 if(isset($_POST['submit'])){
 	header("Location: /RT/1projet24/omusic/Members/Connexion.php");
 }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Incscription réussi</title>
	<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
	<form method="Post" action="">
		<h1>Inscription réussi !</h1>

		<div class="input">
			<p>Bienvenue chez O'Musics ! </p>
			<p>Vous pouvez dès maintenant vos connecter avec votre adresse mail. </p>
		</div>
		<div align ="center">
    		<button type="submit" name="submit" class="btn btn-primary btn-block">Se connecter</button> 
   		</div>
   	</form>
</body>
</html>