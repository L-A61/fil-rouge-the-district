<?php
include './header.php';

// Récupération des informations du client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire en méthode POST
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $adresse2 = $_POST['adresse2'];
    $adresse3 = $_POST['adresse3'];
    $codepostal = $_POST['codepostal'];
    $ville = $_POST['ville'];


    // Insertion de l'utilisateur dans la base de données (id utilisateur à ajouter plus tard)
    $stmt = $pdo->prepare("INSERT INTO client (client_nom, client_prenom, client_tel, client_cp, client_ville, client_adresse1, client_adresse2, client_adresse3) 
		VALUES (:client_nom, :client_prenom, :client_tel, :client_cp, :client_ville, :client_adresse1, :client_adresse2, :client_adresse3)");
    $stmt->bindValue(':client_nom', $nom);
    $stmt->bindValue(':client_prenom', $prenom);
    $stmt->bindValue(':client_tel', $tel);
    $stmt->bindValue(':client_cp', $codepostal);
    $stmt->bindValue(':client_ville', $ville);
    $stmt->bindValue(':client_adresse1', $adresse);
    $stmt->bindValue(':client_adresse2', $adresse2);
    $stmt->bindValue(':client_adresse3', $adresse3);
    $stmt->execute();

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
                <label for="email">Email:</label>
                <input id="email" type="text" name="email">
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