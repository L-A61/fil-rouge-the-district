<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php
    // Récupération du nom du fichier PHP en cours sans extension
    echo ucfirst(basename($_SERVER['PHP_SELF'], '.php'));
    ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/styles/style.css">
</head>

<body>

  <?php
  session_start();
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

  ?>
  <?php

  // Vérifiez si l'utilisateur est connecté
  $username = null;
  if (isset($_SESSION['utilisateur_ID'])) {
    $userId = $_SESSION['utilisateur_ID'];

    // Récupération des informations de l'utilisateur
    $sqlUser = "SELECT * FROM utilisateur WHERE utilisateur_ID=:utilisateur_ID";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute(['utilisateur_ID' => $userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $username = $user['utilisateur_ID'];
    }
  }

  // Vérifier si l'utilisateur est commercial ou admin
  $isCommercialOrAdmin = isset($_SESSION['type_libelle']) && in_array($_SESSION['type_libelle'], ['commercial', 'admin']);
  ?>
  <nav class="navbar navbar-expand-lg
  <?php
  // Appliquer des classes spécifiques selon le type d'utilisateur
  if (isset($_SESSION['type_libelle'])) {
    switch (strtolower($_SESSION['type_libelle'])) {
      case 'commercial':
        echo 'commercial'; // Grey pour Commercial 
        echo '<!-- Cas Commercial -->';
        break;
      case 'admin':
        echo 'admin'; // Pink pour Admin
        echo '<!-- Cas Admin -->';

        break;
      default:
        echo 'defaut'; // Couleur par défaut
        break;
    }
  } else {
    echo 'defaut'; // Couleur par défaut si non connecté
  }
  ?>
  ">
  </nav>


  <header>
    <nav class="navOne">
      <a href="index.php">
        <img src="../assets/logo.png" alt="logo" class="taille">
      </a>
      <div class="navTwo">
        <button class="position">
          <a href="index.php">Accueil</a>
        </button>
        <button class="position">
          <a href="categorie-menu.php">Categories</a>
        </button>
        <button class="position">
          <a href="produits.php">Produits</a>
        </button>

        <!-- Bouton Connexion/Déconnexion -->
        <?php if ($username): ?>
          <a href="logout.php" class="position">Déconnexion</a>
        <?php else: ?>
          <a href="connexion.php" class="position">Connexion</a>
        <?php endif; ?>



        <!-- Bouton Mon Compte qui apparait si connécté -->
        <?php if ($username): ?>
    <button class="position">
        <a href="compte.php">Mon Compte</a>
    </button>
<?php endif; ?>

        <!-- Bouton Tableau pour commmercial et admin -->
        <?php if ($isCommercialOrAdmin): ?>
          <a href="tableau.php" class="position">Tableau</a>
        <?php endif; ?>




        <!-- Bouton Panier et gestion de celui ci -->

        <?php
        $nombreTotal = 0;
        if (isset($_SESSION['panier'])) {
          foreach ($_SESSION['panier'] as $item) {
            $nombreTotal += $item['quantite'];
          }
        }
        ?>
        <button class="position1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
          Panier (<?php echo $nombreTotal; ?>)
        </button>


        <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Description de la commande</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body">
            <?php if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) : ?>
              <p>Votre panier est vide</p>
            <?php else : ?>
              <div class="panier-items">
                <?php
                $total = 0;
                foreach ($_SESSION['panier'] as $produit) :
                  $sous_total = $produit['produit_prix'] * $produit['quantite'];
                  $total += $sous_total;
                ?>
                  <div class="panier-item mb-3 border-bottom pb-2">
                    <div class="d-flex align-items-center">
                      <img src="./assets/img/<?= htmlspecialchars($produit['produit_image']) ?>"
                        class="card-img me-2"
                        alt="<?= htmlspecialchars($produit['produit_libelle']) ?>"
                        style="width: 50px; height: 50px; object-fit: cover;">
                      <div class="item-details flex-grow-1">
                        <h6 class="mb-1"><?= htmlspecialchars($produit['produit_libelle']) ?></h6>
                        <p class="mb-1"><?= number_format($produit['produit_prix'], 2) ?>€ x <?= $produit['quantite'] ?></p>
                        <p class="mb-1">Sous-total: <?= number_format($sous_total, 2) ?>€</p>
                      </div>
                    </div>

                    <div class="quantity-controls mt-2 d-flex align-items-center">
                      <form action="ajoutpanier.php" method="POST" class="d-inline-block">
                        <input type="hidden" name="action" value="decrementer">
                        <input type="hidden" name="produit_id" value="<?= $produit['produit_ID'] ?>">
                        <button type="submit" class="btn btn-warning btn-sm" id="remove">-</button>
                      </form>

                      <span class="mx-2"><?= $produit['quantite'] ?></span>

                      <form action="ajoutpanier.php" method="POST" class="d-inline-block">
                        <input type="hidden" name="action" value="incrementer">
                        <input type="hidden" name="produit_id" value="<?= $produit['produit_ID'] ?>">
                        <button type="submit" class="btn btn-success btn-sm" id="add">+</button>
                      </form>

                      <form action="ajoutpanier.php" method="POST" class="d-inline-block ms-2">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="produit_id" value="<?= $produit['produit_ID'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" id="delete">
                          <i class="bi bi-trash">supprimer</i>
                        </button>
                      </form>


                    </div>
                  </div>
                <?php endforeach; ?>

                <div class="total-section mt-3">
                  <h6 class="fw-bold">Total : <?= number_format($total, 2) ?>€</h6>
                </div>

                <div class="panier-actions mt-3">
                  <a href="commande.php" class="btn btn-primary">Commander et payer</a>
                  <!-- vider le panier -->
                  <form action="viderpanier.php" method="post" class="d-inline-block">
                    <button type="submit" class="btn btn-danger">Vider le panier</button>
                  </form>
                </div>
              </div>
            <?php endif; ?>
          </div>


        </div>
      </div>
      </div>
    </nav>
  </header>