<?php
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

$req = $conn1->prepare('SELECT * FROM categories ORDER BY nom_categories;');
$req->execute();
$req = $req->fetchAll();

$sec = 0;
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
			$sec = $sec + 1; 
		?>	

		<a href="Produits_general.php?sec=<?= $sec ?>" class="categorie_a">
			<div class="categorie_div">
				<div class="categorie_img"><img src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/categories/<?= $produits['photo_categories'] ?>"></div>
				<div class="categorie_titre"><?= $produits['nom_categories']?> </div>
			</div>	
		</a>
		<?php	
		}
		?>
	</div>
</body>
</html>