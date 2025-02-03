<?php
include("header.php");

// Vérifiez si l'utilisateur est un commercial ou un administrateur
if (!$isCommercialOrAdmin) {
  header("Location: index.php"); // Redirige vers la page d'accueil si l'utilisateur n'est pas autorisé
  exit; // Arrête l'exécution du script
}

// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'thedistrict';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erreur de connexion : " . $e->getMessage());
}

// TOP 10 des produits les plus commandés
$produits = $pdo->query("SELECT commande_libelle, COUNT(commande_ID) AS commande_nombre FROM commande 
GROUP BY commande_libelle ORDER BY commande_nombre DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

// TOP 10 des clients en nombre de commande
$clientNb = $pdo->query("SELECT c.client_ID, c.client_nom, c.client_prenom, COUNT(co.commande_ID) AS nombre_commande FROM client c
JOIN commande co ON c.client_ID = co.client_ID
GROUP BY c.client_ID
ORDER BY nombre_commande DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

?>
<h2>Top 10 produits les plus commandés</h2>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Nombre de Commandes</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($produits as $produit): ?>
      <tr>
        <td><?= htmlentities($produit['commande_libelle']) ?></td>
        <td><?= htmlentities($produit['commande_nombre']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h2>Top 10 clients avec le plus de commandes</h2>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom du Client</th>
      <th scope="col">Prénom du Client</th>
      <th scope="col">Nombre de Commandes</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clientNb as $client): ?>
      <tr>
        <td><?= htmlentities($client['client_nom']) ?></td>
        <td><?= htmlentities($client['client_prenom']) ?></td>
        <td><?= htmlentities($client['nombre_commande']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php
include("footer.php");
?>




<?php
include("footer.php");
