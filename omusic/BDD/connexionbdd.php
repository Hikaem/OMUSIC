<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <?php
function connexionBDD() {

    //$dsn='pgsql:host='.$lehost.';dbname='.$dbname;
    include("paramCon.php");
    $dsn='pgsql:host='.$lehost.';dbname='.$dbname.';port='.$leport;
    //echo $dsn."<br/>";  // pour vérif. Permet l'affichage du dsn à l'écran (avec un retour à la ligne).


    // connexion à la bdd (connexion non persistante)
    try {
        $connex = new PDO($dsn, $user, $pass); // tentative de connexion
        //$connex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$connex->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //print "Connecté :)<br />";
        
    } catch (PDOException $e) {
        print "Erreur de connexion à la base de données ! : " . $e->getMessage();
        die(); // Arrêt du script - sortie.
    }
    return $connex;
}
function deconnexionBDD($connex) {
    $connex = null;
}

?>

</body>
</html>


<!-- O'MUSIC made by Arthur & Evan / RT1-C -->