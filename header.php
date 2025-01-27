
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
                        <a href="logout.php" class="position">Se déconnecter</a>
                    <?php else: ?>
                        <a href="connexion.php" class="position">Connexion</a>
                    <?php endif; ?>


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