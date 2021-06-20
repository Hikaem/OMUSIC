<?php
session_start(); //Demarrage de la session
session_destroy(); //Destruction et fermeture de la session
header("Location: ../admin.php"); //redirection
?>