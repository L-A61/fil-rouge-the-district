<?php
include 'header.php';


// Initialisation des variables
$searchCat = isset($_GET['searchCat']) ? $_GET['searchCat'] : '';
$searchProd = isset($_GET['searchProd']) ? $_GET['searchProd'] : '';

// Requête SQL pour récupérer les catégories
$sqlCat = "SELECT * FROM categorie";

// Requête SQL pour récupérer les produits
$sqlProd = "SELECT * FROM produit p 
join categorie c ON p.categorie_ID = c.categorie_ID";

// Ajout du filtre de recherche si applicable
if (!empty($searchCat)) {
    $sqlCat .= " WHERE categorie_libelle LIKE '%$searchCat%'";
}

// Exécution de la requête Catégories
$categories = $pdo->query($sqlCat)->fetchAll(PDO::FETCH_ASSOC);

// Suppression d'une catégorie
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];

    $stmt = $pdo->prepare("SELECT categorie_ID FROM categorie WHERE categorie_ID = :id");
    $stmt->execute(['id' => $deleteID]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $deleteSql = "DELETE FROM categorie WHERE categorie_ID = :id";
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute(['id' => $deleteID]);
    }

    header('Location: categorie-menu.php');
    exit;
}



// Recupere la session et détermine si l'utilisateur est commercial ou admin
if (isset($_SESSION['type_libelle'])) {
    $userType = $_SESSION['type_libelle'];
    $isCommercialOrAdmin = $userType === 'commercial' || $userType === 'admin';
} else {
    $isCommercialOrAdmin = false;
}

// Gestion de l'upload de fichier
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
   $uploads_dir = 'assets/img/';
   $tmp_name = $_FILES['photo']['tmp_name'];
   $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
   $photo_path = $uploads_dir . $filename;

   if (move_uploaded_file($tmp_name, $photo_path)) {
       $photo = $filename;
   } else {
       $message = "Erreur lors de l'upload de la photo.";
   }
}
?>



<div class="container my-5">
    <!-- Liste des catégories -->
    <h1 class="mb-4">Tous nos catégories</h1>

    <!-- Formulaire de recherche catégorie -->
    <form method="get" action="categorie-menu.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="searchCat" class="form-control" placeholder="Rechercher..."
                value="<?= htmlentities($searchCat) ?>">
            <button type="submit" class="btn btn-warning">Rechercher</button>
        </div>
    </form>


    <!-- Visible seulement si utilisateur commercial ou admin -->
    <?php if($isCommercialOrAdmin):?>
        <a href="categorie-select.php" class="btn btn-dark">Ajouter une catégorie</a>
    <?php endif;?>
   

    <!-- Liste des catégories -->
    <div class="row">
        <?php if (count($categories) > 0): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                         <img src="./assets/img/<?= htmlentities($category['categorie_image']) ?>" class="card-img" alt="">
                            <h3 class="card-title"><?= htmlentities($category['categorie_libelle']) ?></h3>
                            <a class="btn btn-info" href="produits.php?category=<?= htmlentities($category['categorie_libelle']) ?>">Afficher Les Produits</a>
                            
                            <!-- Accès au bouton modifier et supprimer si l'utilisateur est admin ou commercial -->
                             <?php if($isCommercialOrAdmin):?>
                            <a class="btn btn-success" href="categorie-select.php?modify=<?= htmlentities($category['categorie_ID'])?>">Modifier</a>
                            <a class="btn btn-danger" href="categorie-menu.php?delete=<?= htmlentities($category['categorie_ID'])?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Aucune catégorie trouvée.
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
include 'footer.php';
?>