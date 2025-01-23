<?php
include("header.php");

// Déclaration des variables
$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idCategorie = null;

// Si l'id est fourni, récupère les informations de la catégorie
if ($id !== '') {
    $sql = "SELECT categorie_ID, categorie_libelle from categorie where categorie_ID = '$id'";
    $result = $pdo->query($sql);
    $category = $result->fetch(PDO::FETCH_ASSOC);

    // Vérifie si la catégorie existe et récupère les informations si elle existe
    if ($category) {
        $libelle = $category['categorie_libelle'];
        $idValue = $category['categorie_ID'];
        $idCategorie = $category['categorie_ID'];
    } else {
        echo "Catégorie introuvable.";
        exit;
    }
}

// Traitement du formulaire de modification ou création de la catégorie
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelle = $_POST['libelle'];

    // Si l'id de la catégorie est fourni, met à jour la catégorie, sinon créée une nouvelle catégorie
    if ($idCategorie !== null) {
        $sql = "UPDATE categorie SET categorie_libelle = '$libelle' WHERE categorie_ID = '$idCategorie'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO categorie (categorie_libelle) VALUES ('$libelle')";
        $pdo->exec($sql);
    }

    // Redirection vers la page des catégories après modification ou création.
    header('Location:categorie-menu.php');
    exit;
}
?>

<!-- Contenu HTML du formulaire -->
<div class="container my-5">
    <h1 class="mb-4"><?= $id ? "Modification" : "Création" ?> d'une catégorie</h1>

    <form method="post">
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom de la catégorie: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= htmlentities($libelle) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="categorie-menu.php" class="btn btn-dark">Retour</a>
    </form>
</div>



<?php
include("footer.php");
?>