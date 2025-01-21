<?php    
include './header.php';
?>

<?php
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

// Initialisation des variables
$search = isset($_GET['searchCat']) ? $_GET['searchCat'] : '';

// Requête SQL pour récupérer les catégories
$sql = "SELECT categorie_ID, categorie_libelle FROM categorie";

// Ajout du filtre de recherche si applicable
if (!empty($search)) {
    $sql .= " WHERE categorie_libelle LIKE '%$search%'";
}

// Exécution de la requête
$categories = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Suppression d'une catégorie
if (isset($_GET['delete'])) {
    $deleteCat = $_GET['delete'];
    
    // Requête pour récupérer l'ID de categorie
    $stmt = $pdo->prepare("SELECT categorieID FROM categorie");
    $stmt->execute([$deleteCat]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Requête de suppression
        $deleteSql = "DELETE FROM categorie";
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute([$deleteCat]);
    }

    // Redirection après suppression
    header('Location: categorie-menu.php');
    exit;
}
?>

<div class="container my-5">
    <h1 class="mb-4">Tous nos catégories</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="categorie-menu.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="searchCat" class="form-control" placeholder="Rechercher..."
                   value="<?= htmlentities($search) ?>">
            <button type="submit" class="btn btn-warning">Rechercher</button>
        </div>
    </form>

    <!-- Liste des catégories -->
    <div class="row">
        <?php if (count($categories) > 0): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <button><a href=""><img src="./assets/img/default.jpeg" class="card-img" alt=""></a></button>
                            <h3 class="card-title"><?= htmlentities($category['categorie_libelle']) ?></h3>
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
include './footer.php';
?>