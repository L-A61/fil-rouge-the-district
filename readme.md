# Bienvenue sur The District.

Un site e-commerce qui permet de commander des produits (entrées, plats, plats du jours, accompagnements, desserts et boissons) de luxe. 

## Installation

Créer la base de donnée thedistrict via le fichier thedistrict.sql présent dans le dossier sql.

## Utilisation
Certaines fonctionalités ne sont pas accessibles sans compte utilisateur, pour y remedier, vous pouvez vous inscrire en tant que client. Ou directement via l'un de ces comptes disponible dans la base de donnée:

Type Utilisateur | Login | Email | Password
--- | --- | --- | ---
Admin | testAdmin | testAdmin@test.com | 123
Client | testClient | testClient@test.com | 123
Commercial | testCommercial | testCommercial@test.com | 123

L'option de créer, modifier et supprimer des catégories ou produits doivent uniquement apparaître aux admins et commerciaux.
De même seul l'admin peut voir la liste des utilisateurs.

Seuls les utilisateurs connectés peuvent ajouter des produits au panier et commander.

L'accès à la page tableau.php est réservé aux utilisateurs de type admin ou commercial.