<?php
include("header.php");

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idProduit = null;

if ($id !== '') {
    $sql = "SELECT produit_ID, produit_libelle from produit where produit_ID = '$id'";
    $result = $pdo->query($sql);
    $product = $result->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $libelle = $product['produit_libelle'];
        $idValue = $product['produit_ID'];
        $idProduit = $product['produit_ID'];
    } else {
        echo "Produit introuvable.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelle = $_POST['libelle'];

    if ($idProduit !== null) {
        $sql = "UPDATE produit SET produit_libelle = '$libelle' WHERE produit_ID = '$idProduit'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO produit (produit_libelle) VALUES ('$libelle')";
        $pdo->exec($sql);
    }

    header('Location: produits.php');
    exit;
}
?>

<div class="container my-5">
    <h1 class="mb-4"><?= $id ? "Modification" : "Création" ?> d'un produit</h1>

    <form method="post">
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom du produit: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= htmlentities($libelle) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="produits.php" class="btn btn-dark">Retour</a>
    </form>
</div>

<?PHP
include("footer.php");
?>