<?php
include './header.php';

$utilisateur = $_SESSION['utilisateur_ID'] ?? null;

if (!isset($_SESSION['utilisateur_ID'])) {
    header('Location: connexion.php');
}

$clientExistant = null;
$adressesExistantes = [];
$erreurs = [];
$success = "";

function insererAdresse($pdo, $adresse1, $adresse2, $adresse3, $codepostal, $ville, $clientID) {
    $stmt = $pdo->prepare('INSERT INTO client (client_adresse1, client_adresse2, client_adresse3, client_cp, client_ville, client_ID)');
    $stmt->execute([$adresse1, $adresse2, $adresse3, $codepostal, $ville, $clientID]);
    return $pdo->lastInsertId();
}

if ($utilisateur) {
    $stmtClient = $pdo->prepare("SELECT * FROM client WHERE utilisateur_ID = :utilisateur_ID");
    $stmtClient->execute([':utilisateur_ID' => $_SESSION['utilisateur_ID']]);
    $clientExistant = $stmtClient->fetch(PDO::FETCH_ASSOC);

    if ($clientExistant) {
        $clientID = $clientExistant["client_ID"];
        $stmtAdresses = $pdo->prepare("SELECT * FROM client WHERE client_ID = :client_ID");
        $stmtAdresses->execute([':client_ID' => $clientExistant['client_ID']]);
        $adressesExistantes = $stmtAdresses->fetchAll(PDO::FETCH_ASSOC);
    }
}


// Récupération des informations du client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire en méthode POST
    $nom = $_POST['nom'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $tel = $_POST['tel'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $adresse2 = $_POST['adresse2'] ?? null;
    $adresse3 = $_POST['adresse3'] ?? null;
    $codepostal = $_POST['codepostal'] ?? null;
    $ville = $_POST['ville'] ?? null;

    $commandeID = 0;

    if (!$clientExistant) {
        $stmt = $pdo->prepare("INSERT INTO client (client_nom, client_prenom, client_tel, client_cp, client_ville, client_adresse1, client_adresse2, client_adresse3, utilisateur_ID) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $tel, $codepostal, $ville, $adresse, $adresse2, $adresse3, $utilisateur]);
        $clientID = $pdo->lastInsertId();
    } else {
        $stmt = $pdo->prepare("UPDATE client SET 
        client_nom = ?, 
        client_prenom = ?, 
        client_tel = ?, 
        client_cp = ?, 
        client_ville = ?, 
        client_adresse1 = ?, 
        client_adresse2 = ?, 
        client_adresse3 = ?");
        $stmt->execute([$nom, $prenom, $tel, $codepostal, $ville, $adresse, $adresse2, $adresse3]);
    }

    header('Location: index.php'); // Redirection vers la page d'accueil
    exit();
}

?>

<main>
    <section>

        <h1>Votre Commande</h1>

        <!-- Aperçu commande -->

        <!-- Formulaire commande à relier avec la table client du bdd -->
        <form action="commande.php" method="post">

            <article>
                <label for="nom">Nom:</label>
                <input id="nom" type="text" name="nom">
            </article>

            <article>
                <label for="prenom">Prénom:</label>
                <input id="prenom" type="text" name="prenom">
            </article>

            <article>
                <label for="tel">Téléphone:</label>
                <input id="tel" type="text" name="tel">
            </article>

    </section>

    <section>

        <label for="adresse">Adresse:</label>
        <input id="adresse" type="text" name="adresse">

    </section>

    <section>

        <label for="adresse2">Adresse 2:</label>
        <input id="adresse2" type="text" name="adresse2">

    </section>

    <section>

        <label for="adresse3">Adresse 3:</label>
        <input id="adresse3" type="text" name="adresse3">

    </section>

    <section>

        <label for="codepostal">Code Postal:</label>
        <input id="codepostal" type="text" name="codepostal">

    </section>

    <section>

        <label for="ville">Ville:</label>
        <input id="ville" type="text" name="ville">

    </section>

    <button type="submit">Envoyer</button>

    </form>
</main>

<?php
include 'footer.php';
?>