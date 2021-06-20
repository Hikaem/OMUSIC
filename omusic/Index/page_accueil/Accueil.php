<?php

if (session_status() == PHP_SESSION_NONE) { //si les sessions sont activées, mais qu'aucune n'existe.
  session_start(); // Démarre une nouvelle session ou reprend une session existante
}
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if (isset($_SESSION['id'])) { //Affichage du nom de l'user à la place de "connexion", lorsqu'il se connecte
  $user = $_SESSION['id'];
  $request_user = $conn1->prepare('SELECT * FROM utilisateurs WHERE id_utilisateurs = ?');
  $request_user->execute(array($user));
  $userCount = $request_user->rowCount();
  $userInfo = $request_user->fetch();
}

$last_prod = "SELECT * FROM produits WHERE id_produit > (SELECT MAX(id_produit) - 3 FROM produits)";  //Selection des 3 derniers produit inserer en fonction de l'id dans la bdd
$result = $conn1->query($last_prod);  // execution de la requête. Le resultat est dans la variable $result.
$result->execute();
$resu = $result->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
      <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    
    <title>O'MUSIC</title>
</head>
<body>

<!-- NAVBAR -->
<div class="header">
		<div class="omusic"><a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/Accueil.php"><img class="logo2" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_produit/IMG/omusic-noir.png"></a></div>
		<div class="navbarre">
			<div class="accueil"><a href="/RT/1projet24/omusic/Index/page_accueil/Accueil.php">ACCUEIL</a></div>
			<div class="produit"><a href="/RT/1projet24/omusic/Index/page_produit/Produits_general.php">PRODUITS</a></div>
      <div class="contact"><a href="/RT/1projet24/omusic/Index/page_accueil/contact.php">CONTACT</a></div>
		</div>

			<?php 
			if(isset($_SESSION['id'])) { ?> <!-- Si l'user est connecté affiché, sinon -->
      <div class="move">
				<div class="client_log"><a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=2"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></a></div>
        <div class="dropdown">
        <button class="dropbtn"><?php echo $userInfo['prenom'] ; ?><i class="fas fa-sort-down"></i></button>
        <div class="dropdown-content">
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php">Mon compte</a>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=1">Mes achats</a>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=2">Mon panier</a>
          <a href='/RT/1projet24/omusic/Index/deco.php'>Se déconnecter</a>
        </div>
        </div>
        </div>
        <?php
			}else {
				echo '<div class="client"><a class="connexion" href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Members/connexion.php"> Connexion/Inscription</a></div>';
			}
			?>
	</div>


<!-- FIN NAVBAR -->

<!-- SLIDER -->
<div class="slider">
  <div class="slides">
    <!-- NAV BUTTON -->

    <input type="radio" name="radio_btn" id="radio1">
    <input type="radio" name="radio_btn" id="radio2">
    <input type="radio" name="radio_btn" id="radio3">

    <!-- FIN NAV BUTTON -->

    <!-- IMG SLIDE -->

    <div class="slide first">
      <div class="txt">
        <h1>Nous avons ce qu'il vous faut !</h1>
        <p>Découvrer maintenant notre incroyable catalogue de produit !</p>
        <button><a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_produit/Produits_general.php">VOIR</a></button>
      </div>
      <img src='images/slider/instrument_vitrine.jpg' alt="">
    </div>

    <div class="slide">
      <img src='images/slider/instrument_playing.jpg' alt="">
    </div>

    <div class="slide">
      <img src='images/slider/instrument_school.jpg' alt="">
    </div>

    <!-- FIN IMG SLIDE -->

  </div>
  <!-- MANUAL NAV -->
      <div class="nav-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
      </div>
  <!-- FIN MANUAL NAV -->
  </div>
<!-- SLIDER -->
<hr>

