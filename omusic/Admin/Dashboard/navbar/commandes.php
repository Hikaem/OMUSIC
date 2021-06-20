<?php
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
require_once("fonction.php");


$req = $conn1->query('SELECT * FROM commandes INNER JOIN Etat ON Etat.id_etat=commandes.refetat ;'); //Selection des commandes avec leurs états 

//Selection de tous les etats et affichage
if(isset($_GET['id'])){
    $commandeID = $_GET['id'];
    $request_commande = $conn1->prepare('SELECT * FROM produits INNER JOIN commander ON produits.id_produit=commander.refproduit WHERE refcommande = ?;');
    $request_commande->execute(array($commandeID));
    $CommandeCount = $request_commande->rowCount();
    $CommandeInfo = $request_commande->fetch();
}

//On dit que l'id produit est récupérable par la variable $com qui est en $_GET
if(isset($_GET['id'])){
$com = $_GET['id'];
}

//modif etat d'une commande
if(isset($_POST['update_etat'])){

	$id_prod = $_GET['id'];
	$refetat = $_POST['Netat'];

	$modif_etat = $conn1->prepare('UPDATE commandes SET refetat= ? WHERE id_commande= ?;');
	$modif_etat->execute([$refetat, $id_prod]);
	if($modif_etat){ //si la reqûete est execute on affiche le script
        echo "<script>alert('Modification enregistré');</script>"; //pop up message
    }else{
        echo"<script>alert('Une erreur s'est produite !!');</script>"; //pop up message
	}
	header('Location: https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Admin/Dashboard/dashboard.php?sec=4');
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>MesCommandes</title>
	<link rel="stylesheet" type="text/css" href="../../CSS/style.css">
</head>
<body>
<div style="margin-left:25%;padding:1px 16px;">
<div class="dash-form">
	<h1 class="commande_h1">Commandes</h1>
		<div class="commande">
			<div class="header">
				<div class="order">COMMANDE</div>
				<div class="status">STATUT</div>
			</div>
			<?php while($commande=$req->fetch()) { //affichage des commandes réalisées

				$reqarticle = $conn1->prepare('SELECT * FROM produits INNER JOIN commander ON produits.id_produit=commander.refproduit WHERE refcommande = ?;');  
				$reqarticle->execute([$commande['id_commande']]); 
				?>

				<div class="commande_entre">
					<div class="gauche">
						<div class="detail">	
							<div class="date">Commande du <?= $commande['date_commande'] ?></div>
							<div class="id"> Commande: <?= $commande['id_commande'] ?> </div>
							<div class="prix"> Prix total: <?= $commande['prix_total'] ?> €</div>
							<div class="article">Article commandé: 
							<?php while ($produit=$reqarticle->fetch()) { ?>
								<label class="produit"><?= $produit['titre'].",  ";?></label>
							<?php } ?>
							</div>
						</div>
					</div>
				<div class="droite">
					<div class="etat"><?= $commande['nom'] ?> <a href="dashboard.php?sec=4&id=<?= $commande['id_commande'] ?>">Gérer</a></div>
				</div>
			</div>
			<?php }	?>
			<?php if(isset($commandeID)){   // Vérification si l'id existe, sinon affichage message commande inexistante
                    if ($CommandeInfo == null) { echo "Cette commande n'existe pas ! ";} else { ?>  <!-- Si l'id rentré dans l'url est faux, affichage message -->
					<h3 align="center">Gérer : <?= $com ?></h3>
                    <form class="btn" method="post" action=""> 
					<?php 
                        $res = ListerEtat($conn1); //appel de la fonction qui liste les clients contenue dans fonction.php
                        $resu = $res->fetchAll(); //on liste tous les clients dans un tableau
                        print( '<select name="Netat">'); // envoyé comme paramètre dans le formulaire
                        foreach ($resu as $ligne) {
                                print( '<option value="'.$ligne["id_etat"].'">'.$ligne["nom"].'</option>'); // foreach creer une boucle tant qu'il y a des elements dans la bdd
                        }
                        print( "</select>");
                    ?> 
                    <button type="submit" name="update_etat" class="btn_close_user">Enregistrer</button>
					<a class="btn_close_user" href="dashboard.php?sec=4">Fermer</a>
                    </form>
					<?php } } ?>
			
		</div>
		
</div>
</div>
</body>

</html>

