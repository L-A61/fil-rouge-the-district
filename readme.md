Bienvenue sur The District.

Un site e-commerce qui permet de commander des produits (entrées, plats, plats du jours, accompagnements, desserts et boissons) de luxe. 

Pour commencer à l'utiliser, vous devez suivre ces instructions:
1 - Clonez le git sur: C:\xampp\htdocs avec la commande bash: git clone https://github.com/L-A61/fil-rouge-the-district
2 - Ouvrez xampp-control.exe et démarrez les modules Apache et MySQL
3 - Lancez le script SQL thedistrict.sql présent dans le dossier sql
4 - Lancez le serveur PHP sur la page index.php
5 - Connectez-vous via la page connexion parmi l'un des trois login:

Login testAdmin:
email: testAdmin@test.com
mdp: 123

Login testClient:
email: testClient@test.com
mdp: 123

Login testCommercial:
email: testCommercial@test.com
mdp: 123

Chaque login correspond à un type d'utilisateur, l'admin, le client et le commercial respectivement. 
L'option de créer, modifier et supprimer des catégories ou produits doivent uniquement apparaître aux admins et commerciaux.
