<?php
include("header.php");

if (!$isCommercialOrAdmin) {
    header("Location: index.php");
    exit;
}

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
    $image = $_POST['produit_image'];
    $libelle = $_POST['produit_libelle'];
    $prix = $_POST['produit_prix'];
    $description = $_POST['produit_description'];
    $categorie = $_POST['categorie'];
    
// Si l'id du produit existe, on le met à jour. Sinon on le créer.
    if ($idProduit !== null) {
        $stmt = $pdo->prepare ("UPDATE produit SET 
        produit_image = ?,
        produit_libelle = ?,
        produit_prix = ?,
        produit_description = ?,
        categorie_id = ?        
        WHERE produit_ID = ?");
        $stmt->execute([$image, $libelle, $prix, $description, $categorie, $idProduit]);
    } else {
        $stmt = $pdo->prepare ("INSERT INTO produit (produit_image, produit_libelle, produit_prix, produit_description, categorie_id) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$image, $libelle, $prix, $description, $categorie]);
    }

    // Redirection vers la page produit.php après modification ou création
    header('Location: produits.php');
    exit;
}

// Gestion de l'upload de fichier
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploads_dir = 'assets/img/';
    $tmp_name = $_FILES['photo']['tmp_name'];
    $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
    $photo_path = $uploads_dir . $filename;

    if (move_uploaded_file($tmp_name, $photo_path)) {
        $photo = $filename;
    } else {
        $message = "Erreur lors de l'upload de la photo.";
    }
}

?>

<!-- Formulaire qui indique si on modifie ou créer un produit selon si l'id récupéré existe-->
<div class="container my-5">
    <h1 class="mb-4"><?= $id ? "Modification" : "Création" ?> d'un produit</h1>

    <form method="post">
        <div class="mb-3">
            <label for="image" class="form-label">Image du produit: </label>
            <input type="file" class="form-control" id="image" name="produit_image" value="<?= $id ? htmlentities($photo) : "" ?>">

            <label for="libelle" class="form-label">Nom du produit: </label>
            <input type="text" class="form-control" id="libelle" name="produit_libelle" value="<?= $id ? htmlentities($libelle) : "" ?>" required>

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
            <input type="text" class="form-control" id="prix" name="produit_prix" value="<?= $id ? htmlentities($prix) : "" ?>" required>

            <label for="description" class="form-label">Description du produit: </label>
            <input type="text" class="form-control" id="description" name="produit_description" value="<?= $id ? htmlentities($description) : "" ?>" required>

        </div>
        <!-- Si l'id du produit existe, on met une valeur cachée pour l'id dans le formulaire pour que le formulaire ne se recharge pas lors du retour à la page produits.php-->
        <input type="hidden" name="id" value="<?= $idValue ?>">
    
                
                 
               <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="produits.php" class="btn btn-dark">Retour</a>
    </form>
</div>

<?PHP
include("footer.php");
?>