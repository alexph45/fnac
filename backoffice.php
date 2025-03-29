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
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="fnac.png" type="image/png">
    <title>Fnac backoffice</title>
  </head>
  <body>
    <div class="container">
      <header>
          <nav>
            <ul>
              <li><a href="modifier.php">modifier</a></li>
              <li><a href="supprimer.php">supprimer</a></li>
              <li><a href="backoffice.php">Ajouter</a></li>
              <li><a href="recherche.php">recherche</a></li>
              <li><a href="index.html">connexion</a></li>
            </ul>
        </nav>
      </header>
      <h1>Ajouter un nouveaux livre</h1>
    <form method="post" action="backoffice.php">
        
        <label for="Titre">titre du livre</label>
        <input type="text" name="Titre" required><br>
        
        <label for="Auteur">nom de l'auteur</label>
        <input type="text" name="Auteur" required><br>
        
        <label for="ISBN">numéro isbn</label>
        <input type="text" name="ISBN" required><br>
        
        <label for="Prix">Prix</label>
        <input type="number" step="0.01" name="Prix" required><br>
        
        <input type="submit" value="Confirmer"><br>
        <input type="reset" value="annulez"/>
    </form>
</div>
</body>