<?php
include 'header.php';

// Véfifier si l'utilisateur est connecté
if (isset($_SESSION['utilisateur_ID'])) {
    var_dump($_SESSION['utilisateur_ID']); // Debug: Afficher l'ID de l'utilisateur
    // exit('Utilisateur déjà connecté, redirection vers index.php'); // Debug: Message avant redirection
    header('Location: index.php'); // Redirection vers la page d'accueil si l'utilisateur est déjà connecté
    exit();
}


// Traitement de la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Réception des données du formulaire en méthodes POST
    $login = $_POST['email'];
    $password = $_POST['password'];

    // var_dump($login, $password);


    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_email = :login");;
    $stmt->bindValue(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($user);


    if ($user && password_verify($password, $user['utilisateur_password'])) {
        // var_dump($user, $password);
        // Connexion réussie, stocker les informations de l'utilisateur dans la variable session
        $_SESSION['utilisateur_ID'] = $user['utilisateur_ID'];

        // Récupère le type d'utilisateur pour renseigner la variable de session type_ID
        $stmt = $pdo->prepare("SELECT * FROM type WHERE type_ID = :type_ID");
        $stmt->bindValue(':type_ID', $user['type_ID']);
        $stmt->execute();
        $type = $stmt->fetch(PDO::FETCH_ASSOC);

         // Stocker les informations de type dans la session
        $_SESSION['type_libelle'] = $type['type_libelle'];
        echo "<br>Type d'utilisateur : ". $_SESSION['type_libelle'];
        $_SESSION['logged_in'] = true;
        header('Location: index.php'); // Redirection vers la page d'acceuil
        exit();
    } else {
        //Identifiants incorrects, affichage d'un message d'erreur
        $error_message = "Email ou mot de passe incorrect";
    } 
}
?>


<div class="container-connexion">
    <div class="login-box">
        <h2 class="title-connexion">Connexion</h2>
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="form-connexion">
            <div class="textbox">
                <input type="text" name="email" placeholder="Email" class="input-connexion" autocomplete="on" required>
            </div>
            <br>
            <div class="textbox">
                <input type="password" name="password" placeholder="Mot de passe" class="input-connexion" required>
            </div>
            <p class="p-forget">Mot de passe oublié ? <a href="recup_mdp.php">Cliquez ici</a></p>
            <br>
            <input type="submit" class="btn-connexion" value="Se connecter">
        </form>
        <p class="p-forget">Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>

    </div>

</div>
</div>


<?php

include 'footer.php';
?>