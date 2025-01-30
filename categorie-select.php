<?php
include("header.php");

if (!$isCommercialOrAdmin) {
    header("Location: index.php");
    exit;
}

// Déclaration des variables
$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idCategorie = null;

// Si l'id est fourni, récupère les informations de la catégorie
if ($id !== '') {
    $sql = "SELECT * from categorie where categorie_ID = '$id'";
    $result = $pdo->query($sql);
    $category = $result->fetch(PDO::FETCH_ASSOC);

    // Vérifie si la catégorie existe et récupère les informations si elle existe
    if ($category) {
        $image = $category['categorie_image'];
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
    $image = $_POST['image'];
    $libelle = $_POST['libelle'];

    // Si l'id de la catégorie est fourni, met à jour la catégorie, sinon créée une nouvelle catégorie
    if ($idCategorie !== null) {
        $stmt = $pdo->prepare("UPDATE categorie SET categorie_libelle = ?, categorie_image = ? WHERE categorie_ID = ?");
        $stmt->execute([$libelle, $image, $idCategorie]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO categorie (categorie_libelle, categorie_image) VALUES (?, ?)");
        $stmt->execute([$libelle, $image]);
    }

    // Redirection vers la page des catégories après modification ou création.
    header('Location:categorie-menu.php');
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

<!-- Contenu HTML du formulaire -->
<div class="container my-5">
    <h1 class="mb-4"><?= $id ? "Modification" : "Création" ?> d'une catégorie</h1>

    <form method="post">
        <div class="mb-3">
            <label for="libelle" class="form-label">Image de la catégorie: </label>
            <input type="file" class="form-control" id="image" name="image" value="<?= $id ? htmlentities($photo) : "" ?>">

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