<?php
include './header.php';


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


// Vérifier si le panier existe, sinon afficher un message
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "Votre panier est vide.";
    exit();
}

// Récupérer les informations du panier
function getProduits($id){
    $product = ($id);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Votre Panier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            height: 50px;
            object-fit: cover;
        }

        .total {
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #f44336;
        }
    </style>
</head>

<body>
    <h1>Votre Panier</h1>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Description</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0; // Initialiser le total à 0
            foreach ($_SESSION['panier'] as $produit) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($produit['libelle']) . '</td>';
                echo '<td>' . htmlspecialchars($produit['prix']) . '€</td>';
                echo '<td>' . htmlspecialchars($produit['categorie']) . '</td>';
                echo '<td>' . htmlspecialchars($produit['description']) . '</td>';
                echo '<td><img src="' . htmlspecialchars($produit['image']) . '" alt="' . htmlspecialchars($produit['libelle']) . '"></td>';
                echo '</tr>';
                $total += $produit['prix']; // Ajouter le prix du produit au total
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Total</td>
                <td class="total"><?= number_format($total, 2) ?>€</td>
            </tr>
        </tfoot>
    </table>
    <form action="commander.php" method="post">
        <button type="submit" class="btn">Passer la commande</button>
    </form>
    <form action="viderpanier.php" method="post">
        <button type="submit" class="btn btn-danger">Vider le panier</button>
    </form>
</body>

</html>

























<?php

include './footer.php';
?>