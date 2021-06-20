<?php
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();  
require_once("/var/www/RT/1projet24/omusic/Members/mdp_oublie/resetMdp.php");


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réinitialisation mot de passe | O'Music</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if(isset($error)){  ?>
  <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $error; ?> </div>
  <?php } ?>


  <form method="post" class="reset-form">
      <h1>Demander une réinitialisation de mot de passe</h1>
      <p>Un email va vous être envoyez avec les instructions pour mettre à niveau votre mot de passe.</p>
    <?php if($section == "code"){ ?>  <!-- Si la section "code" est dans l'url, affichage du contenue relatif à "code" -->
    
    Récuperation de mot de passe pour <?= $_SESSION['recup_email'] ?> <br>
    <form method="post" >
      <label>Code de vérification : <input type="text" name="verif_code" value="" /></label>
      <button class="btn btn-primary btn-block" type="submit" name="verif_submit">Vérifier</button>
    </form>
    
    <?php } elseif($section == "mdpform") { ?> <!-- Si la section "mdpform" est dans l'url, affichage du contenue relatif à "mdpform" -->
      
      Nouveau de mot de passe pour <?= $_SESSION['recup_email'] ?> <br> <br>
      <form method="post" > 
      <label>Mot de passe : <input type="password" name="change_mdp" value="" /></label><br>
      <label>Confirmation du mot de passe : <input type="password" name="change_mdpc" value="" /></label><br>
      <button class="btn btn-primary btn-block" type="submit" name="change_submit">Enregistrer</button>
      </form>
    
    <?php }else {?> <!-- Si aucune section affichage de la page principal pour entrer son mail de recup -->
    
    <form method="post">
      <label>Votre adresse email : <input type="email" name="recup_email" value="" /></label>
      <button class="btn btn-primary btn-block" type="submit" name="recup_submit">Envoyer la demande</button>
      <button id="btn_mdp_btn" class="btn btn-primary btn-block" type="submit"><a class="reset_mdp_a" href="../connexion.php"> Retour a la page connexion</a></button>
    </form>
    <?php } ?>
  </form>
<script src="/RT/1projet24/omusic/Members/JS/script.js"></script>
</body>
</html>
