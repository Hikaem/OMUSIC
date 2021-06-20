<?php

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html');
}


$countMbr = $conn1->query('SELECT * FROM utilisateurs'); //Compte le nombre d'user
$nbrMembres = $countMbr->rowCount();

$countCmd = $conn1->query('SELECT * FROM commandes'); //Compte le nombre de commande
$nbrCommande = $countCmd->rowCount();

$countPrd = $conn1->query('SELECT * FROM produits'); //Compte le nombre de produit
$nbrPrd = $countPrd->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body> <!-- Affichage des données user, commande, produit sur la page accueil -->
    <div style="margin-left:25%;padding:1px 16px;">
        <div class="card">
            <div class="wrapper">
                <div class="box">
                    <h1><?php echo $nbrMembres ?></h1>
                    <p>Nombre total d'usagers sur notre site O'MUSIC.</p>
                    <a href="/RT/1projet24/omusic/Admin/Dashboard/dashboard.php?sec=3">Voir</a>
                </div>
                <div class="box">
                    <h1><?php echo $nbrCommande ?></h2>
                    <p>Tous les clients qui nous ont fait confiance et qui ont passé commande sur notre site.</p>
                    <a href="/RT/1projet24/omusic/Admin/Dashboard/dashboard.php?sec=4">Voir</a>
                </div>
                <div class="box">
                    <h1><?php echo $nbrPrd ?></h1>
                    <p>Nombre total de produits disponibles à la vente sur notre site.</p>
                    <a href="/RT/1projet24/omusic/Admin/Dashboard/dashboard.php?sec=2">Voir</a>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>