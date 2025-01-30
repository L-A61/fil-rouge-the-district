<?php
include 'header.php';

// Récupération de l'ID dans la variable utilisateur s'il existe
$utilisateur = $_SESSION['utilisateur_ID'];

// Redirection vers 
if (!isset($_SESSION['utilisateur_ID'])) {
    header('Location: connexion.php');
}

// Placeholder Panier
$panier = ["test", "test2", "test3"];

$clientExistant = null;
$erreurs = [];

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
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $adresse2 = $_POST['adresse2'];
    $adresse3 = $_POST['adresse3'];
    $codepostal = $_POST['codepostal'];
    $ville = $_POST['ville'];

    if (!preg_match('/[A-zÀ-ú0-9]{3,}/', $nom)) {
        $erreurs[] = "Le nom doit au moins faire 3 caractères";
    } 
    
    if (!preg_match('/[A-zÀ-ú0-9]{3,}/', $prenom)) {
        $erreurs[] = "Le prénom doit au moins faire 3 caractères";
    } 
    
    if (!preg_match('/^\+33\d{10}$/', $tel)) {
        $erreurs[] = "Le téléphone doit commencer par +33 et contenir 10 chiffres";
    } 
    
    if (!preg_match('/^\d{5}$/',$codepostal)) {
        $erreurs[] = "Le code postal doit contenir exactement 5 chiffres";
    }


    if (empty($erreurs)) {
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
            client_adresse3 = ?
            WHERE client_ID = ?");
            $stmt->execute([$nom, $prenom, $tel, $codepostal, $ville, $adresse, $adresse2, $adresse3, $clientExistant['client_ID']]);
        }
    
        $commandeID = 0;
        foreach ($panier as $produit) {
            $stmt = $pdo->prepare("INSERT INTO commande (commande_date, commande_libelle, client_ID) VALUES (NOW(), ?, ?)");
            $stmt->execute([$produit, $clientID]);
            $commandeID = $pdo->lastInsertId();
        }
    
        header('Location: index.php'); // Redirection vers la page d'accueil
        exit();
    }
}

?>

<main>
    <section>

        <h1>Votre Commande</h1>

        <!-- Aperçu commande -->

        <?php if (!empty($erreurs)):?>
            <div class="alert alert-warning">
                <ul>
                    <?php foreach ($erreurs as $erreur):?>
                        <li><?= htmlentities($erreur)?></li>
                    <?php endforeach?>
                </ul>
            </div>
        <?php endif;?>

        <!-- Formulaire commande à relier avec la table client du bdd -->
        <form action="commande.php" method="post">

            <article>
                <label for="nom">Nom *</label>
                <input id="nom" type="text" name="nom" value="<?= $clientExistant ? htmlentities($clientExistant["client_nom"]) : "" ?>" required>
            </article>

            <article>
                <label for="prenom">Prénom *</label>
                <input id="prenom" type="text" name="prenom" value="<?= $clientExistant ? htmlentities($clientExistant["client_prenom"]) : "" ?>" required>
            </article>

            <article>
                <label for="tel">*Téléphone *</label>
                <input id="tel" type="text" name="tel" value="<?= $clientExistant ? htmlentities($clientExistant["client_tel"]) : "" ?>" required>
            </article>

    </section>

    <section>

        <label for="adresse">Adresse *</label>
        <input id="adresse" type="text" name="adresse" value="<?= $clientExistant ? htmlentities($clientExistant["client_adresse1"]) : "" ?>" required>

    </section>

    <section>

        <label for="adresse2">Adresse 2</label>
        <input id="adresse2" type="text" name="adresse2" value="<?= $clientExistant ? htmlentities($clientExistant["client_adresse2"]) : "" ?>">

    </section>

    <section>

        <label for="adresse3">Adresse 3</label>
        <input id="adresse3" type="text" name="adresse3" value="<?= $clientExistant ? htmlentities($clientExistant["client_adresse3"]) : "" ?>">

    </section>

    <section>

        <label for="codepostal">Code Postal *</label>
        <input id="codepostal" type="text" name="codepostal" value="<?= $clientExistant ? htmlentities($clientExistant["client_cp"]) : "" ?>" required>

    </section>

    <section>

        <label for="ville">Ville *</label>
        <input id="ville" type="text" name="ville" value="<?= $clientExistant ? htmlentities($clientExistant["client_ville"]) : "" ?>" required>

    </section>

    <button type="submit">Envoyer</button>

    </form>
</main>

<?php
include 'footer.php';
?>