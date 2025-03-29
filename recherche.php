<?php
session_start(); // Toujours démarrer la session en premier

// Vérifier si l'utilisateur est connecté en tant qu'admin ou invité
if(isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
    
    // Vous pouvez utiliser $user_type pour personnaliser le contenu en fonction du type d'utilisateur
    if($user_type === 'admin') {
      echo '<!DOCTYPE html>
      <html lang="fr">
        <head>
          <meta charset="UTF-8">
          <link rel="stylesheet" href="style.css">
          <link rel="icon" href="fnac.png" type="image/png">
          <title>Fnac front</title>
        </head>
        <body>
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
          <div class="container">
          <h1>Fnac: recherche dans le catalogue</h1>
          <form method="post" action="traitement.php">
              
            <label for="choix">Choisissez un type de recherche: </label>
              <select name="choix" id="choix" required>
                  <option value="Titre">Titre</option>
                  <option value="Auteur">Auteur</option>
                  <option value="ISBN">ISBN</option>
              </select><br>
              <label for="carac">Entrez une chaîne de caractère pour la recherche:</label>
              <input type="text" name="carac" required><br>
              <input type="submit" value="Confirmer"><br>
              <input type="reset" value="annulez"/>
          </form>
      </div>
      </body>';
    } elseif($user_type === 'invite') {
      echo '<!DOCTYPE html>
      <html lang="fr">
        <head>
          <meta charset="UTF-8">
          <link rel="stylesheet" href="style.css">
          <link rel="icon" href="fnac.png" type="image/png">
          <title>Fnac front</title>
        </head>
        <body>
          <header>
                <nav>
                  <ul>
                    <li><a href="recherche.php">recherche</a></li>
                    <li><a href="index.html">connexion</a></li>
                  </ul>
              </nav>
            </header>
          <div class="container">
          <h1>Fnac: recherche dans le catalogue</h1>
          <form method="post" action="traitement.php">
              
            <label for="choix">Choisissez un type de recherche: </label>
              <select name="choix" id="choix" required>
                  <option value="Titre">Titre</option>
                  <option value="Auteur">Auteur</option>
                  <option value="ISBN">ISBN</option>
              </select><br>
              <label for="carac">Entrez une chaîne de caractère pour la recherche:</label>
              <input type="text" name="carac" required><br>
              <input type="submit" value="Confirmer"><br>
              <input type="reset" value="annulez"/>
          </form>
      </div>
      </body>';
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.html");
    exit();
}
?>
<?php if($user_type === 'admin'): ?>
        <p>Vous êtes connecté en tant qu'administrateur.</p>
    <?php elseif($user_type === 'invite'): ?>
        <p>Vous êtes connecté en tant qu'invité.</p>
    <?php endif; ?>
