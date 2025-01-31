<?php
require_once 'header.php';
require_once 'fonction.php';

// Activer les erreurs PDO si yen a 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_ID'])) {
    header('Location: connexion.php');
    exit();
}

$userId = $_SESSION['utilisateur_ID'];
$message = '';
$errorMessage = '';
$clientInfo = null;
$userEmail = '';

// Récupérer l'email de l'utilisateur si il est connecte
$stmtUser = $pdo->prepare("SELECT utilisateur_email FROM utilisateur WHERE utilisateur_ID = ?");
$stmtUser->execute([$userId]);
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
$userEmail = $userData['utilisateur_email'] ?? '';

// Vérifier si le client existe deja
$stmt = $pdo->prepare("SELECT * FROM client WHERE utilisateur_ID = ?");
$stmt->execute([$userId]);
$clientInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_nom = $_POST['nom'] ?? '';
    $client_prenom = $_POST['prenom'] ?? '';
    $client_adresse1 = $_POST['adresse'] ?? '';
    $client_tel = $_POST['telephone'] ?? '';
    $client_ville = $_POST['ville'] ?? '';
    $client_cp = $_POST['code_postal'] ?? '';

   
        try {
            if ($clientInfo) {
                // Mise à jour des informations existante
                $stmt = $pdo->prepare("UPDATE client SET 
                    client_nom = ?, client_prenom = ?, client_adresse1 = ?, client_tel = ?, 
                    client_ville = ?, client_cp = ? 
                    WHERE utilisateur_ID = ?");
                $stmt->execute([$client_nom, $client_prenom, $client_adresse1, $client_tel, $client_ville, $client_cp, $userId]);
                $message = "Vos informations ont été mises à jour avec succès.";
            } else {
                // Création d'un nouveau client
                $stmt = $pdo->prepare("INSERT INTO client 
                    (utilisateur_ID, client_nom, client_prenom, client_adresse1, client_tel, email, client_ville, client_cp) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $client_nom, $client_prenom, $client_adresse1, $client_tel, $userEmail, $client_ville, $client_cp]);
                $message = "Vos informations ont été enregistrées avec succès.";
            }
            
            // Rafraîchir les informations client
            $stmt = $pdo->prepare("SELECT * FROM client WHERE utilisateur_ID = ?");
            $stmt->execute([$userId]);
            $clientInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errorMessage = "Une erreur est survenue lors de l'enregistrement : " . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
    
</head>
<body>
    <div class="form-container">
        <h2 class="mb-4">Mes Informations</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error_message']); ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form method="POST" action="compte.php">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" class="form-control" id="nom" name="nom" 
                    value="<?php echo htmlspecialchars($clientInfo['client_nom'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" class="form-control" id="prenom" name="prenom" 
                    value="<?php echo htmlspecialchars($clientInfo['client_prenom'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control readonly-field" id="email" 
                    value="<?php echo htmlspecialchars($userEmail); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone *</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" 
                    value="<?php echo htmlspecialchars($clientInfo['client_tel'] ?? ''); ?>" 
                    pattern="[0-9]{10}" title="Le numéro doit contenir 10 chiffres" required>
            </div>

            <div class="form-group">
                <label for="adresse">Adresse *</label>
                <input type="text" class="form-control" id="adresse" name="adresse" 
                    value="<?php echo htmlspecialchars($clientInfo['client_adresse1'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="code_postal">Code Postal *</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" 
                    value="<?php echo htmlspecialchars($clientInfo['client_cp'] ?? ''); ?>" 
                    pattern="[0-9]{5}" title="Le code postal doit contenir 5 chiffres" required>
            </div>

            <div class="form-group">
                <label for="ville">Ville *</label>
                <input type="text" class="form-control" id="ville" name="ville" 
                    value="<?php echo htmlspecialchars($clientInfo['client_ville'] ?? ''); ?>" required>
            </div>

          

            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
