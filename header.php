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
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Récupération des informations de l'utilisateur
    $sqlUser = "SELECT Login FROM utlisateur WHERE utilisateur_pseudo=:utilisateur_pseudo";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute(['userId' => $userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $username = $user['Login'];
    }
  }

  // Vérifier si l'utilisateur est commercial ou admin
  $isCommercialOrAdmin = isset($_SESSION['type_libelle']) && in_array($_SESSION['type_libelle'], ['Commercial', 'Admin']);
  ?>
  <nav class="navbar navbar-expand-lg 
  <?php
  // Appliquer des classes spécifiques selon le type d'utilisateur
  if (isset($_SESSION['type_libelle'])) {
    switch ($_SESSION['type_libelle']) {
      case 'Commercial':
        echo 'bg-success'; // Vert pour Commercial 
        break;
      case 'Admin':
        echo 'bg-danger'; // Rouge pour Admin
        break;
      default:
        echo 'bg-body-tertiary'; // Couleur par défaut
        break;
    }
  } else {
    echo 'bg-body-tertiary'; // Couleur par défaut si non connecté
  }
  ?>
  ">
  </nav>

  <header>
    <nav class="navOne">
      <img src="../assets/logo.png" alt="logo" class="taille">
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
        <button class="position">
          <a href="connexion.php">Connexion</a>
        </button>
        <button class="position1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Mon Panier</button>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Description de la commande</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <!--Affichage du panier -->
          <div class="offcanvas-body">
            <?php
              // Récupération du panier d'une session
              $session_panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();
              $produits_panier = array();
              $quantite = 1;
              $total = 0.00;

              // S'il y a des produits dans le panier
              if ($session_panier) {
                $stmt = $pdo->prepare("SELECT * FROM produit WHERE produit_ID IN :produit_ID");
                $stmt->execute(array_keys($session_panier));
                $produits_panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Calcul du total
                foreach ($produits_panier as $produit) {
                  $total += (float)$produit['produit_prix'] * (int)$session_panier[$produit['produit_ID']];
                }
                echo '<p>Votre panier contient : </p>';
              } else {
                echo '<p>Aucun panier récupéré.</p>';
              }
            ?>

            <p>Total : <?php echo number_format($total); ?> €</p>
            <a href="commande.php"><button class="btn btn-warning">Commander</button></a>
          </div>
        </div>
      </div>
    </nav>
  </header>