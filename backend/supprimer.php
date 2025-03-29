<?php
session_start(); // Toujours démarrer la session en premier
// Vérifier le rôle de l'utilisateur
$user_type = $_SESSION['role'];
// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require '../php/connect.php'; // Assurez-vous que ce fichier contient une connexion PDO sous le nom $pdo

$message = "";

// Traitement de la suppression si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['choix'])) {
    $isbn = $_POST['choix'];

    // Vérifier si l'ISBN existe avant la suppression
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE ISBN = :isbn");
    $stmt->bindParam(':isbn', $isbn);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // L'ISBN existe, suppression possible
        $stmt = $pdo->prepare("DELETE FROM livres WHERE ISBN = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        
        if ($stmt->execute()) {
            $message = "Livre supprimé avec succès.";
        } else {
            $message = "Erreur lors de la suppression du livre.";
        }
    } else {
        $message = "Erreur : ISBN introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/fnac.png" type="image/png">
    <title>Fnac supprimer</title>
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
        <h1>Supprimer un livre</h1>

        <?php if (!empty($message)) : ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="choix">Sélectionnez un livre à supprimer :</label>
            <select id="choix" name="choix" required>
                <?php
                // Récupérer les livres
                $stmt = $pdo->query("SELECT ISBN, Titre FROM livres");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='".htmlspecialchars($row['ISBN'])."'>".htmlspecialchars($row['Titre'])."</option>";
                }
                ?>
            </select>

            <input type="submit" value="Supprimer">
        
        </form>
    </div>
</body>
</html>
