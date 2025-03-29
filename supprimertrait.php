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
<?php
require 'sqlconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
    $selected_isbn = $_POST['choix'];
    $connection->exec('SET foreign_key_checks = 0;');
    $connection->beginTransaction();

    try {
        $stmt = $connection->prepare("DELETE FROM books WHERE isbn = ?");
        $stmt->execute([$selected_isbn]);

        $connection->commit();

        echo "Livre supprimé avec succès !";
    } catch (PDOException $e) {
        $connection->rollBack();
        echo "Erreur lors de la suppression du livre : " . $e->getMessage();
    }
} else {
    echo "Erreur : Aucun livre sélectionné.";
}
?>
