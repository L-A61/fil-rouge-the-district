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

// Requête SQL pour récupérer les produits
$sql = "SELECT produit_ID, produit_libelle FROM produit";

// Ajout du filtre de recherche si applicable
if (!empty($search)) {
    $sql .= " WHERE produit_libelle LIKE '%$search%'";
}

// Exécution de la requête
$produits = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Suppression d'un produit
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];

    $stmt = $pdo->prepare("SELECT produit_ID FROM produit WHERE produit_ID = :id");
    $stmt->execute(['id' => $deleteID]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $deleteSql = "DELETE FROM produit WHERE produit_ID = :id";
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute(['id' => $deleteID]);
    }

    header('Location: produit-menu.php');
    exit;
}

?>

<div class="container my-5">
    <h1 class="mb-4">Nos produits</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="produit-menu.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="searchCat" class="form-control" placeholder="Rechercher..."
                value="<?= htmlentities($search) ?>">
            <button type="submit" class="btn btn-warning">Rechercher</button>
        </div>
    </form>

    <!--Bouton Ajout (TODO: if type d'utilisateur admin ou commercial) -->
    <a href="produit-select.php" class="btn btn-dark">Ajouter un produit</a>

    <!-- Liste des produits -->
    <div class="row">
        <?php if (count($produits) > 0): ?>
            <?php foreach ($produits as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <button><a href=""><img src="./assets/img/default.jpeg" class="card-img" alt=""></a></button>
                            <h3 class="card-title"><?= htmlentities($product['produit_libelle']) ?></h3>

                            <!-- Boutons Modifier et Supprimer (TODO: if type d'utilisateur admin ou commercial) -->
                            <a class="btn btn-success" href="produit-select.php?modify=<?= htmlentities($product['produit_ID']) ?>">Modifier</a>
                            <a class="btn btn-danger" href="produit-menu.php?delete=<?= htmlentities($product['produit_ID']) ?>"
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