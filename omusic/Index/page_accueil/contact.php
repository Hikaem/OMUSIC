<?php 
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
ini_set('display_errors', 'off'); 

if (isset($_POST['envoi'])){
        $email_expediteur = htmlspecialchars($_POST['email']);
        $nom_expediteur = htmlspecialchars($_POST['nom']);
        $destinataire = 'omusic.projetrt@gmail.com';
    
        $message_envoye = "Votre message nous est bien parvenu !";
        $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
    
        $message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
    
        $nom     = (isset($_POST['nom']));
        $email   = (isset($_POST['email']));
        $objet  =(isset($_POST['objet']));
        $message =(isset($_POST['message']));
	if (($nom != '') && ($email != '') && ($objet != '') && ($message != '')){
        if(filter_var($email_expediteur, FILTER_VALIDATE_EMAIL)){
            $headers = 'From:'.$nom_expediteur.' <'.$email_expediteur.'>' . "\r\n" .
            $headers .= 'Reply-To:'.$email. "\r\n" .
            $headers .= "MIME-version: 1.0\r\n";  
            $headers .= "Content-type: text/html; charset=utf-8";
            $headers .='Content-Transfer-Encoding: 8bit';
    
            $objet = html_entity_decode($_POST['objet']);

            $message = html_entity_decode($_POST['message']);

            if (mail($destinataire, $objet, $message, $headers)){  //si le mail contient tous les elements il s'execute sinon erreur
                    echo "<script>alert('Mail envoyé');</script>"; //pop up message
                }else{
                    echo"<script>alert('Une erreur s'est produite !!');</script>"; //pop up message
            }               
        }else{
            echo "<script>alert('Merci de rentrer un mail valide');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <title>Contact</title>
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
        <button class="dropbtn"><?php echo $_SESSION['prenom'] ; ?><i class="fas fa-sort-down"></i></button>
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

<div class="container_form_contact">
    <h1>Formulaire de contact</h1> <br>
  <form method="post">
    <div class="row">
      <div class="col-25">
        <label for="fname">Nom</label>
      </div>
      <div class="col-75">
        <input type="text" id="fname" name="nom" placeholder="nom...">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Email</label>
      </div>
      <div class="col-75">
        <input type="mail" id="lname" name="email" placeholder="email...">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Objet</label>
      </div>
      <div class="col-75">
        <input type="text" id="lname" name="objet" placeholder="objet...">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="subject">Message</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="message" placeholder="votre message..." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" name="envoi" value="Envoyer">
    </div>
  </form>
</div>


<!-- Footer -->
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
</html>