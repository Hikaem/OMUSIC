<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>header</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
</head>
<body>
	<div class="header">
		<div class="omusic"><a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/Accueil.php"><img class="logo2" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/	Index/page_produit/IMG/omusic-noir.png"></a></div>
		<div class="navbarre">
			<div class="accueil"><a href="/RT/1projet24/omusic/Index/page_accueil/Accueil.php">ACCUEIL</a></div>
			<div class="produit"><a href="/RT/1projet24/omusic/Index/page_produit/Produits_general.php">PRODUITS</a></div>
			<div class="contact"><a href="/RT/1projet24/omusic/Index/page_accueil/contact.php">CONTACT</a></div>
		</div>
			<?php 
			if(isset($_SESSION['id'])) { ?>
     	 <div class="move">
				<div class="client_log"><a href="#"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></a></div>
        <div class="dropdown">
        <button class="dropbtn"><?php echo $_SESSION['prenom'] ; ?><i class="fas fa-sort-down"></i></button>
        <div class="dropdown-content">
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php">Mon compte</a>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=1">Mes achats</a>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=2">Mon panier</a>
          <a href='/RT/1projet24/omusic/Index/deco.php'>Se déconnecter</a>
        </div>
        </div>
        </div>
        <?php
			}else {
				echo '<div class="client"><a class="connexion" href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Members/connexion.php"> Connexion/Inscription</a></div>';
			}
			?>

	</div>
</body>
</html>