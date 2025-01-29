<?php
require_once 'header.php'; // Pour avoir accès à la connexion PDO

// Fonction d'ajout au panier
function ajouterAuPanier($produit) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    
    $_SESSION['panier'][] = [
        'produit_ID' => $produit['produit_ID'],
        'produit_libelle' => $produit['produit_libelle'],
        'produit_prix' => $produit['produit_prix'],
        'produit_image' => $produit['produit_image'],
        'quantite' => 1
    ];
}

// Traitement de l'ajout au panier
if (isset($_POST['produit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE produit_ID = ?");
    $stmt->execute([$_POST['produit_id']]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($produit) {
        ajouterAuPanier($produit);
    }
    

}
echo '<meta http-equiv="refresh" content="0;url=produits.php">';
            exit;
?>