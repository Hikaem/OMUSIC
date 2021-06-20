<?php
function ListerClients($connex)
{
   // permet de lister les clients
   $sql = "SELECT * FROM utilisateurs;";                           // déclaration de la variable appelee $sql.
   $result = $connex->query($sql);             // execution de la requête. Le resultat est dans la variable $res.
   return $result;                        // retourne a l'appelant le resultat.
}

function ListerCategorie($connex) //Listing des catégories
{
   $sql = "SELECT * FROM categories";
   $result = $connex->query($sql);
   return $result;
}

function ListerFabricant($connex) //Listing des clients
{
   $sql = "SELECT * FROM fabricant";
   $result = $connex->query($sql);
   return $result;
}

function modifProduit($N_reference, $N_categorie, $N_fabricant, $N_titre, $N_descriptions, $N_prix, $N_stock, $img2, $N_couleur, $N_poids, $id, $connex) //Modification d'un produit
{
   $sql = "UPDATE produits SET reference = ? , refcategories = ?, reffabricant = ?, titre = ?, descriptions = ?, prix = ?, stock = ?, photo = ?, couleur = ?, poid = ? WHERE id_produit = ?";
   $request = $connex->prepare($sql);
   $request->execute(
      [
         $N_reference, $N_categorie, $N_fabricant, $N_titre, $N_descriptions, $N_prix, $N_stock, $img2, $N_couleur, $N_poids, $id
      ]
   );
}

function ListerEtat($connex) //Listing des états
{
   $sql = "SELECT * FROM etat";
   $result = $connex->query($sql);
   return $result;
}
