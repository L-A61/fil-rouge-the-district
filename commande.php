<?php
include 'header.php';

// Récupération de l'ID dans la variable utilisateur s'il existe
$utilisateur = $_SESSION['utilisateur_ID'];

// Redirection vers connexion si l'ID d'utilisateur n'est pas reconnu
if (!isset($_SESSION['utilisateur_ID'])) {
    header('Location: connexion.php');
}

// Récupération du panier
$panier_session = $_SESSION['panier'];
$panier = [];

// Ajoute le libelle, quantité et prix de chaque produit du panier.
foreach ($panier_session as $produit) {
    $panier[] = [
        'libelle' => $produit['produit_libelle'],
        'quantite' => $produit['quantite'],
        'prix' => $produit['produit_prix'] * $produit['quantite']
    ];
}

var_dump($panier);


// On assume au départ que le client n'existe pas dans la bdd actuellement
$clientExistant = null;

// Définition d'un tableau d'erreurs vide au départ
$erreurs = [];

// Si l'utilisateur existe, préparation d'une requête SQL pour retrouver l'id de l'utilisateur dans la bdd.
if ($utilisateur) {
    $stmtClient = $pdo->prepare("SELECT * FROM client WHERE utilisateur_ID = :utilisateur_ID");
    $stmtClient->execute([':utilisateur_ID' => $_SESSION['utilisateur_ID']]);
    $clientExistant = $stmtClient->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur est déjà un client, on cherche l'id du client dans la bdd
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

    // Vérification avec expression régulière que les champs correspondent aux exigences. 
    //Ajout de message d'erreur dans le tableau erreurs si les données correspondent pas.
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

    // Quand aucun erreur ne se trouve dans le tableau erreurs, on vérifie si le client n'existe pas.
    if (empty($erreurs)) {
        // Si le client n'existe pas, on insère les données dans la bdd sur une nouvelle ligne en ajoutant un ID au client
        if (!$clientExistant) {
            $stmt = $pdo->prepare("INSERT INTO client (client_nom, client_prenom, client_tel, client_cp, client_ville, client_adresse1, client_adresse2, client_adresse3, utilisateur_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $tel, $codepostal, $ville, $adresse, $adresse2, $adresse3, $utilisateur]);
            $clientID = $pdo->lastInsertId();
        // Si le client existe, on met à jours les données dans la bdd selon l'ID du client
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
        
        // Pour chaque élément dans le panier, on insère une nouvelle ligne dans la table commande avec la date, le nom du produit, l'ID du client, la quantité et le prix.
        foreach ($panier as $produit) {
            $stmt = $pdo->prepare("INSERT INTO commande (commande_date, commande_libelle, client_ID, commande_quantite, commande_prix) VALUES (NOW(), ?, ?, ?, ?)");
            $stmt->execute([$produit['libelle'], $clientID, $produit['quantite'], $produit['prix']]);
            $commandeID = $pdo->lastInsertId();
        }
        
        // Suppression du panier et redirection vers la page d'accueil après comamande
        unset($_SESSION['panier']);
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
        exit;
    }
}

?>

<main>
    <section>

        <h1>Votre Commande</h1>

        <!-- Aperçu commande -->
        <ul>
        <?php foreach($panier_session as $panier):?>
            <li><?= htmlentities($panier['quantite'])?> <?= htmlentities($panier['produit_libelle'])?>: <?= number_format(htmlentities($panier['produit_prix']) * htmlentities($panier['quantite']), 2)?>€</li>
        <?php endforeach;?>
        </ul>

        <!-- Si le tableau erreur n'est pas vide, on liste les messages d'erreurs -->
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
        <!-- Chaque input regarde si le client existe, récupèrant les informations du client dans la bdd comme valeur -->
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
    
    <p>TOTAL: <?= number_format(htmlentities($total), 2)?>€</p>

    <button type="submit">Envoyer</button>

    </form>

    
</main>

<?php
include 'footer.php';
?>