<!DOCTYPE html>
<html>

<head>
    <title>Admin - Gestion des Promotions</title>
</head>

<body>
    <h1>Gestion des Promotions</h1>

    <!-- Formulaire pour les codes promo -->
    <h2>Codes Promo Personnalisés</h2>
    <form method="post" action="admin.php">
        <input type="hidden" name="action" value="ajouter_code_promo">
        <label for="code">Code Promo :</label>
        <input type="text" id="code" name="code" required>
        <label for="reduction">Réduction (%) :</label>
        <input type="number" id="reduction" name="reduction" step="0.01" required>
        <label for="date_debut">Date de Début :</label>
        <input type="date" id="date_debut" name="date_debut">
        <label for="date_fin">Date de Fin :</label>
        <input type="date" id="date_fin" name="date_fin">
        <button type="submit">Ajouter Code Promo</button>
    </form>
</body>

</html>
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

$action = $_POST['action'] ?? null;

switch ($action) {
    case 'ajouter_code_promo':
        $code = $_POST['code'];
        $reduction = $_POST['reduction'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

        $stmt = $pdo->prepare("INSERT INTO code_promo (code, reduction, date_debut, date_fin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$code, $reduction, $date_debut, $date_fin]);
        break;

    case 'ajouter_offre_temporaire':
        $produit_ID = $_POST['produit_ID'];
        $reduction = $_POST['reduction'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

        $stmt = $pdo->prepare("INSERT INTO offre_temporaire (produit_ID, reduction, date_debut, date_fin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$produit_ID, $reduction, $date_debut, $date_fin]);
        break;

    case 'ajouter_reduction_saisonniere':
        $categorie_ID = $_POST['categorie_ID'];
        $reduction = $_POST['reduction'];
        $saison = $_POST['saison'];

        $stmt = $pdo->prepare("INSERT INTO reduction_saisonniere (categorie_ID, reduction, saison) VALUES (?, ?, ?)");
        $stmt->execute([$categorie_ID, $reduction, $saison]);
        break;

    default:
        // Action inconnue
        break;
}

header('Location: admin.php');
exit;
?>