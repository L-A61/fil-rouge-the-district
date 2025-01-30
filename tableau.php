<?php
include("header.php");

if (!$isCommercialOrAdmin) {
    header("Location: index.php");
    exit;
}

// TOP 10 des produits les plus commandés
$produits = $pdo->query("SELECT commande_libelle, count(commande_ID) AS commande_nombre FROM commande 
GROUP BY commande_libelle ORDER BY commande_nombre DESC LIMIT 10")->fetchAll();

// TOP 10 des clients en nombre de commande
$clientNb = $pdo->query("SELECT c.client_ID, c.client_nom, c.client_prenom, count(co.commande_ID) as nombre_commande FROM client c
JOIN commande co ON c.client_ID = co.client_ID
GROUP BY c.client_ID
ORDER BY nombre_commande DESC LIMIT 10")->fetchAll(); 

?>
<h2>Top 10 produits les plus commandés</h1>
<table class="table">
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

<h2>Top 10 clients avec le plus de commande</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nom Client</th>
      <th scope="col">Prénom Client</th>
      <th scope="col">Nombre Commande</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($clientNb as $client):?>
    <tr>
      <td><?= htmlentities($client['client_nom'])?></td>
      <td><?= htmlentities($client['client_prenom'])?></td>
      <td><?= htmlentities($client['nombre_commande'])?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>



<?php
include("footer.php");