<?php
include("header.php");

// Vérifiez si l'utilisateur est un commercial ou un administrateur
if (!$isCommercialOrAdmin) {
    header("Location: index.php");
    exit;
}

// Chiffre d'affaires mois par mois
$moisCA = $pdo->query("SELECT DATE_FORMAT(commande_date, '%Y-%m') as mois,  SUM(commande_prix) as CA FROM commande
GROUP BY DATE_FORMAT(commande_date, '%Y-%m') ORDER BY mois")->fetchAll();


// TOP 10 des produits les plus commandés
$produits = $pdo->query("SELECT commande_libelle, count(commande_ID) AS commande_nombre FROM commande 
GROUP BY commande_libelle ORDER BY commande_nombre DESC LIMIT 10")->fetchAll();

// TOP 10 des plats les plus rémunérateurs
$produitsRem = $pdo->query("SELECT commande_libelle, sum(commande_prix) as remuneration FROM commande 
GROUP BY commande_libelle ORDER BY remuneration DESC LIMIT 10")->fetchAll();


// TOP 10 des clients en nombre de commande
$clientNb = $pdo->query("SELECT c.client_ID, c.client_nom, c.client_prenom, COUNT(co.commande_ID) AS nombre_commande FROM client c
JOIN commande co ON c.client_ID = co.client_ID
GROUP BY c.client_ID
ORDER BY nombre_commande DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>Chiffres d'affaires mois par mois</h1>
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Année-Mois</th>
      <th scope="col">CA (En €)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($moisCA as $CA):?>
    <tr>
      <td><?= htmlentities($CA['mois'])?></td>
      <td><?= htmlentities($CA['CA'])?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

<h2>Top 10 produits les plus commandés</h1>
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Libelle</th>
      <th scope="col">Nombre Commande</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($produits as $produit):?>
    <tr>
      <td><?= htmlentities($produit['commande_libelle'])?></td>
      <td><?= htmlentities($produit['commande_nombre'])?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

<h2>Top 10 produits les plus rémunérateurs</h1>
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Libelle</th>
      <th scope="col">Rémunération (en €)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($produitsRem as $rem):?>
    <tr>
      <td><?= htmlentities($rem['commande_libelle'])?></td>
      <td><?= htmlentities($rem['remuneration'])?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

<h2>Top 10 clients avec le plus de commande</h1>
<table class="table table-striped table-dark">
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
