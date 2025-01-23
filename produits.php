<?php
include './header.php';
?>

<main>
    <section>
        <nav>

            <?php
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

            // Initialisation des variables
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Requête SQL pour récupérer les produits
            $sql = "SELECT p.produit_ID, p.produit_libelle, p.produit_prix, p.produit_description, p.produit_image, c.categorie_libelle FROM produit p 
                JOIN categorie c ON p.categorie_ID = c.categorie_ID";

            // Ajout du filtre de recherche si applicable
            if (!empty($search)) {
                $sql .= " WHERE p.produit_libelle LIKE '%$search%' OR p.produit_description LIKE '%$search%' OR c.categorie_libelle LIKE '%$search%'";
            }

            // Exécution de la requête
            $products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="container my-5">
                <h1 class="mb-4">Tous nos produits</h1>

                <!-- Formulaire de recherche -->
                <form method="get" action="produits.php" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher..."
                            value="<?= htmlentities($search) ?>">
                        <button type="submit" class="btn btn-warning">Rechercher</button>
                    </div>
                </form>

                <!-- Liste des produits -->
                <div class="row">
                    <li><a href="commande.php">Commander</a></li>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="./assets/img/default.jpeg"
                                        class="card-img-top" alt="<?= htmlentities($product['produit_libelle']) ?>"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h3 class="card-title"><?= htmlentities($product['produit_libelle']) ?></h3>
                                        <p class="card-text"><strong>Catégorie :</strong>
                                            <?= htmlentities($product['categorie_libelle']) ?></p>
                                        <p class="card-text"><strong>Prix:</strong>
                                            <?= number_format($product['produit_prix']) ?> €</p>
                                        <p class="card-text"><strong>Description:</strong>
                                            <?= htmlentities($product['produit_description']) ?></p>
                                        <form method="post" action="ajoutpanier.php">
                                            <input type="hidden" name="id" value="<?= $product['produit_ID'] ?>">
                                            <input type="hidden" name="libelle" value="<?= htmlentities($product['produit_libelle']) ?>">
                                            <input type="hidden" name="prix" value="<?= $product['produit_prix'] ?>">
                                            <button type="submit" class="btn btn-warning">Ajouter au panier</button>
                                        </form>
                                        <button class="btn btn-danger">Supprimer du panier</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            Aucun produit trouvé.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <ul>
                <li><a href="index.php">Accueil</a></li>
            </ul>
</main>

<?php
include './footer.php';
?>