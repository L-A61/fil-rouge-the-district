<?php
session_start();
unset($_SESSION['panier']); // Supprime le panier
header('Location: ' . $_SERVER['HTTP_REFERER']); // Retourne à la page précédente
exit;
?>