<?php    
include './header.php';
?>

<main>
    <section>
        
        <?php

// Initialisation des variables
$category = isset($_GET['category'])? $_GET['category'] : '';

$search = isset($_GET['searchProd']) ? $_GET['searchProd'] : '';

// Requête SQL pour récupérer les produits
$sql = "SELECT p.produit_libelle, p.produit_prix, p.produit_description, p.produit_image, c.categorie_libelle FROM produit p 
join categorie c ON p.categorie_ID = c.categorie_ID";

// Ajout du filtre de recherche si applicable
if (!empty($search)) {
    $sql .= " WHERE produit_libelle LIKE '%$search%'";
}

// Selectionne des produits par catégorie si spécifiée
if ($category) {
    $sql .= " WHERE c.categorie_libelle = '$category'";
}

// Exécution de la requête
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <?php if ($category):?>
        <h1 class="mb-4">Tous nos <?php echo htmlentities($category)?></h1>
    <?php else:?>
        <h1 class="mb-4">Tous nos produits</h1>
    <?php endif;?>

    <!-- Formulaire de recherche -->
    <form method="get" action="produits.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="searchProd" class="form-control" placeholder="Rechercher..."
                value="<?= htmlentities($search) ?>">
            <button type="submit" class="btn btn-warning">Rechercher</button>
        </div>
    </form>

    <!-- Liste des produits -->
    <div class="row">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./assets/img/default.jpeg"
                            class="card-img-top" alt="<?= htmlentities($product['produit_libelle']) ?>" 
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlentities($product['produit_libelle']) ?></h3>
                            <p class="card-text"><strong>Catégorie :</strong>
                                <?= htmlentities($product['categorie_libelle']) ?></p>
                            <p class="card-text"><strong>Prix:</strong>
                                <?= number_format($product['produit_prix']) ?> €</p>
                                <p class="card-text"><strong>Description:</strong>
                                <?= htmlentities($product['produit_description']) ?></p>
                            <button class="btn btn-warning">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Aucun produit trouvé.
            </div>
        <?php endif; ?>
    </div>
</div>
</main>

<?php
include 'footer.php';
?>