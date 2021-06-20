<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

$id=$_GET['id'];
$req = $conn1->prepare('SELECT * FROM produits INNER JOIN categories ON categories.id_categories=produits.refcategories INNER JOIN fabricant ON fabricant.id_fabricant=produits.reffabricant WHERE id_produit = ?;');
$req->execute([$id]);
$produits = $req->fetch();

if (isset($_POST['submit'])) {
	if (isset($_SESSION['prenom'])) {
		$request = $conn1->prepare('INSERT INTO panier (refutilisateurs, refproduit) VALUES (?, ?);');
		$request->execute([$_SESSION['id'], $produits['id_produit']]);
		$echo = "Le produits a bien été ajouté à votre panier !";
	} else {
		$echo = "Veuillez vous connecter pour ajouter ce produit à votre panier !";
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Produits</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<style>html { scroll-behavior: smooth; }</style>
</head>
<body>
	<?php include("header/header.php"); ?>
	<form method="POST" action="">
	<div class="produits">
		<div class="img"><img class="img" src="http://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $produits['photo'] ?>"></div>
		<div class="info">
			<div class="categorie">/<?= $produits['nom_categories'] ?></div>
			<div class="titre"><?= $produits['titre'] ?></div>
			<div class="prix">Prix  :  <?= $produits['prix'] ?> €</div>
			<?php if ($produits['stock'] < 1) {
				echo '<div class="stock_vide">Le produits n\'est pas disponible !</div>';
				} else{
				echo'<div class="ajout_panier"><button type="submit" name="submit" class="button">Ajouter au panier</button></div>';
			}?>
			<div class="erreur" style=""><?php if(isset($echo)){ echo $echo;} ?></div>
		</div>
	</div>
	<div class="nav">
		<div class="li"><a href="#description">Présentation</a> </div>
		<div class="li"><a href="#carac">Caractéristique</a> </div>
	</div>
	<div class="presentation">
		<div class="paragraphe" id="description"> <p><?= $produits['descriptions'] ?></p></div>
		<div class="image"><img class="logo" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_produit/IMG/omusic-noir.png"></div>
	</div>
	<div class="caracteristique">
		<div class="illustration"><img class="img2" src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $produits['photo'] ?>"></div>
		<div class="carac" id="carac">
			<div class="reference">Ref :<?= $produits['reference'] ?></div>
			<div class="couleur">- Couleur : <?= $produits['couleur'] ?></div>
			<div class="poid">- Poids : <?= $produits['poid'] ?> Kg</div>
			<div class="constructeur">- Constructeur : <?= $produits['nom'] ?></div>
		</div>
	</div>
	</form>
	<div class="footer">
		<?php include("footer/footer.php"); ?>
	</div>
</body>
</html>