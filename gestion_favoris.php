<?php
session_start();
require_once 'header.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_ID'])) {
    echo "<div class='alert alert-danger'>Vous devez être connecté pour voir vos favoris.</div>";
    exit;
}

$user_ID = $_SESSION['utilisateur_ID'];

// Récupérer les favoris depuis la base de données
$stmt = $pdo->prepare("
    SELECT p.produit_ID, p.produit_libelle, p.produit_prix, p.produit_image 
    FROM favoris f 
    JOIN produit p ON f.produit_ID = p.produit_ID 
    WHERE f.utilisateur_ID = ?
");
$stmt->execute([$user_ID]);
$favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Mes Favoris</h1>

        <?php if (count($favoris) > 0): ?>
            <div class="row">
                <?php foreach ($favoris as $favori): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="./assets/img/<?= htmlentities($favori['produit_image']) ?>" class="card-img-top" alt="Image du produit">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlentities($favori['produit_libelle']) ?></h5>
                                <p class="card-text"><strong>Prix:</strong> <?= number_format($favori['produit_prix'], 2) ?> €</p>

                                <!-- Bouton pour retirer des favoris -->
                                <button class="btn btn-danger btn-remove-favori" data-produit-id="<?= htmlentities($favori['produit_ID']) ?>">
                                    Retirer des Favoris
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Vous n'avez aucun produit en favori.</div>
        <?php endif; ?>
    </div>
    
</body>
</html>
