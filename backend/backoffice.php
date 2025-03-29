<?php
session_start(); // Toujours démarrer la session en premier

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas un administrateur
    header("Location: ../php/connexion.php");
    exit();
}

// Traitement du formulaire d'ajout de livre
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../php/connect.php';  // Connexion à la base de données

    // Récupération et nettoyage des données du formulaire
    $titre = trim($_POST['Titre']);
    $auteur = trim($_POST['Auteur']);
    $isbn = trim($_POST['ISBN']);
    $prix = trim($_POST['Prix']);

    // Vérifier que tous les champs sont remplis
    if (!empty($titre) && !empty($auteur) && !empty($isbn) && !empty($prix)) {
        try {
            // Préparer la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, isbn, prix) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titre, $auteur, $isbn, $prix]);

            $_SESSION['success'] = "Livre ajouté avec succès.";
            header("Location: backoffice.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout du livre : " . htmlspecialchars($e->getMessage());
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/fnac.png" type="image/png">
    <title>Fnac Backoffice</title>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li><a href="modifier.php">Modifier</a></li>
                    <li><a href="supprimer.php">Supprimer</a></li>
                    <li><a href="backoffice.php">Ajouter</a></li>
                    <li><a href="recherche.php">Recherche</a></li>
                    <?php if (isset($_SESSION['role'])): ?>
                        <li><a href="../php/deconnexion.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="../php/connexion.php">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <h1>Ajouter un nouveau livre</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout de livre -->
        <form method="post" action="backoffice.php">
            <label for="Titre">Titre du livre</label>
            <input type="text" name="Titre" required><br>

            <label for="Auteur">Nom de l'auteur</label>
            <input type="text" name="Auteur" required><br>

            <label for="ISBN">Numéro ISBN</label>
            <input type="text" name="ISBN" required><br>

            <label for="Prix">Prix</label>
            <input type="number" step="0.01" name="Prix" required><br>

            <input type="submit" value="Confirmer"><br>

        </form>
    </div>
</body>
</html>
