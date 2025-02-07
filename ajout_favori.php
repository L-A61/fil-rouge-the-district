<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'header.php';
die("TEST");


header('Content-Type: application/json');
ob_clean(); // efface tout ce qui a été envoyé avant 


if (!isset($_SESSION['utilisateur_ID'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

$produit_ID = $_POST['produit_id'] ?? null;
if (!$produit_ID) {
    echo json_encode(['success' => false, 'message' => 'Produit non spécifié']);
    exit;
}

$user_ID = $_SESSION['utilisateur_ID'];

// Vérifie si déjà en favori
$stmt = $pdo->prepare("SELECT favori_ID FROM favoris WHERE utilisateur_ID = ? AND produit_ID = ?");
$stmt->execute([$user_ID, $produit_ID]);
echo json_encode(['success' => false, 'message' => 'Erreur SQL SELECT']);
exit;
$favori = $stmt->fetch();

if ($favori) {
    // Supprimer le favori
    $stmt = $pdo->prepare("DELETE FROM favoris WHERE utilisateur_ID = ? AND produit_ID = ?");
    $stmt->execute([$user_ID, $produit_ID]);
    echo json_encode(['success' => true, 'action' => 'removed']);
} else {
    // Ajouter le favori
    $stmt = $pdo->prepare("INSERT INTO favoris (utilisateur_ID, produit_ID) VALUES (?, ?)");
    $stmt->execute([$user_ID, $produit_ID]);
    echo json_encode(['success' => true, 'action' => 'added']);
}
exit;
?>