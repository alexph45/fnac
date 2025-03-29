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

// Vérifier si la clé 'isbn' existe dans les données de la requête POST
if (isset($_POST['isbn'])) {
    // Récupérer les valeurs du formulaire
    $selected_isbn = $_POST['isbn'];
    $titre = isset($_POST['title']) ? $_POST['title'] : '';
    $auteur = isset($_POST['auteur']) ? $_POST['auteur'] : '';
    $prix = isset($_POST['prix']) ? $_POST['prix'] : '';

    // Désactiver les contraintes d'intégrité référentielle temporairement
    $connection->exec('SET foreign_key_checks = 0;');

    // Commencer une transaction
    $connection->beginTransaction();

    try {
        // Mettre à jour le livre dans la table books
        $stmt = $connection->prepare("UPDATE books SET title = ?, author = ?, price = ? WHERE isbn = ?");
        $stmt->execute([$titre, $auteur, $prix, $selected_isbn]);

        // Mettre à jour d'autres tables en fonction de vos relations

        // Réactiver les contraintes d'intégrité référentielle
        $connection->exec('SET foreign_key_checks = 1;');

        // Valider la transaction
        $connection->commit();

        echo "Livre modifié avec succès !";
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction
        $connection->rollBack();

        // Réactiver les contraintes d'intégrité référentielle en cas d'erreur
        $connection->exec('SET foreign_key_checks = 1;');

        echo "Erreur lors de la mise à jour du livre : " . $e->getMessage();
    }
} else {
    echo "Erreur : Le champ 'isbn' n'est pas défini.";
}
?>
