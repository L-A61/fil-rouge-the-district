<?php
include("header.php");

/* Redirige à la page categorie-menu si le type_libelle de la session n'est pas admin ou commercial */ 
if ($_SESSION['type_libelle'] !== "admin" || $_SESSION['type_libelle']!== "commercial") {
    header("Location: categorie-menu.php");
    exit;
}


$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idCategorie = null;

if ($id !== '') {
    $sql = "SELECT categorie_ID, categorie_libelle from categorie where categorie_ID = '$id'";
    $result = $pdo->query($sql);
    $category = $result->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $libelle = $category['categorie_libelle'];
        $idValue = $category['categorie_ID'];
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

    header('Location:categorie-menu.php');
    exit;
}
?>

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