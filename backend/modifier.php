<?php
session_start(); // Toujours démarrer la session en premier
// Vérifier le rôle de l'utilisateur
$user_type = $_SESSION['role'];
// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../php/connexion.php");
    exit();
}

require '../php/connect.php'; // Connexion à la base de données

$error = "";
$success = "";
$book = null;

// Récupérer les détails du livre sélectionné
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
    $isbn = trim($_POST['choix']);
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE ISBN = ?");
    $stmt->execute([$isbn]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Mettre à jour les informations du livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $isbn = trim($_POST['ISBN']);
    $titre = trim($_POST['Titre']);
    $auteur = trim($_POST['Auteur']);
    $prix = trim($_POST['Prix']);

    if (!empty($titre) && !empty($auteur) && is_numeric($prix)) {
        try {
            $stmt = $pdo->prepare("UPDATE livres SET Titre = ?, Auteur = ?, Prix = ? WHERE ISBN = ?");
            $stmt->execute([$titre, $auteur, $prix, $isbn]);
            $success = "Livre mis à jour avec succès.";

            // Récupérer les nouvelles informations du livre
            $stmt = $pdo->prepare("SELECT * FROM livres WHERE ISBN = ?");
            $stmt->execute([$isbn]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/fnac.png" type="image/png">
    <title>Fnac modifier</title>
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

        <h1>Modifier un livre</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="choix">Sélectionnez un livre à modifier :</label>
            <select id="choix" name="choix">
                <?php
                $result = $pdo->query("SELECT ISBN, Titre FROM livres");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($row['ISBN']) . "'>" . htmlspecialchars($row['Titre']) . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Sélectionner" name="select">
        </form>

        <?php if ($book): ?>
            <form method="post" action="">
                <input type="hidden" name="ISBN" value="<?= htmlspecialchars($book['ISBN']); ?>">

                <label for="Titre">Titre du livre :</label>
                <input type="text" name="Titre" id="Titre" value="<?= htmlspecialchars($book['Titre']); ?>" required>

                <label for="Auteur">Nom de l'auteur :</label>
                <input type="text" name="Auteur" id="Auteur" value="<?= htmlspecialchars($book['Auteur']); ?>" required>

                <label for="Prix">Prix :</label>
                <input type="number" step="0.01" name="Prix" id="Prix" value="<?= htmlspecialchars($book['Prix']); ?>" required>

                <input type="submit" value="Mettre à jour" name="update">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