<!-- Last Product -->
<div class="recent-prod">
      <h1>Produits récents</h1>
    </div>
  <div class="container_prod">
    <main class="grid">
    <?php foreach ($resu as $ligne) : ?> <!-- Affichage des 3 derniers produit de la table sur la page d'accueil -->
        <article class="each_product">
          <img src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $ligne['photo'] ?>" alt="product image">
          <div class="text_prod">
            <h3><?php echo $ligne['titre'] ?></h3>
            <p><?php echo $ligne['stock'] ?> disponible(s)</p>
            <p class="price_p"><?php echo $ligne['prix'] ?>€</p>
            <button><a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_produit/Produits.php?id=<?php echo $ligne['id_produit'] ?>">VOIR</a></button>
          </div>
        </article>
      <?php endforeach ?>
    </main>
  </div>

<!-- Fin Last Product -->

<!-- Advert -->
<div class="advert">
  
  <div class="advert_first">
      <div class="text_advert1">
        <div class="contain1">
          <p>Nos collaborateurs vous garantissent des instruments d'une qualitée irréprochable ainsi qu'un prix qui défie toutes concurrences !</p>
          <button><a href="/RT/1projet24/omusic/Index/page_produit/Produits_general.php">VOIR PLUS</a></button>
          </div>
        </div>
  </div>


  <div class="advert_second">
      <div class="text_advert2">
        <div class="contain2">
          <p>Une liste importante d'instrument de musique, tous aussi impressionant les uns comme les autres, n'hésiter à les regarder !</p>
          <button><a href="/RT/1projet24/omusic/Index/page_produit/Produits_general.php">VOIR PLUS</a></button>
        </div>
      </div>
  </div>
  </div>
<!-- Fin Advert -->

<!-- Nous contacter -->
<div class="contact_us">  

    <div class="h2"> 
      <p>NOUS CONTACTER</p>
    </div>

    <div class="logo">
      <a class="social_net" target="blank" href="https://www.twitter.com"><img class="social_net" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/images/Twitter-logo-1.jpg" alt=""></a>
      <a class="social_net" target="blank" href="https://www.facebook.com"><img class="social_net" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/images/facebook-logo.png" alt=""></a>
    </div>

  </div>
<!-- FIN nous contacter -->

<!-- Footer -->
<footer id="footer" class="section footer">
    <div class="container">
      <div class="footer-container">
        <img class="logo_footer" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/images/omusic-blanc.png" alt="">  
      <div class="footer-center">
          <h3>INFORMATIONS</h3>
          <a href="#">A propos de nous</a>
          <a href="#">Conditions Général de Vente</a>
          <a href="#">Mentions légales</a>
          <a href="contact.php">Nous contacter</a>
          <a target="blank" href="https://www.google.fr/maps/place/O'Music/@45.2643101,1.7674344,18.18z/data=!4m9!1m2!2m1!1sOMUSIC!3m5!1s0x47f88c9fac48f843:0xb06df9da6adace4a!8m2!3d45.2643398!4d1.7674792!15sCgZPTVVTSUOSARhtdXNpY2FsX2luc3RydW1lbnRfc3RvcmU">Plan du site</a>
        </div>
        <div class="footer-center">
          <h3>MON COMPTE</h3>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php">Mon compte</a>
          <a href="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/PageClient.php?sec=1">Historique d'achat</a>
          <a href="https://www.amazon.fr/gp/gss/home">Newsletter</a>
          <a href="https://www.amazon.fr/gp/help/customer/display.html?nodeId=GNW5VKFXMF72FFMR">Retours</a>
        </div>
        <div class="footer-center">
          <h3>NOUS CONTACTER</h3>
          <div>
            <span>
              <i class="fas fa-map-marker-alt"></i>
            </span>
            Rue Arc en ciel, Annecy, 74000
          </div>
          <div>
            <span>
              <i class="far fa-envelope"></i>
            </span>
            omusic.projetrt@gmail.com
          </div>
          <div>
            <span>
              <i class="fas fa-phone"></i>
            </span>
            XX-XX-XX-XX-XX
          </div>
        </div>
      </div>
    </div>
    </div>
  </footer>
<!-- Fin Footer -->
</body>
<script src="JS/script.js"></script>
</html>