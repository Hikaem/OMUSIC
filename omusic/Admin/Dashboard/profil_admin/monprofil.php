<?php

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: ../troll.html');
}

$getid = $_SESSION['id'];
$requser = $conn1->prepare('SELECT * FROM admintable WHERE id_admin = ?');
$requser->execute(array($getid));
$userInfo = $requser->fetch();

//upload d'une photo de profil
if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {

    $id = $_SESSION['pseudo'];
    $tailleMax = 2097152; //max size pour la pdp 2Mo
    $extensionsValides = array('jpg', 'jpeg', 'png'); //on définie les extensions valide
    if($_FILES['avatar']['size'] <= $tailleMax) { 

       $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1)); //substr — Retourne un segment de chaîne ; strrchr — Trouve la dernière occurrence d'un caractère dans une chaîne
       if(in_array($extensionUpload, $extensionsValides)) {

        $avatar = $_FILES['avatar']['name'];  //definition de l'image 
        $temps_name2 = $_FILES['avatar']['tmp_name']; //definition du fichier temporaire où est stocké l'image à l'upload
          $chemin = "/var/www/RT/1projet24/upload/IMG/Avatar/".$_SESSION['id'].".".$extensionUpload; //definition du chemin + definition du nom
          $resultat = move_uploaded_file($temps_name2, $chemin); //deplacement de l'image du fichier tmp vers le dossier final
          
          if($resultat) {

             $updateavatar = $conn1->prepare('UPDATE admintable SET avatar = :avatar WHERE id_admin = :id'); //insertion dans la BDD
             $updateavatar->execute(array(
                'avatar' => $_SESSION['id'].".".$extensionUpload,
                'id' => $_SESSION['id']
                ));
          } else {
             $msg = "Erreur durant l'importation de votre photo de profil";
          }
       } else {
          $msg = "Votre photo de profil doit être au format jpg, jpeg ou png";
       }
    } else {
       $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
    }
 }
 
 
 //Modification du pseudo avec verif du mdp
if(!empty($_POST)){
$mdp = htmlspecialchars($_POST['mdp']);
$pwd = $userInfo['mdp'];

if(password_verify($mdp, $pwd)){
        if(isset($_POST['pseudo']) AND !empty($_POST['pseudo'])){
                $id=$_SESSION['id'];
                $pseudo = htmlspecialchars($_POST['pseudo']);
                    
                    $sql = "UPDATE admintable SET pseudo = ? WHERE id_admin = ?";
                    $request = $conn1->prepare($sql);
                    $request->execute([$pseudo, $id]);
        }
}else{
    $msg= "mauvais mot de passe";
}
}

//Modification de l'email avec verif du mdp
if(!empty($_POST)){ 
$mdp = htmlspecialchars($_POST['mdp']);
$pwd = $userInfo['mdp'];

if(password_verify($mdp, $pwd)){
if(isset($_POST['email']) AND !empty($_POST['email'])){
    $id=$_SESSION['id'];
    $email = htmlspecialchars($_POST['email']);
        
        $sql = "UPDATE admintable SET email = ? WHERE id_admin = ?";
        $request = $conn1->prepare($sql);
        $request->execute([$email, $id]);
}else{
    $msg ="mauvais mot de passe";
}
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <title>Mon Profil</title>
</head>
<body>
    <div style="margin-left:25%;padding:1px 16px;">
        <div class="dash-form">
            <h1>Mon Profil :</h1>
            <form method="post" enctype="multipart/form-data">
                <label for="">Pseudo</label>
                <input type="text" name="pseudo" value="<?php echo $userInfo['pseudo'] ?>"> <br> <br>
                <label for="">Email</label>
                <input type="text" name="email" value="<?php echo $userInfo['email'] ?>"> <br> <br>
                <label for="">Avatar : </label>
                <input type="file" name="avatar"> <br> <br> <br>
                <label for="">Mot de passe</label>
                <input type="password" name="mdp" placeholder="mot de passe"> <br>
                <input type="submit" value="Mettre à jour">
                <?php if(isset($msg)){
                    echo $msg;
                } ?>
            </form>
        </div>
    </div>
</body>
</html>