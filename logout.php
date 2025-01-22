<?php
session_start();
$_SESSION = []; // Réinitialise toutes les variables de session
session_destroy();
header("Location: connexion.php"); // Redirection vers la page de connexion
exit;
?>
