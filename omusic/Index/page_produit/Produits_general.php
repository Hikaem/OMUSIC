<?php
session_start();
require_once("/var/www/RT/1projet24/omusic/BDD/paramCon.php");
require_once("/var/www/RT/1projet24/omusic/BDD/connexionbdd.php");
$conn1=connexionBDD();

if (isset($_GET['sec'])) {
			$section_en_cours=$_GET['sec']; 
		} else {
			$section_en_cours=0;	
		}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Produits</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>
<body>
	<?php include("header/header.php"); ?>
	<div class="body_general">
		<div class="categorie_instrument">
			<h1>CATEGORIE : </h1>
			<ul>
		<?php
	            	if ($section_en_cours==1) {echo '<li><a class="sec" href=#>          Percussion </a><br /></li>';}
	                        else {echo '<li><a    class="sec"   href=Produits_general.php?sec=1> Percussion </a><br /></li>';}
	            	if ($section_en_cours==2) {echo '<li><a class="sec" href=#>         Cuivre </a><br /></li>';}
	                        else {echo '<li><a    class="sec" href=Produits_general.php?sec=2> Cuivre </a><br /></li>';}
	                if ($section_en_cours==3) {echo '<li><a class="sec" href=#>         Cordes </a><br /></li>';}
	                        else {echo '<li><a    class="sec" href=Produits_general.php?sec=3> Cordes </a><br /></li>';}
	                if ($section_en_cours==4) {echo '<li><a class="sec" href=#>         Piano </a><br /></li>';}
	                        else {echo '<li><a    class="sec" href=Produits_general.php?sec=4> Piano </a><br /></li>';}
	    	?>
	    		</ul>
	    	</div>
	   	 <div class="instrument"> 
	    	<?php
					switch ($section_en_cours)  {
						case 0 :
							include ("Categorie/Categorie.php"); 
							break;
						case 1 :
							include ("Categorie/Percussion/Percussion.php");
							break;
						case 2 :
						    include ("Categorie/Cuivre/Cuivre.php");
						    break;
						case 3 :
						    include ("Categorie/Corde/Corde.php");
						    break;
						case 4 :
						    include ("Categorie/Piano/Piano.php");
						    break;
					}
			?>
	   	 </div>
	</div>
    <div class="footer">
		<?php include("footer/footer.php"); ?>
	</div>
</body>
</html>