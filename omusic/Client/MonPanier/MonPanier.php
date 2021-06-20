<?php

if(session_status() == PHP_SESSION_NONE){ //si la session n'est pas lancée alors on créer une session
	session_start();
}

if(!isset($_SESSION['id'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: /RT/1projet24/omusic/Index/page_accueil/Accueil.php');
}

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");//connexion a la bdd
$conn1=connexionBDD();

			
if(isset($_POST['submit'])){
	$delete = $conn1->prepare('DELETE FROM panier WHERE refutilisateurs = ? AND refproduit = ?');  // suppression des articles
	$delete->execute([$_SESSION['id'], $_POST['panier_id']]);
}


$req = $conn1->prepare('SELECT * FROM produits INNER JOIN panier ON produits.id_produit=panier.refproduit WHERE refutilisateurs = ?;');  
$req->execute([ $_SESSION['id']]); 

$req=$req->fetchAll();

$montant = 0; 

$userID = $_SESSION['id'];
$mail = $conn1->prepare("SELECT email FROM utilisateurs WHERE id_utilisateurs = ?");
$mail->execute(array($userID));
$mailInfo = $mail->fetch();



?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon Panier</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1 class="panier_h1">Mon Panier</h1>
	<div class="bac_article">
		<div class="panier_header">
			<div class="panier_article">Article</div>
			<div class="panier_quantite">Quantité</div>
			<div class="panier_montant"> Montant</div>
		</div>
		
		<?php

		foreach ($req as $panier) {

		?>
				<div class="panier_body">
					<form method="POST" class="panier" enctype="multipart/form-data">
						<input type="hidden" name="panier_id" value="<?= $panier['refproduit'] ?>">
						<div class="body_article">
							<div class="img"><img class="produit" src="https://srv-prj-new.iut-acy.local/RT/1projet24/upload/IMG/produits/<?= $panier['photo'] ?>"></div>
							<div class="description">
								<div class="panier_titre" name="titre"><?= $panier['titre'] ?></div>
								<div class="panier_stock" name="stock">Stock: <?= $panier['stock'] ?></div>
								
								<div class="supprimer">
									<button type="submit" name="submit" class="panier_button">Supprimer
								</button>
								</div>
							</div>
						</div>
						<div class="quantite"><?= $panier['quantite'] ?></div>
						<div class="panier_prix"><?= $panier['prix'] ?> €</div>
				</div>
				<?php $montant = $montant + $panier['prix']; ?>
				<input type="hidden" name="montant_total" value="<?=$montant?>">
				</form>
		<?php }?>
		<form class="commander" method="POST">	
			<div class="panier_footer">
				<div class="montant_total" name="montant_total">Montant total : <?= $montant ?>€</div>
			</div>
	
	</div>
	 <?php if($montant != 0) { 
		echo'<div class="commander">
			<button type="submit" name="commander" class="panier_button_commander">COMMANDER</button>
			</div>
			</form>';

	} else{ 
		echo'<div class="vide">Votre panier est vide !</div>';
	}?>

<?php
if (isset($_POST['commander'])) {
	
	
	$commande = $conn1->prepare('INSERT INTO commandes (refutilisateurs, prix_total) VALUES (?, ?) RETURNING id_commande ;');
	$commande->execute([$_SESSION['id'], $montant]);
	$commande=$commande->fetch();
	$id_commande = $commande['id_commande'];
	
	$req = $conn1->prepare('SELECT * FROM produits INNER JOIN panier ON produits.id_produit=panier.refproduit WHERE refutilisateurs = ?;');  
	$req->execute([ $_SESSION['id']]); 
	$req=$req->fetchAll();

	$destinataire = $mailInfo;
  
                $headers = "From: O'MUSIC <no-reply@omusic.net>\r\n";
                $headers .= "MIME-version: 1.0\r\n";  
                $headers .= "Content-type: text/html; charset=utf-8";
                $headers .='Content-Transfer-Encoding: 8bit';
                
                $sujet = "Merci de votre achat !";
                
                $message = '<html>
                <head>
                  <title>Merci de votre achat - O\'MUSIC</title>
                  <meta charset="utf-8" />
                </head>
                <body>
                  <font color="#303030";>
                    <div align="center">
                      <table width="600px">
                        <tr>
                          <td>
                            
                            <div align="center"> <h1>Bonjour,</h1></div>
                            <p align="center">Nous vous remercions de votre récent achat effectuée sur O\'MUSIC. <br> Votre commande sera pris en charge dans les plus bref délais.
							<br>Merci de venir récuperer le colis à notre dépot.</p>
                            <br>
                            <p align="center"> A bientôt sur <a href="#">O\'MUSIC</a> !</p>
                            
                          </td>
                        </tr>
                        <tr>
                          <td align="center">
                            <font size="2">
                              Ceci est un email automatique, merci de ne pas y répondre
                            </font>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </font>
                </body>
                </html>';
				//implode sert à rassembler les élements d'un tableau dans un string (mail stocké dans une array, donc obligé de implode)
				// \r : retour chariot (hex 0D) ; \n : nouvelle ligne (hex 0A)
                if( mail(implode("\r\n", $destinataire), $sujet, $message, $headers) ){  //si le mail contient tous les elements il s'execute sinon erreur
                    echo 'Merci de regarder votre boite mail!';
                } else{ 
                        echo 'une erreur est survenu lors de l\'envoi du message';
                    }

	foreach($req as $panier){

		$commander = $conn1->prepare('INSERT INTO commander (refcommande, refproduit) VALUES (?, ?);');
		$commander->execute([$id_commande, $panier['refproduit']]);

		$stock = $panier['stock'] - 1;
		$soustraire = $conn1->prepare('UPDATE produits SET stock = ? WHERE id_produit = ? ;');
		$soustraire->execute([$stock, $panier['id_produit']]);

		$delete = $conn1->prepare('DELETE FROM panier WHERE refutilisateurs = ? AND refproduit = ?;');  // suppression des articles
		$delete->execute([$_SESSION['id'], $panier['refproduit']]);	
		}
		if($commande){
			echo "<script>alert('Merci de votre achat ! Merci de verifier vos mail');</script>";
		}else{
			echo"<script>alert('Une erreur s'est produite !!');</script>";
		}

header('Location: https://srv-prj-new.iut-acy.local/RT/1projet24/omusic/Client/MonPanier/commander/commander.php');
}
?>
</body>
</html>