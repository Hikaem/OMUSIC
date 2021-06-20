<?php 

require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();
require_once("fonction.php");
if(!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html'); //redirection vers une page 
}

//fonction pour enregistrer un nouveau produit
if(isset($_POST['submit'])){

    $reference = htmlspecialchars($_POST['reference']); //on recupere les informations du name "reference" en le convertissant en htmlspecialchar pour eviter les injections sql
    $categorie = $_POST['categorie'];
    $fabricant = $_POST['fabricant'];
    $titre = htmlspecialchars($_POST['titre']);
    $descriptions = htmlspecialchars($_POST['descriptions']);
    $prix = htmlspecialchars($_POST['prix']);
    $stock = htmlspecialchars($_POST['stock']);
    $couleur = htmlspecialchars($_POST['couleur']);
    $poids = htmlspecialchars($_POST['poids']);

    $img1 = $_FILES['img1']['name']; 
    $temps_name1 = $_FILES['img1']['tmp_name']; //fichier temporaire où est enregistrer l'img lorsque qu'un fichier est upload

    move_uploaded_file($temps_name1,"/var/www/RT/1projet24/upload/IMG/produits/$img1");  //redirection du fichier vers le dossier de stockage des photos

    $insert_produit = $conn1->query("INSERT INTO produits (reference, refcategories, reffabricant, titre, descriptions, prix, stock, photo, couleur, poid) VALUES ('$reference','$categorie','$fabricant','$titre','$descriptions','$prix','$stock','$img1', '$couleur', '$poids')"); //insertion dans la bdd des informations rentre par l'admin
    if($insert_produit){ //si la reqûete est execute on affiche le script
        echo "<script>alert('Produit ajouté');</script>"; //pop up message
    }else{
        echo"<script>alert('Une erreur s'est produite !!');</script>"; //pop up message
}

}
//fin fonction

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Produits</title>
</head>
<body>
<div style="margin-left:25%;padding:1px 16px;">
        <div class="dash-form">
        <h1> Formulaire Produits </h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-default">
                        <div class="panel-body">
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-3">Référence du produit</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="reference" pattern="[0-9]{5}" class="form-control" placeholder="Référence produit... (5 caractères)" required>
                                    
                                    </div>  
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3">Catégorie</label>  
                                    <div class="col-md-6">
                                            <?php 
                                                $res = ListerCategorie($conn1); //appel de la fonction qui liste les clients contenue dans fonction.php
                                                $resu = $res->fetchAll(); //on liste tous les clients dans un tableau
                                                print( '<select name="categorie">'); // envoyé comme paramètre dans le formulaire
                                                foreach ($resu as $ligne) {
                                                        print( '<option value="'.$ligne["id_categories"].'">'.$ligne["nom_categories"].'</option>'); // pour créer chaque ligne de choix
                                                }
                                                print( "</select>");

                                            ?>                                    
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Fabricant</label>  
                                    <div class="col-md-6">
                                            <?php 
                                                $res = ListerFabricant($conn1); //appel de la fonction qui liste les clients contenue dans fonction.php
                                                $resu = $res->fetchAll(); //on liste tous les clients dans un tableau
                                                print( '<select name="fabricant">'); // envoyé comme paramètre dans le formulaire
                                                foreach ($resu as $ligne) {
                                                        print( '<option value="'.$ligne["id_fabricant"].'">'.$ligne["nom"].'</option>'); // pour créer chaque ligne de choix
                                                }
                                                print( "</select>");

                                            ?>                                      
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Titre du produit</label>  
                                    <div class="col-md-6">
                                        <input type="text" pattern="[a-zA-Z]{0-15}" name="titre" class="form-control" placeholder="Titre produit..." required>
                                    
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Image du produit</label>  
                                    <div class="col-md-6">
                                        <input type="file" name="img1" class="form-control" required>
                
                                    </div>  <br>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Description</label>  
                                    <div class="col-md-6">
                                        <textarea name="descriptions" placeholder="Ajouter une description à votre produit..." cols="19" rows="6"></textarea>
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Prix</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="prix" pattern="[0-9]{0-4}" placeholder="Prix produit..." class="form-control" required>
                                    
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Stock</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="stock" pattern="[0-9]{0-3}" placeholder="Quantité du produit" class="form-control" required>
                                    
                                    </div>
                                    <div class="form-group">
                                    <label class="col-md-3">Couleur</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="couleur" placeholder="Couleur du produit" class="form-control" required>
                                    
                                    </div>
                                    
                                    <div class="form-group">
                                    <label class="col-md-3">Poids</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="poids" pattern="[0-9]{0-3}" placeholder="Poids du produit" class="form-control" required>
                                    
                                    </div> <br>  
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3"></label>  
                                    <div class="col-md-6">
                                            <input type="submit" name="submit" value="Ajouter le produit" class="form-control">
                                    </div>  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>