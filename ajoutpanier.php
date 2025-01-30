<?php
include './header.php';


// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'thedistrict';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le panier existe, sinon afficher un message
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "Votre panier est vide.";
    exit();
}

// Récupérer les informations des produits dans le panier
function getProduits($pdo, $ids) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE produit_ID IN ($placeholders)");
    $stmt->execute($ids);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les IDs des produits dans le panier
$ids = array_column($_SESSION['panier'], 'id');

// Récupérer les informations des produits
$produits = getProduits($pdo, $ids);

// Afficher les informations des produits
foreach ($produits as $produit) {
    echo "ID: " . htmlspecialchars($produit['produit_ID']) . "<br>";
    echo "Libellé: " . htmlspecialchars($produit['produit_libelle']) . "<br>";
    echo "Prix: " . htmlspecialchars($produit['produit_prix']) . "€<br>";
    echo "Image: " . htmlspecialchars($produit['produit_image']) . "<br>";
    echo "Description: " . htmlspecialchars($produit['produit_description']) . "<br>";
    echo "Catégorie ID: " . htmlspecialchars($produit['categorie_ID']) . "<br><br>";
}
?>













<?php

include './footer.php';
?>