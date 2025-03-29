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
<?php if($user_type === 'admin'): ?>
        <p>Vous êtes connecté en tant qu'administrateur.</p>
    <?php elseif($user_type === 'invite'): ?>
        <p>Vous êtes connecté en tant qu'invité.</p>
    <?php endif; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="fnac.png" type="image/png">
    <title>Fnac backoffice - Afficher un livre</title>
</head>
<body>
    <div class="container">
        <header>
            <!-- Votre navigation ici -->
        </header>
        <h1>Modifier un livre</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choix'])) {
        $isbn = $_POST['choix'];

        // Récupérer les informations du livre depuis la base de données
        require 'sqlconnect.php';

        $stmt = $connection->prepare("SELECT * FROM books WHERE isbn = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($livre) {
            // Afficher toutes les informations du livre dans des champs modifiables
            echo "<form method='post' action='modifiertrait.php'>";
            echo "<input type='hidden' name='isbn' value='{$livre['isbn']}'>";

            echo "<label for='title'>Titre:</label>";
            echo "<input type='text' id='title' name='title' value='{$livre['title']}'><br>";

            echo "<label for='auteur'>Auteur:</label>";
            echo "<input type='text' id='auteur' name='auteur' value='{$livre['author']}'><br>";

            echo "<label for='prix'>Prix:</label>";
            echo "<input type='text' id='prix' name='prix' value='{$livre['price']}'><br>";

            // Ajoutez d'autres champs pour les autres informations du livre

            echo "<input type='submit' value='Enregistrer les modifications'>";
            echo "</form>";
        } else {
            echo "Livre non trouvé.";
        }
    } else {
        echo "Erreur : Le champ 'choix' n'est pas défini.";
    }
} else {
    echo "Erreur de requête.";
}
?>
</body>
</html>