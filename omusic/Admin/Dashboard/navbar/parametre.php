<?php 

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <title>Paramètres</title>
</head>
<body>
    <div style="margin-left:25%;padding:1px 16px;height:100%;">
        <div class="dash-form">
        <h2 class="titre_mcd">Graphe et MCD</h2>
            <div class="slider">
                <div class="slides">
                    <div class="slide"><img src="../../IMG/param/MCD.PNG" alt=""></div>
                    <div class="slide"><img src="../../IMG/param/graphe.PNG" alt=""></div>
                    <div class="slide"><img src="../../IMG/param/gantt.PNG" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>