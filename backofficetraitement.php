<?php
session_start(); // Toujours démarrer la session en premier

// Vérifier si l'utilisateur est connecté en tant qu'admin
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
    // L'utilisateur est un administrateur, autoriser l'accès au script de traitement
} else {
    // Rediriger vers une page d'erreur ou une autre page appropriée
    header("Location: index.html");
    exit();
}
?>
?>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="fnac.png" type="image/png">
    <title>Fnac front</title>
  </head>
  <body>
  <div class="container">
  
<?php

require 'sqlconnect.php';

$Titre = $_REQUEST["Titre"];
$Auteur =$_REQUEST["Auteur"];
$ISBN = $_REQUEST["ISBN"];
$Prix = $_REQUEST['Prix'];

$sql = $connection->prepare("INSERT INTO books VALUES('$ISBN', '$Auteur', '$Titre', '$Prix')");
$sql->execute();

?>
</div>
</body>
</html>

