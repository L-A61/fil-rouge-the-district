<?php include 'header.php' ?>
<?php

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
	header('Location: index.php'); // Redirection vers la page d'accueil si l'utilisateur est déjà connecté
	exit();
}

// Traitement de la soumission du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Récupération des données du formulaire en méthode POST
	$login = $_POST['login'];
    $email = $_POST['email'];
	$password = $_POST['password'];

	
	$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_pseudo=:utilisateur_pseudo");
	$stmt->bindValue(':utilisateur_pseudo', $login);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user) {
		// L'utilisateur existe déjà, affichage d'un message d'erreur
		$error_message = "Ce login est déjà utilisé par un autre utilisateur.";
	} else {
		// Insertion de l'utilisateur dans la base de données
		$password_hash = password_hash($password, PASSWORD_DEFAULT); // Hashage du mot de passe
		$stmt = $pdo->prepare("INSERT INTO utilisateur (utilisateur_pseudo, utilisateur_email, utilisateur_password, type_ID) 
		VALUES (:utilisateur_pseudo, :email, :mot_de_passe, 2)"); //on force le type utilisateur à client
		$stmt->bindValue(':utilisateur_pseudo', $login);
        $stmt->bindValue(':email', $email);
		$stmt->bindValue(':mot_de_passe', $password_hash);
		$stmt->execute();

		// Récupération de l'identifiant de l'utilisateur inséré
		$user_id = $pdo->lastInsertId();

		// Connexion automatique de l'utilisateur après son inscription
		$_SESSION['utilisateur_ID'] = $user_id;

		header('Location: index.php'); // Redirection vers la page d'accueil
		exit();
	}
}
?>


    <div class="login-box">
	<h1 class="title-connexion">Inscription</h1>
	<?php if (isset($error_message)) : ?>
		<p><?php echo $error_message; ?></p>
	</div>
	<?php endif; ?>
	<form method="POST" class="form-connexion">
		<div class="text-box">
		<label for="login" class="insc">Votre Login :</label>
		<input type="login" id="login" name="login" required class="input-connexion" placeholder=""><br>
		</div>
		<div class="text-box">
        <label for="email" class="insc">Email :</label>
		<input type="email" id="email" name="email" required class="input-connexion"><br>
		</div>
		<div class="text-box">
		<label for="password" class="insc">Mot de passe :</label>
		<input type="password" id="password" name="password" required class="input-connexion"><br>
		</div>
		<br>
		<input type="submit" value="S'inscrire" class="btn-connexion">
	</form>
	<p class="insc">Déjà inscrit ? <a href="login.php">Se connecter</a></p>
	</div>

<?php include 'footer.php' ?>