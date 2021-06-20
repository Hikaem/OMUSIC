<?php

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html');
}

$members = $conn1->query('SELECT * FROM utilisateurs');

$clientID;
$userCount;
$userInfo;
//Fonction affichage des tous les clients
if(isset($_GET['id'])){
    $clientID = $_GET['id'];
    $request_user = $conn1->prepare('SELECT * FROM utilisateurs WHERE id_utilisateurs = ?');
    $request_user->execute(array($clientID));
    $userCount = $request_user->rowCount();
    $userInfo = $request_user->fetch();
}

//Fonction de suppresion d'un client
if (isset($_POST['delete'])){
    $request = $conn1->prepare('DELETE FROM utilisateurs WHERE prenom = ?');
    $request->execute([$userInfo['prenom']]);   
    header('Location:dashboard.php?sec=3');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<div style="margin-left:25%;padding:1px 16px;">
        <div class="dash-form">
            <div class="client-form">
                <h2 align="center">Gestion Client</h2>
                <?php //Affichage dans une boucle des users (tant qu'il y a des user, on affiche)
                    while($user=$members->fetch()){ ?> <!-- boucle qui affiche tous les membres de la table -->
                    <li> <?= $user['email'] ?> - <?= $user['nom'] ?> <a href="dashboard.php?sec=3&id=<?= $user['id_utilisateurs'] ?>">Gérer</a> </li>
                <?php } ?>   
                

                <!-- Boucle qui affiche la fonction gérer les utilisateurs -->
                <?php if(isset($clientID)){   // Vérification si l'id existe, sinon affichage message compte inexistant
                    if ($userInfo == null) { echo "Ce compte n'existe pas ! ";} else { ?>
                    
                    <h3 align="center">Gérer : <?= $userInfo['prenom'] ?></h3>
                    <form class="btn" method="post" action=""> 

                    <input type="submit" name="delete" class="btn_del_user" value="Supprimer le compte" onclick="if(window.confirm('Voulez-vous vraiment supprimer ce compte ?')){return true;}else{return false;}">
                    <button class="btn_close_user"><a class="btn_close_user" href="dashboard.php?sec=3">Fermer</a></button>
                    </form>
                <?php } } ?> <br> <br>
                <button class="btn_close_user"><a class="btn_close_user" href="/RT/1projet24/omusic/Admin/Dashboard/ajout_client/add_client.php">Ajouter Client</a></button>
            </div>
        </div>
    </div>
</body>
</html>