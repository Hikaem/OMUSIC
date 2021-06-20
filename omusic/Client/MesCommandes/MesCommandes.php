<?php
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

$req = $conn1->prepare('SELECT * FROM commandes INNER JOIN Etat ON Etat.id_etat=commandes.refetat WHERE refutilisateurs = ?;');  
$req->execute([ $_SESSION['id']]); 
$req=$req->fetchAll();


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>MesCommandes</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1 class="commande_h1">Mes Commandes</h1>
		<div class="commande">
			<div class="header">
				<div class="order">COMMANDE</div>
				<div class="status">STATUT</div>
			</div>
			<?php

			foreach ($req as $commande) {

				$reqarticle = $conn1->prepare('SELECT * FROM produits INNER JOIN commander ON produits.id_produit=commander.refproduit WHERE refcommande = ?;');  
				$reqarticle->execute([$commande['id_commande']]); 

				?>
				<div class="commande_entre">
					<div class="gauche">
						<div class="detail">	
							<div class="date">Commande du <?= $commande['date_commande'] ?></div>
							<div class="id"> Commande: <?= $commande['id_commande'] ?> </div>
							<div class="prix"> Prix total: <?= $commande['prix_total'] ?> €</div>
							<div class="article">Article commandé: <?php
							foreach ($reqarticle as $produit) {
								?>
								<label class="produit"><?= $produit['titre'].",  ";?></label>
							
						<?php	
							}
							?>
							</div>
						</div>
					</div>
				<div class="droite">
					<div class="etat"><?= $commande['nom'] ?></div>
				</div>
			</div>
				<?php 
			}
			?>
		</div>
</body>
</html>

