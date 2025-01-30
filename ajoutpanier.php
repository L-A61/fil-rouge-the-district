<?php
// ajoutpanier.php
require_once 'header.php';

function ajouterAuPanier($produit) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    
    // Check if product already exists in cart
    $found = false;
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['produit_ID'] == $produit['produit_ID']) {
            $item['quantite']++;
            $found = true;
            break;
        }
    }
    
    // If product not found, add it with quantity 1
    if (!$found) {
        $_SESSION['panier'][] = [
            'produit_ID' => $produit['produit_ID'],
            'produit_libelle' => $produit['produit_libelle'],
            'produit_prix' => $produit['produit_prix'],
            'produit_image' => $produit['produit_image'],
            'quantite' => 1
        ];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $produit_id = $_POST['produit_id'] ?? '';
    
    switch($action) {
        case 'ajouter':
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE produit_ID = ?");
            $stmt->execute([$produit_id]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($produit) {
                ajouterAuPanier($produit);
            }
            break;
            
        case 'incrementer':
            foreach ($_SESSION['panier'] as &$item) {
                if ($item['produit_ID'] == $produit_id) {
                    $item['quantite']++;
                    break;
                }
            }
            break;
            
        case 'decrementer':
            foreach ($_SESSION['panier'] as $key => &$item) {
                if ($item['produit_ID'] == $produit_id) {
                    $item['quantite']--;
                    if ($item['quantite'] <= 0) {
                        unset($_SESSION['panier'][$key]);
                    }
                    break;
                }
            }
            $_SESSION['panier'] = array_values($_SESSION['panier']); 
            break;
            
        case 'supprimer':
            foreach ($_SESSION['panier'] as $key => $item) {
                if ($item['produit_ID'] == $produit_id) {
                    unset($_SESSION['panier'][$key]);
                    break;
                }
            }
            $_SESSION['panier'] = array_values($_SESSION['panier']); 
            break;
    }
}


echo '<meta http-equiv="refresh" content="0;url=produits.php">';
            exit;
?>