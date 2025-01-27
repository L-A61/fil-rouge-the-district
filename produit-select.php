<?php
include("header.php");

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idProduit = null;

if ($id !== '') {
    $sql = "SELECT * from produit where produit_ID = '$id'";
    $result = $pdo->query($sql);
    $product = $result->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $image = $product['produit_image'];
        $libelle = $product['produit_libelle'];
        $prix = $product['produit_prix'];
        $description = $product['produit_description'];
        $categorie = $product['categorie_ID'];

        $idValue = $product['produit_ID'];
        $idProduit = $product['produit_ID'];
    } else {
        echo "Produit introuvable.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_POST['image'];
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    

    if ($idProduit !== null) {
        $sql = "UPDATE produit SET 
        produit_image = '$image',
        produit_libelle = '$libelle',
        produit_prix = '$prix',
        produit_description = '$description',
        categorie_id = '$categorie'        
        WHERE produit_ID = '$idProduit'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO produit (produit_image, produit_libelle, produit_prix, produit_description, categorie_ID) 
        VALUES ('$image', '$libelle', '$prix', '$description', '$categorie')";
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
            <label for="image" class="form-label">Image du produit: </label>
            <input type="text" class="form-control" id="image" name="image" value="<?= htmlentities($image) ?>">

            <label for="categorie" class="form-label">Catégorie du produit: </label><br>
            <select name="categorie" id="categorie">
                <option value="1">Entrées</option>
                <option value="2">Plats</option>
                <option value="3">Accompagnements</option>
                <option value="4">Desserts</option>
                <option value="5">Plat du jour</option>
                <option value="6">Boissons</option>
            </select><br>

            <label for="libelle" class="form-label">Nom du produit: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= htmlentities($libelle) ?>" required>

            <label for="prix" class="form-label">Prix du produit: </label>
            <input type="text" class="form-control" id="prix" name="prix" value="<?= htmlentities($prix) ?>" required>

            <label for="description" class="form-label">Description du produit: </label>
            <input type="text" class="form-control" id="description" name="description" value="<?= htmlentities($description) ?>" required>
            
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="produits.php" class="btn btn-dark">Retour</a>
    </form>
</div>

<?PHP
include("footer.php");
?>