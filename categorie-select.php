<?php
// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'greengarden';
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
$slug = isset($_GET['categorie_ID']) ? $_GET['categorie_ID'] : '';
$libelle = $slugValue = '';
$idCategorie = null;

// Si un slug est fourni, on récupère les informations de la catégorie à modifier
if ($slug !== '') {
    $sql = "SELECT categorie_ID, categorie_libelle FROM categorie WHERE categorie_ID LIKE = '$slug'";
    $result = $pdo->query($sql);
    $category = $result->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $libelle = $category['categorie_libelle'];
        $slugValue = $category['Slug'];
        $idCategorie = $category['categorie_ID']; // On récupère l'ID de la catégorie
    } else {
        echo "Catégorie introuvable.";
        exit;
    }
}

// Traitement du formulaire de création/modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelle = $_POST['libelle'];
    $slug = $_POST['slug']; // Vous pouvez ajouter la logique pour générer le slug ici si nécessaire
    
    // Si un slug est fourni (modification), on effectue une mise à jour, sinon une insertion
    if ($idCategorie !== null) {
        // Mise à jour d'une catégorie existante (sur l'ID de la catégorie)
        $sql = "UPDATE categorie SET categorie_libelle = '$libelle' WHERE categorie_ID = $idCategorie";
        $pdo->exec($sql);
    } else {
        // Création d'une nouvelle catégorie
        $sql = "INSERT INTO categorie (categorie_libelle) VALUES ('$libelle')";
        $pdo->exec($sql);
    }

    // Redirection après la soumission du formulaire
    header('Location: categorie-menu.php');
    exit;
}
include("header.php");
?>


<div class="container my-5">
    <h1 class="mb-4"><?= $slug ? "Modifier" : "Créer" ?> une catégorie</h1>

    <form method="post">
        <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= htmlentities($libelle) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?= $slug ? "Mettre à jour" : "Créer" ?></button>
        <a href="categorie-menu.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php
include("footer.php");
?>