<?php
include './header.php';
echo "Ceci est la page de connexion!";
?>
<?php
// Véfifier si l'utilisateur est connecté
if (isset($_SESSION['utilisateur_ID'])) {
    header('Location: index.php'); // Redirection vers la page d'acceuil si l'utilisateur est déjà connecté
    exit();
}

// Traitement de la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Réception des données du formulaire en méthodes POST
    $login = $_POST['username'];
    $password = $_POST['password'];

    var_dump($login, $password);


    try {
        $pdo = new PDO('mysql:host=localhost;dbname=thedistrict', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<br>Connexion réussie";
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }


    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_email = :login");;
    $stmt->bindValue(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($user);


    if ($user && password_verify($password, $user['utilisateur_password'])) {
        var_dump($user, $password);
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
        <form method="post" class="form-connexion">
            <div class="textbox">
                <input type="text" name="username" placeholder="Email" class="input-connexion" autocomplete="on" required>
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
    <div class="span"></div>
    <span style="--i:0"></span>
    <span style="--i:1"></span>
    <span style="--i:2"></span>
    <span style="--i:3"></span>
    <span style="--i:4"></span>
    <span style="--i:5"></span>
    <span style="--i:6"></span>
    <span style="--i:7"></span>
    <span style="--i:8"></span>
    <span style="--i:9"></span>
    <span style="--i:10"></span>
    <span style="--i:11"></span>
    <span style="--i:12"></span>
    <span style="--i:13"></span>
    <span style="--i:14"></span>
    <span style="--i:15"></span>
    <span style="--i:16"></span>
    <span style="--i:17"></span>
    <span style="--i:18"></span>
    <span style="--i:19"></span>
    <span style="--i:20"></span>
    <span style="--i:21"></span>
    <span style="--i:22"></span>
    <span style="--i:23"></span>
    <span style="--i:24"></span>
    <span style="--i:25"></span>
    <span style="--i:26"></span>
    <span style="--i:27"></span>
    <span style="--i:28"></span>
    <span style="--i:29"></span>
    <span style="--i:30"></span>
    <span style="--i:31"></span>
    <span style="--i:32"></span>
    <span style="--i:33"></span>
    <span style="--i:34"></span>
    <span style="--i:35"></span>
    <span style="--i:36"></span>
    <span style="--i:37"></span>
    <span style="--i:38"></span>
    <span style="--i:39"></span>
    <span style="--i:40"></span>
    <span style="--i:41"></span>
    <span style="--i:42"></span>
    <span style="--i:43"></span>
    <span style="--i:44"></span>
    <span style="--i:45"></span>
    <span style="--i:46"></span>
    <span style="--i:47"></span>
    <span style="--i:48"></span>
    <span style="--i:49"></span>

</div>
</div>


<?php

include './footer.php';
?>