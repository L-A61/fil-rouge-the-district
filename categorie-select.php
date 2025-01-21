<?php
include("header.php");

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

$exists = isset($_GET['categorie_ID']) ? $_GET['categorie_ID'] : '';
$libelle = $existValue = '';
$idCategorie = null;

if ($exists !== '') {
    $sql = "SELECT categorie_ID, categorie_libelle from categorie where categorie_ID = '$exists'";
    $result = $pdo->query($sql);
    $category = $result->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $libelle = $category['categorie_libelle'];
        $existValue = $category['categorie_ID'];
        $idCategorie = $category['categorie_ID'];
    } else {
        echo "Catégorie introuvable.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelle = $_POST['libelle'];

    if ($idCategorie !== null) {
        $sql = "UPDATE categorie SET categorie_libelle = '$libelle' WHERE categorie_ID = '$idCategorie'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO categorie (categorie_libelle) VALUES ('$libelle')";
        $pdo->exec($sql);
    }

    header('Location: categorie-menu.php');
    exit;
}

?>

<div class="container my-5">
    <h1 class="mb-4"><?= $exists ? "Modification" : "Création" ?> d'une catégorie</h1>

    <form method="post">
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom de la catégorie: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= htmlentities($libelle) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning"><?= $exists ? "Mettre à jour" : "Créer" ?></button>
        <a href="categorie-menu.php" class="btn btn-dark">Retour</a>
    </form>
</div>



<?php
include("footer.php");
?>