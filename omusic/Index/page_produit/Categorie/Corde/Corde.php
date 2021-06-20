<?php
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

$req = $conn1->prepare('SELECT * FROM produits WHERE refcategories=20;');
$req->execute();
$req = $req->fetchAll();

$id = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Categorie</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="categorie_body">
		<?php
		foreach ($req as $produits) {
			$id = $id + 1;
		?>	

		<a href="Produits.php?id=<?= $produits['id_produit'] ?>" class="categorie_produit_a">
			<div class="categorie_produit_div">
				<div class="categorie_produit_img"><img class="produits" id='<?= $id ?>' src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $produits['photo'] ?>"></div>
				<div class="categorie_produit_titre"><?= $produits['titre']?> </div>
				<div class="produit_prix"><?= $produits['prix']?> €</div>
			</div>	
		</a>
		<?php
		}
		?>
	</div>
</body>
</html>