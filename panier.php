<?php 


// Exemple interface implementation for panier.php
$select = array();
$select['qte']=' 1';
$select['produit_libelle']=' 1';
$select['produit_prix']=' 18';

// initialisation du panier 
$_SESSION['panier'] = array();

// Ajout d'un article au panier
$_SESSION['panier']['produit_ID'] = array();
$_SESSION['panier']['qte'] = array();
$_SESSION['panier']['produit_libelle'] = array();
$_SESSION['panier']['produit_prix'] = array();
$_SESSION['panier']['produit_description'] = array();