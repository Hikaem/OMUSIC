<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1 = connexionBDD();
require_once("../fonction.php");
if (!isset($_SESSION['pseudo'])) {  //Si l'user tente de d'acceder via l'url à la page, sans être log, il sera renvoyé a la page de connexion
    header('Location: troll.html'); //redirection vers une page 
}

if (!empty($_POST) && isset($_POST['submit'])) { //Si l'user selectionne le bouton submit execution de la tâche on attribue les variables qu'il a rentré

    $id = $_GET['id_produit']; //recuperation de l'id du produit dans l'url
    $N_reference = htmlspecialchars($_POST['N_reference']);
    $N_categorie = $_POST['categorie'];
    $N_fabricant = $_POST['fabricant'];
    $N_titre = htmlspecialchars($_POST['N_titre']);
    $N_descriptions = htmlspecialchars($_POST['N_descriptions']);
    $N_prix = htmlspecialchars($_POST['N_prix']);
    $N_stock = htmlspecialchars($_POST['N_stock']);
    $N_couleur = htmlspecialchars($_POST['N_couleur']);
    $N_poids = htmlspecialchars($_POST['N_poids']);

    $img2 = $_FILES['img2']['name'];
    $temps_name1 = $_FILES['img2']['tmp_name']; //fichier temporaire où est enregistrer lorsque qu'un fichier est upload
    move_uploaded_file($temps_name1, "/var/www/RT/1projet24/upload/IMG/produits/$img2");  //redirection du fichier vers le dossier de stockage des photos

    $req = modifProduit($N_reference, $N_categorie, $N_fabricant, $N_titre, $N_descriptions, $N_prix, $N_stock, $img2, $N_couleur, $N_poids, $id, $conn1);

    if ($req == true) {
        echo "<script>alert('Produit modifié');</script>"; //pop up message
    } else {
        echo "<script>alert('Une erreur s'est produite !!');</script>";
    } //pop up message
}

$productID = $_GET['id_produit'];
$request_product = $conn1->prepare('SELECT * FROM produits WHERE id_produit = ?');
$request_product->execute(array($productID));
$productCount = $request_product->rowCount();
$productInfo = $request_product->fetch();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <title>Modification</title>
</head>

<body class="modif_prod">
    <div class="dash-form">
        <h1> Modification Produits </h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-default">
                    <div class="panel-body">
                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3">Référence du produit</label>
                                <div class="col-md-6">
                                    <input type="text" name="N_reference" pattern="[0-9]{5}" class="form-control" value="<?= $productInfo['reference'] ?>" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Catégorie</label>
                                <div class="col-md-6">
                                    <?php
                                    $res = ListerCategorie($conn1); //appel de la fonction qui liste les clients contenue dans fonction.php
                                    $resu = $res->fetchAll(); //on liste tous les clients dans un tableau
                                    print('<select name="categorie">'); // envoyé comme paramètre dans le formulaire
                                    foreach ($resu as $ligne) {
                                        print('<option value="' . $ligne["id_categories"] . '">' . $ligne["nom_categories"] . '</option>'); // pour créer chaque ligne de choix
                                    }
                                    print("</select>");

                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Fabricant</label>
                                <div class="col-md-6">
                                    <?php
                                    $res = ListerFabricant($conn1); //appel de la fonction qui liste les clients contenue dans fonction.php
                                    $resu = $res->fetchAll(); //on liste tous les clients dans un tableau
                                    print('<select name="fabricant">'); // envoyé comme paramètre dans le formulaire
                                    foreach ($resu as $ligne) {
                                        print('<option value="' . $ligne["id_fabricant"] . '">' . $ligne["nom"] . '</option>'); // pour créer chaque ligne de choix
                                    }
                                    print("</select>");

                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Titre du produit</label>
                                <div class="col-md-6">
                                    <input type="text" pattern="[a-zA-Z]{0-15}" name="N_titre" class="form-control" value="<?= $productInfo['titre'] ?>" required>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Image du produit</label>
                                <div class="col-md-6">
                                    <input type="file" name="img2" class="form-control" required>

                                </div> <br>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Description</label>
                                <div class="col-md-6">
                                    <textarea name="N_descriptions" placeholder="<?= $productInfo['descriptions'] ?>" cols="19" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Prix</label>
                                <div class="col-md-6">
                                    <input type="text" name="N_prix" pattern="[0-9]{0-4}" value="<?= $productInfo['prix'] ?>" class="form-control" required>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">Stock</label>
                                <div class="col-md-6">
                                    <input type="text" name="N_stock" pattern="[0-9]{0-3}" value="<?= $productInfo['stock'] ?>" class="form-control" required>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Couleur</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="N_couleur" value="<?= $productInfo['couleur'] ?>" class="form-control" required>
                                    
                                    </div>
                                    
                                    <div class="form-group">
                                    <label class="col-md-3">Poids</label>  
                                    <div class="col-md-6">
                                        <input type="text" name="N_poids" pattern="[0-9]{0-3}" value="<?= $productInfo['poid'] ?>" class="form-control" required>
                                    
                                    </div> <br>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3"></label>
                                <div class="col-md-6">
                                    <input type="submit" name="submit" value="Enregistrer" class="form-control">
                                </div>
                            </div>
                            
                        </form>
                        <button type="annuler" name="annuler" class="annuler_modif"><a href="/RT/1projet24/omusic/Admin/Dashboard/dashboard.php?sec=2">Annuler</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>