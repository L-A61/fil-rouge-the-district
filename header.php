<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
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
          <div class="offcanvas-body">
            <p>L'addition du menu :</p>
          </div>
        </div>
      </div>
    </nav>
  </header>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
