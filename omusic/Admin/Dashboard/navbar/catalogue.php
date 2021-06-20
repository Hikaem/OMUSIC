<?php

if (session_status() == PHP_SESSION_NONE) { //Si la session arrive a expiration ça la relance
    session_start();
}

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1 = connexionBDD();
require_once("fonction.php");
if (!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html');
}

//fonction suppression d'un produit
if (isset($_POST['delete'])) {
    $delete = $conn1->prepare('DELETE FROM produits WHERE id_produit = ?');
    $delete->execute([$_POST['produit_id']]);
}

//affichage des produits
$products = $conn1->query('SELECT * FROM produits');

$sql = "SELECT * FROM produits";     // déclaration de la variable appelee $sql.
$result = $conn1->query($sql);  // execution de la requête. Le resultat est dans la variable $result.
$result->execute();
$resu = $result->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Messages</title>
</head>

<body>
    <div style="margin-left:25%;padding:1px 16px;">
        <div class="dash-form">
            <div class="tbl-header">
            <h2>Catalogue de produit</h2>
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr> <!-- Tableau et affichage des produits -->
                            <th>ID</th>
                            <th>Ref</th>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Stock </th>
                            <th>Photo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php foreach ($resu as $ligne) : //On affiche toutes les informations d'un produits sur une ligne et on le repete en fonction du nombre de produit dans la table?>
                            <form method="post">
                                <input type="hidden" name="produit_id" value="<?= $ligne['id_produit'] ?>">
                                <tr>
                                    <td><?php echo $ligne['id_produit'] ?></td>
                                    <td><?php echo $ligne['reference'] ?></td>
                                    <td><?php echo $ligne['titre'] ?></td>
                                    <td><?php echo $ligne['prix'] ?>€</td>
                                    <td><?php echo $ligne['stock'] ?></td>
                                    <td><img class="img_produit" src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $ligne['photo'] ?>"></td>
                                    <td><button type="submit" name="modif" class="modification"><a href="/RT/1projet24/omusic/Admin/Dashboard/Modif_produit/modif.php?id_produit=<?php echo $ligne['id_produit'] ?>">Modifier</a></button></td>
                                    <td><button  type="submit" name="delete" class="suppression" onclick="if(window.confirm('Voulez-vous vraiment supprimer ce produit ?')){return true;}else{return false;}">Supprimer</button></td>
                                </tr>
                                <?php $id = $ligne['id_produit']; ?>
                            </form>
                            <?php endforeach ?>
                            <?php ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>
</html>