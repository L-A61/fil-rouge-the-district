<?php
include("header.php");

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idProduit = null;

$categories = [];

if ($id !== '') {
    $sql = "SELECT * FROM produit p JOIN categorie c ON p.categorie_ID = c.categorie_ID WHERE p.produit_ID = '$id'";
    $result = $pdo->query($sql);
    $product = $result->fetch(PDO::FETCH_ASSOC);

    $categories = $pdo->query("SELECT categorie_ID, categorie_libelle FROM categorie")->fetchAll();

    if ($product) {
        $image = $product['produit_image'];
        $libelle = $product['produit_libelle'];
        $prix = $product['produit_prix'];
        $description = $product['produit_description'];
        $categorie = $product['categorie_ID'];
        $categorieLibelle = $product['categorie_libelle'];

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
        $sql = "UPDATE produit p SET 
        p.produit_image = '$image',
        p.produit_libelle = '$libelle',
        p.produit_prix = '$prix',
        p.produit_description = '$description',
        p.categorie_id = '$categorie'        
        WHERE p.produit_ID = '$idProduit'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO produit p (p.produit_image, p.produit_libelle, p.produit_prix, p.produit_description, p.categorie_ID) 
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
            <input type="text" class="form-control" id="image" name="image" value="<?= $id ? htmlentities($image) : "" ?>">

            <label for="categorie" class="form-label">Catégorie du produit: </label>
            <select name="categorie" class="form-control" id="categorie">
                <?php foreach($categories as $categorie):?>

                <?php endforeach ?>
            </select>

            <label for="libelle" class="form-label">Nom du produit: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= $id ? htmlentities($libelle) : "" ?>" required>

            <label for="prix" class="form-label">Prix du produit: </label>
            <input type="text" class="form-control" id="prix" name="prix" value="<?= $id ? htmlentities($prix) : "" ?>" required>

            <label for="description" class="form-label">Description du produit: </label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $id ? htmlentities($description) : "" ?>" required>
            
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="produits.php" class="btn btn-dark">Retour</a>
    </form>
</div>

<?PHP
include("footer.php");
?>