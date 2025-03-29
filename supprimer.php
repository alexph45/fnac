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
        <h1>supprimer un livre</h1>

        <form method="post" action="supprimertrans.php">
            <label for="choix">Sélectionnez un livre à modifier:</label>
            <select id="choix" name="choix">
                <?php
              
                require 'sqlconnect.php';

                $result = $connection->query("SELECT isbn, title FROM books");

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['isbn']}'>{$row['title']}</option>";
                }
                ?>
            </select>
            
            <input type="submit" value="supprimer">
            <input type="reset" value="Annuler"/>
        </form>
    </div>
</body>
</html>
