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
    <title>Infos Livre</title>
</head>
<body>
    <div class="container">
        <header>
            <!-- Insérez votre en-tête si nécessaire -->
        </header>

        <h1>Informations sur le livre</h1>

        <?php
        if (isset($_POST['choix'])) {
            $isbn = $_POST['choix'];

            // Récupérez les informations du livre à partir de la base de données
            require 'sqlconnect.php';

            $stmt = $connection->prepare("SELECT * FROM books WHERE isbn = :isbn");
            $stmt->bindParam(':isbn', $isbn);
            $stmt->execute();

            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                // Affichez les informations du livre
                echo "<p>ISBN: {$book['isbn']}</p>";
                echo "<p>Titre: {$book['title']}</p>";
                echo "<p>Auteur: {$book['author']}</p>";
                echo "<p>Prix: {$book['price']}</p>";
                // Ajoutez d'autres champs selon votre structure de base de données
                echo "<form method='post' action='supprimertrait.php'>";
                echo "<input type='hidden' name='choix' value='" . $book['isbn'] . "'>";
                echo"<input type='submit' value='Supprimer le livre'>";
                echo"</form>";

                echo "</form>";
            } else {
                echo "<p>Livre non trouvé.</p>";
            }
        } else {
            echo "<p>Aucun livre sélectionné.</p>";
        }
        ?>

        <!-- Ajoutez des liens de navigation ou d'autres éléments au besoin -->

    </div>
</body>
</html>
