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

    <!--Bouton Ajout (TODO: if type d'utilisateur admin ou commercial) -->
    <a href="categorie-select.php" class="btn btn-dark">Ajouter une catégorie</a>

    <!-- Liste des catégories -->
    <div class="row">
        <?php if (count($categories) > 0): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <button><a href=""><img src="./assets/img/default.jpeg" class="card-img" alt=""></a></button>
                            <h3 class="card-title"><?= htmlentities($category['categorie_libelle']) ?></h3>

                            <!-- Boutons Modifier et Supprimer (TODO: if type d'utilisateur admin ou commercial) -->
                            <a href="categorie-select.php?modify=<?= htmlentities($category['categorie_ID'])?>">Modifier</a>
                            <a href="categorie-menu.php?delete=<?= htmlentities($category['categorie_ID'])?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
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