<?php
session_start();

// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['type_utilisateur']) || $_SESSION['type_utilisateur'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'administration</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Bienvenue dans la page d'administration</h1>

    <!-- Bouton pour afficher la liste des utilisateurs -->
    <a href="liste.php" class="btn btn-primary">Voir la Liste des Utilisateurs</a>

    <!-- Ajoutez ici d'autres éléments de l'interface d'administration -->

</body>

</html>