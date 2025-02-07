<?php
session_start();

// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['type_utilisateur']) || $_SESSION['type_utilisateur'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'thedistrict';
$username = 'root';
$password = '';

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête SQL pour récupérer les utilisateurs
$sql = "SELECT utilisateur_ID, utilisateur_pseudo, utilisateur_email, utilisateur_password FROM utilisateur ORDER BY utilisateur_ID ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Liste des Utilisateurs Inscrits</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row['utilisateur_ID']) . "</td><td>" . htmlspecialchars($row['utilisateur_pseudo']) . "</td><td>" . htmlspecialchars($row['utilisateur_email']) . "</td><td>" . htmlspecialchars($row['utilisateur_password']) . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucun utilisateur trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>

<?php
$conn->close();
?>