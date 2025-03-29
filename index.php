<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: php/connexion.php");
    exit;
}

// Vérification du rôle de l'utilisateur
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Redirection en fonction du rôle
    switch ($role) {
        case 'admin':
            header("Location: backend/backoffice.php");
            exit;
        case 'invite':
            header("Location: backend/recherche.php");
            exit;
        default:
            // Si le rôle n'est ni admin ni invite, vous pouvez rediriger vers une page par défaut ou afficher une erreur
            header("Location: php/connexion.php");
            exit;
    }
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur la page d'accueil</h1>
        <p>Vous êtes connecté en tant que <?= htmlspecialchars($_SESSION['login']); ?>.</p>
    </div>
</body>
</html>
