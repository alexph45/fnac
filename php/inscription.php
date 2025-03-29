<?php
session_start();
require_once 'connect.php';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['id_user'])) {
    header("Location: index.html");
    exit;
}

// Vérification si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['inscription'])) {
        $login = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($login) && !empty($password)) {
            try {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insérer un nouvel utilisateur dans la base de données
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, mot_de_passe) VALUES (?, ?)");
                $stmt->execute([$login, $hashed_password]);

                $_SESSION['success'] = "Inscription réussie. Vous pouvez vous connecter.";
                header("Location: connexion.php");
                exit();
            } catch (PDOException $e) {
                $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription - Société Lafleur</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/gif" href="../images/fnac.png" />
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>

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

        <form method="post" action="">
            <label for="username">Nom d'utilisateur :</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
</body>
</html>
