<?php
include("header.php");

// Vérifie si l'id existe dans l'URL, modify si c'est le cas
$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idProduit = null;

// Création d'un tableau categories avec une requête SQL recherchant les ids et libelles de la table categorie 
$categories = [];
$categories = $pdo->query("SELECT categorie_ID, categorie_libelle FROM categorie")->fetchAll();

// Si l'ID existe, une requête SQL récupérant la table produit et categorie où l'ID correspond à l'ID sélectionné 
if ($id !== '') {
    $sql = "SELECT * FROM produit p JOIN categorie c ON p.categorie_ID = c.categorie_ID WHERE p.produit_ID = '$id'";
    $result = $pdo->query($sql);
    $product = $result->fetch(PDO::FETCH_ASSOC);

    
    // Si la requête SQL trouve des éléments, on définit les différents variables pour les relier aux colonnes SQL. Sinon on indique que le produit est introuvable
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

// Si la méthode POST s'active, on définit les différent variables pour les relier aux valeur de name dans le formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_POST['image'];
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    
// Si l'id du produit existe, on le met à jour. Sinon on le créer.
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
        $sql = "INSERT INTO produit (produit_image, produit_libelle, produit_prix, produit_description, categorie_id) 
        VALUES ('$image', '$libelle', '$prix', '$description', '$categorie')";
        $pdo->exec($sql);
    }

    // Redirection vers la page produit.php après modification ou création
    header('Location: produits.php');
    exit;
}
?>

<!-- Formulaire qui indique si on modifie ou créer un produit selon si l'id récupéré existe-->
<div class="container my-5">
    <h1 class="mb-4"><?= $id ? "Modification" : "Création" ?> d'un produit</h1>

    <form method="post">
        <div class="mb-3">
            <label for="image" class="form-label">Image du produit: </label>
            <input type="text" class="form-control" id="image" name="image" value="<?= $id ? htmlentities($image) : "" ?>">

            <label for="libelle" class="form-label">Nom du produit: </label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="<?= $id ? htmlentities($libelle) : "" ?>" required>

            <label for="categorie" class="form-label">Catégorie du produit: </label>
            
            <!-- Dans le select, on créer un foreach de la table categories pour créer une balise option avec pour valeur l'id et pour texte le libelle de la catégorie 
            Si l'id de la catégorie existe on met sa balise option comme selectionnée par défaut-->
            <select name="categorie" class="form-control" id="categorie">
                <?php foreach($categories as $categorieValue):?>
                    <option value="<?= $categorieValue['categorie_ID'] ?>" <?= (isset($product['categorie_ID']) && $product['categorie_ID'] == $categorieValue['categorie_ID']) ? 'selected' : '' ?>>
                    <?= htmlentities($categorieValue['categorie_libelle']) ?>
                </option>
                <?php endforeach ?>
            </select>

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