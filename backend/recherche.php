<?php
session_start(); // Toujours démarrer la session en premier

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../php/connexion.php");
    exit();
}

// Vérifier le rôle de l'utilisateur
$user_type = $_SESSION['role'];

// Connexion à la base de données
require '../php/connect.php';

// Variables pour afficher les résultats
$results = [];
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire de recherche
    $choix = $_POST['choix'];
    $carac = $_POST['carac'];

    // Vérifier que la chaîne de recherche n'est pas vide
    if (!empty($carac)) {
        // Construire la requête en fonction du type de recherche choisi
        $sql = "SELECT * FROM livres WHERE $choix LIKE :carac";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':carac', '%' . $carac . '%'); // Ajouter les % pour une recherche partielle
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error_message = "Veuillez entrer un terme de recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/fnac.png" type="image/png">
    <title>Fnac Recherche</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php if ($user_type === 'admin'): ?>
                    <li><a href="modifier.php">Modifier</a></li>
                    <li><a href="supprimer.php">Supprimer</a></li>
                    <li><a href="backoffice.php">Ajouter</a></li>
                <?php endif; ?>
                <li><a href="recherche.php">Recherche</a></li>
                <?php if (!isset($_SESSION['id_user'])): ?>
                    <li><a href="../php/connexion.php">Connexion</a></li>
                <?php else: ?>
                    <li><a href="../php/deconnexion.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Fnac: recherche dans le catalogue</h1>
        
        <!-- Formulaire de recherche -->
        <form method="post" action="">
            <label for="choix">Choisissez un type de recherche:</label>
            <select name="choix" id="choix" required>
                <option value="Titre">Titre</option>
                <option value="Auteur">Auteur</option>
                <option value="ISBN">ISBN</option>
            </select><br>
            <label for="carac">Entrez une chaîne de caractères pour la recherche:</label>
            <input type="text" name="carac" required><br>
            <input type="submit" value="Confirmer"><br>
        </form>

        <?php if ($error_message): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Affichage des résultats de recherche -->
        <?php if (!empty($results)): ?>
            <h2>Résultats de la recherche</h2>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['ISBN']); ?></td>
                            <td><?= htmlspecialchars($book['Titre']); ?></td>
                            <td><?= htmlspecialchars($book['Auteur']); ?></td>
                            <td><?= htmlspecialchars($book['Prix']); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if ($user_type === 'admin'): ?>
            <p>Vous êtes connecté en tant qu'administrateur.</p>
        <?php elseif ($user_type === 'invite'): ?>
            <p>Vous êtes connecté en tant qu'invité.</p>
        <?php endif; ?>
    </div>
</body>
</html>
