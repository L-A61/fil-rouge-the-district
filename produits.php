<?php
include './header.php';
?>
<?php

// Initialisation des variables
$category = isset($_GET['category'])? $_GET['category'] : '';

$search = isset($_GET['searchCat']) ? $_GET['searchCat'] : '';
// Requête SQL pour récupérer les produits
$sql = "SELECT produit_ID, p.produit_libelle, p.produit_prix, p.produit_description, p.produit_image, c.categorie_libelle FROM produit p 
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
$produits = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// Suppression d'un produit
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT produit_ID FROM produit WHERE produit_ID = :id");
    $stmt->execute([':id' => $deleteID]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product) {
        $deleteSql = "DELETE FROM produit WHERE produit_ID = :id";
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute([':id' => $deleteID]);
    }
    header('Location: produits.php');
    exit;
}
?>
<div class="container my-5">
    <h1 class="mb-4">Nos produits</h1>
    <!-- Formulaire de recherche -->
    <form method="get" action="produits.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="searchCat" class="form-control" placeholder="Rechercher..."
                value="<?= htmlentities($search) ?>">
            <button type="submit" class="btn btn-warning">Rechercher</button>
        </div>
    </form>
    <!--Bouton Ajout (TODO: if type d'utilisateur admin ou commercial) -->
    <a href="produit-select.php" class="btn btn-dark">Ajouter un produit</a>
    <a href="categorie-menu.php" class="btn btn-info">Filtrer par catégorie</a>
    <!-- Liste des produits -->
    <div class="row">
        <?php if (count($produits) > 0): ?>
            <?php foreach ($produits as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <img src="./assets/img/default.jpeg" class="card-img" alt="">
                            <h3 class="card-title"><?= htmlentities($product['produit_libelle']) ?></h3>
                            <p class="card-text"><strong>Catégorie :</strong>
                                <?= htmlentities($product['categorie_libelle']) ?></p>
                            <p class="card-text"><strong>Prix:</strong>
                                <?= number_format($product['produit_prix']) ?> €</p>
                                <p class="card-text"><strong>Description:</strong>
                                <?= htmlentities($product['produit_description']) ?></p>
                            <!-- Boutons Modifier et Supprimer (TODO: if type d'utilisateur admin ou commercial) -->
                            <a class="btn btn-success" href="produit-select.php?modify=<?= htmlentities($product['produit_ID']) ?>">Modifier</a>
                            <a class="btn btn-danger" href="produits.php?delete=<?= htmlentities($product['produit_ID']) ?>"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
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
<?php
include './footer.php';
?>