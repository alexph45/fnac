<?php
session_start();
require_once 'connect.php';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit;
}

$error = "";

// Vérification si le formulaire de connexion est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (!empty($login) && !empty($password)) {
        // Vérification de l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT id_user, mot_de_passe, role FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $user['role']; // Stocke le rôle dans la session

            header('Location: ../index.php');
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" type="image/gif" href="../images/fnac.png" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="connexion-container">
        <h1>Connexion</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="login">Nom d'utilisateur</label>
            <input type="text" id="login" name="login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="connexion-btn">Se connecter</button>
        </form>

        <a href="inscription.php" class="home-link">Pas de compte ? Inscription</a>
    </div>
</body>
</html>
