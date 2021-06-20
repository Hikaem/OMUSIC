<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
require_once("fonction.php");

if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html');
}

if (isset($_GET['sec'])) {
    $section_en_cours=$_GET['sec']; 
} else {
    $section_en_cours=0;	
}

$getid = $_SESSION['id'];
$requser = $conn1->prepare('SELECT * FROM admintable WHERE id_admin = ?');
$requser->execute(array($getid));
$userInfo = $requser->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Administrateur</title>
    <link rel="stylesheet" href="../CSS/style.css">
<body class="dashboard">
    <div class="section">
        <ul> <!-- Affichage des différents menu à travers une liste  -->
        <div class="info_admin">   
        <?php if(!empty($userInfo['avatar'])) { ?>
            <img class="pdp_admin" src="../../../upload/IMG/Avatar/<?php echo $userInfo['avatar']; ?>" style="border-radius: 50%; -moz-border-radius: 50%;" width="80" alt="">
            <?php } ?>
        
        <h2 align="center">Bonjour <?php echo $userInfo['pseudo']; ?> !</h2>
           
        </div> 
            <?php
                if ($section_en_cours==0) {echo '<li><a class="sec" href=>         Dashboard </a><br /></li>';} //si la section = 0 nom = Dashboard , etc...
                    else {echo '<li><a       class="sec"   href=dashboard.php?sec=0> Dashboard </a><br /></li>';} 
				if ($section_en_cours==1) {echo '<li><a class="sec" href=>          Produits </a><br /></li>';}
                        else {echo '<li><a       class="sec"   href=dashboard.php?sec=1> Produits </a><br /></li>';}
            	if ($section_en_cours==2) {echo '<li><a class="sec" href=>          Catalogue </a><br /></li>';}
                        else {echo '<li><a    class="sec"   href=dashboard.php?sec=2> Catalogue </a><br /></li>';}
            	if ($section_en_cours==3) {echo '<li><a class="sec" href=>          Clients </a><br /></li>';}
                        else {echo '<li><a    class="sec" href=dashboard.php?sec=3> Clients </a><br /></li>';}
                if ($section_en_cours==4) {echo '<li><a class="sec" href=>          Commandes </a><br /></li>';}
                        else {echo '<li><a    class="sec" href=dashboard.php?sec=4> Commandes </a><br /></li>';}
                if ($section_en_cours==5) {echo '<li><a class="sec" href=>          Graphes </a><br /></li>';}
                        else {echo '<li><a    class="sec" href=dashboard.php?sec=5> Graphes </a><br /></li>';}
                if ($section_en_cours==6) {echo '<li><a class="sec" href=>          Mon Profil </a><br /></li>';}
                        else {echo '<li><a    class="sec" href=dashboard.php?sec=6> Mon Profil </a><br /></li>';}
            ?>
            <li class="deco"><a href="/RT/1projet24/omusic/Admin/Dashboard/deconnexion.php">Se déconnecter</a></li> <!-- Bouton déconnexion -->
        </ul>
        
        <?php
        switch ($section_en_cours)  { //pour chaque section on attribut un fichier
	        case 0 : //case 0 = section 0, etc...
		        include ("navbar/accueil.php"); 
		        break;
	        case 1 :
		        include ("navbar/produits.php");
		        break;
	        case 2 :
		        include ("navbar/catalogue.php");
		        break;
            case 3 :
                include ("navbar/administration.php");
                break;
            case 4 :
                include ("navbar/commandes.php");
                break;
            case 5 :
                include ("navbar/parametre.php");
                break;
            case 6 :
                include ("../Dashboard/profil_admin/monprofil.php");
                break;
		} ?>

    </div>
</body>
</html>

<!-- O'MUSIC made by Arthur & Evan / RT1-C -->