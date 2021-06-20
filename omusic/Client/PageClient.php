<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if(!isset($_SESSION['id'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: /RT/1projet24/omusic/Index/page_accueil/Accueil.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<title>Page client</title>
</head>
<body>

	<?php
		if (isset($_GET['sec'])) {
			$section_en_cours=$_GET['sec']; 
		} else {
			$section_en_cours=0;	
		}

	?>
	<header>
		<nav class="header">
			<li class="acceuil"><a class="acceuil" href='/RT/1projet24/omusic/Index/page_accueil/Accueil.php'>Accueil</a></li>
			<li class="img"><img class="omusic" src="IMG/omusic-blanc.png"></li>
			<li class="deconnexion"><a class="deconnexion" href="deconnexion.php">Se deconnecter</a></li>
		</nav>
	</header>
	<section>
		<nav class="section">
			<h1 class="nav"><U>Espace Client :</U></h1>
			<ul>
				<?php
				if ($section_en_cours==0) {echo '<li><a class="sec" href=#>          Mes Informations </a><br /></li>';}
                        else {echo '<li><a       class="sec"   href=PageClient.php?sec=0> Mes Informations </a><br /></li>';}
            	if ($section_en_cours==1) {echo '<li><a class="sec" href=#>          Mes Commandes </a><br /></li>';}
                        else {echo '<li><a    class="sec"   href=PageClient.php?sec=1> Mes Commandes </a><br /></li>';}
            	if ($section_en_cours==2) {echo '<li><a class="sec" href=#>          Mon Panier </a><br /></li>';}
                        else {echo '<li><a    class="sec" href=PageClient.php?sec=2> Mon Panier </a><br /></li>';}
                ?>
			</ul>
		</nav>
		<div class="client">
			<?php
				switch ($section_en_cours)  {
					case 0 :
						include ("MesInformations/MesInformations.php"); 
						break;
					case 1 :
						include ("MesCommandes/MesCommandes.php");
						break;
					case 2 :
					    include ("MonPanier/MonPanier.php");
					    break;
				}
			?>
		</div>
	</section>
	
	<div class="contact_us">  

    <div class="h2"> 
      <p>NOUS CONTACTER</p>
    </div>

    <div class="logo">
      <a class="social_net" href="www.twitter.com"><img class="social_net" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/images/Twitter-logo-1.jpg" alt=""></a>
      <a class="social_net" href="www.facebook.com"><img class="social_net" src="https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Index/page_accueil/images/facebook-logo.png" alt=""></a>
    </div>

</div>

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
          <a href="#">Nous contacter</a>
          <a href="#">Plan du site</a>
        </div>
        <div class="footer-center">
          <h3>MON COMPTE</h3>
          <a href="#">Mon compte</a>
          <a href="#">Historique d'achat</a>
          <a href="#">Newsletter</a>
          <a href="#">Retours</a>
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
</body>
</html>