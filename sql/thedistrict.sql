drop database if exists thedistrict;
create database if not exists thedistrict;

use thedistrict;

CREATE TABLE if not exists Categorie(
   categorie_ID INT AUTO_INCREMENT,
   categorie_libelle VARCHAR(50)  NOT NULL,
   categorie_image VARCHAR(50),
   PRIMARY KEY(categorie_ID)
);

CREATE TABLE if not exists Produit(
   produit_ID INT AUTO_INCREMENT,
   produit_libelle VARCHAR(50)  NOT NULL,
   produit_prix DECIMAL(19,2) NOT NULL,
   produit_image VARCHAR(50) ,
   produit_description VARCHAR(500)  NOT NULL,
   categorie_ID INT NOT NULL,
   PRIMARY KEY(produit_ID),
   FOREIGN KEY(categorie_ID) REFERENCES Categorie(categorie_ID)
);

CREATE TABLE if not exists Type(
   type_ID INT AUTO_INCREMENT,
   type_libelle VARCHAR(50)  NOT NULL,
   PRIMARY KEY(type_ID)
);

CREATE TABLE if not exists Utilisateur(
   utilisateur_ID INT AUTO_INCREMENT,
   utilisateur_pseudo VARCHAR(50)  NOT NULL,
   utlisateur_email VARCHAR(50)  NOT NULL,
   utilisateur_password VARCHAR(50)  NOT NULL,
   type_ID INT NOT NULL,
   PRIMARY KEY(utilisateur_ID),
   FOREIGN KEY(type_ID) REFERENCES Type(type_ID)
);

CREATE TABLE if not exists Client(
   client_ID INT AUTO_INCREMENT,
   client_nom VARCHAR(50)  NOT NULL,
   client_prenom VARCHAR(50)  NOT NULL,
   client_tel VARCHAR(13)  NOT NULL,
   client_cp VARCHAR(5)  NOT NULL,
   client_ville varchar(50) NOT NULL,
   client_adresse1 VARCHAR(50)  NOT NULL,
   client_adresse2 VARCHAR(50),
   client_adresse3 VARCHAR(50),
   utilisateur_ID INT NOT NULL,
   PRIMARY KEY(client_ID),
   UNIQUE(utilisateur_ID),
   FOREIGN KEY(utilisateur_ID) REFERENCES Utilisateur(utilisateur_ID)
);

CREATE TABLE if not exists Commande(
   commande_ID INT AUTO_INCREMENT,
   commande_date DATETIME NOT NULL,
   commande_libelle VARCHAR(50)  NOT NULL,
   client_ID INT NOT NULL,
   PRIMARY KEY(commande_ID),
   FOREIGN KEY(client_ID) REFERENCES Client(client_ID)
);
CREATE TABLE if not exists peut_contenir(
   produit_ID INT,
   commande_ID INT,
   quantite INT NOT NULL,
   PRIMARY KEY(produit_ID, commande_ID),
   FOREIGN KEY(produit_ID) REFERENCES Produit(produit_ID),
   FOREIGN KEY(commande_ID) REFERENCES Commande(commande_ID)
);

-- CATEGORIE
INSERT INTO categorie (categorie_libelle) VALUES
('Entres');
INSERT INTO categorie (categorie_libelle) VALUES
('Plats');
INSERT INTO categorie (categorie_libelle) VALUES
('Accompagnements');
INSERT INTO categorie(categorie_libelle) VALUES
('Desserts');
INSERT INTO categorie (categorie_libelle) VALUES
('Plat du jour');
INSERT INTO categorie (categorie_libelle) VALUES
('Boissons');

-- PRODUIT

INSERT INTO `produit` (`produit_ID`, `produit_libelle`, `produit_prix`, `produit_image`, `produit_description`, `categorie_ID`) VALUES
(1, 'Velouté de Topinambours à la Truffe Noire', 18, NULL, 'Une crème veloutée onctueuse sublimée par des lamelles de truffe noire.', 1),
(2, 'Carpaccio de Saint-Jacques et Caviar', 22, NULL, 'Fines tranches de Saint-Jacques avec une touche de caviar Osciètre et une vinaigrette citronnée.', 1),
(3, 'Foie Gras de Canard Maison, Chutney de Figues', 22, NULL, 'Foie gras mariné et cuit lentement, servi avec un chutney de figues et un pain brioché.', 1),
(4, 'Tartare de Langoustines, Espuma de Citron Vert', 20, NULL, 'Langoustines fraîches finement hachées, accompagnées d\'une mousse légère au citron vert et d\'une tuile croustillante au sésame noir.', 1),
(5, 'Filet de Bœuf Rossini', 38, NULL, 'Filet de bœuf tendre avec foie gras poêlé, sauce Périgueux, et pommes Anna.', 2),
(6, 'Homard Bleu au Beurre Blanc Safrané', 45, NULL, 'Demi-homard bleu rôti accompagné d’un beurre blanc infusé au safran et d\'un risotto crémeux.', 2),
(7, 'Bar Sauvage en Croûte de Sel', 34, NULL, 'Bar sauvage cuit en croûte de sel, servi avec une purée de céleri et une émulsion citronnée.', 2),
(8, 'Ris de Veau Rôti aux Morilles', 40, NULL, 'Ris de veau délicatement rôti, accompagné de morilles fraîches et d’une sauce crème.', 2),
(9, 'Délice de pain aux figues', 0, NULL, 'Tranche de pain offert pour accompagner vos entrées', 3),
(10, 'Délice de pain au noix', 0, NULL, 'Tranche de pain toasté pour accompagner vos entrées', 3),
(11, 'Potatoes de patate douce', 5, NULL, 'Potatoes de patate douce cuit en deux fois', 3),
(12, 'Potatoes de pomme de terre La Bonotte', 5, NULL, 'Délicieuse pomme de terre, selection La Bonotte, choisi par nos cuisinier', 3),
(13, 'Riz parfumés', 6, NULL, 'Sompteux riz parfumée au safran avec un zeste de citron pour plus de saveur', 3),
(14, 'Sphère Chocolatée, Cœur Coulant de Caramel', 12, NULL, 'Une sphère en chocolat fondant dévoilant un caramel liquide et une glace vanille.', 4),
(15, 'Tarte Fine aux Pommes et Glace au Calvados', 11, NULL, 'Pâte feuilletée croustillante avec de fines tranches de pomme et une boule de glace au Calvados.', 4),
(16, 'Soufflé Grand Marnier', 15, NULL, 'Soufflé aérien et léger, subtilement parfumé au Grand Marnier.', 3),
(17, 'Assiette Gourmande de Fromages Affinés', 20, NULL, 'Sélection de quatre fromages français accompagnée d’un chutney et de fruits secs.', 3),
(18, 'Salade de fruits et sa chantilly', 9, NULL, 'Salade de fruits de saison avec sa crème chantilly', 3),
(19, 'Ravioles Maison aux Truffes et Ricotta', 38, NULL, 'Ravioles fraîches farcies de ricotta crémeuse et de truffes, nappées d\'un beurre noisette et d\'une touche de parmesan.', 5),
(20, 'Saint-Pierre Poêlé, Beurre d\'Ail et Ciboulette', 42, NULL, 'Filet de Saint-Pierre poêlé, servi avec un beurre d\'ail et ciboulette, accompagné de légumes grillés et de pommes de terre fondantes.', 5),
(21, 'Caviar d\'Aubergine et Foie Gras Poêlé sur Brioche ', 65, NULL, 'Un mariage audacieux de caviar d\'aubergine crémeux et de foie gras poêlé, sur une brioche toastée légèrement beurrée, accompagné d\'une sauce balsamique réduite.', 5),
(22, 'Tartare de Saint-Jacques, Perles de Yuzu et Caviar', 72, NULL, 'Tartare de Saint-Jacques fraîches agrémenté de perles de yuzu, parsemé de caviar, et accompagné d\'une émulsion légère de citron vert.', 5),
(23, 'Mojito', 8, NULL, 'Rhum blanc, menthe fraîche, sucre de canne, citron vert, eau pétillante.', 6),
(24, 'Margarita', 8, NULL, 'Tequila, triple sec (Cointreau), lime, sel pour le rebord du verre.', 6),
(25, 'Cosmopolitan', 10, NULL, 'Vodka, triple sec, cranberry (jus de canneberge), lime.', 6),
(26, 'Chardonnay (Bourgogne)', 60, NULL, 'Un vin blanc rond et complexe avec des notes de fruits jaunes et parfois de beurre ou de noisette, souvent élevé en fût de chêne.', 6),
(27, 'Chenin Blanc (Vouvray, Loire)', 65, NULL, 'Un vin blanc complexe, offrant des arômes de fruits à chair blanche, de miel et une belle minéralité.', 6),
(28, 'Pinot Noir (Bourgogne)', 70, NULL, 'Un vin élégant, avec des arômes de fruits rouges et une belle finesse en bouche', 6),
(29, 'Tempranillo (Rioja, Espagne)', 57, NULL, 'Un vin espagnol avec des arômes de cerise, de prune, et des nuances de cuir et de tabac, souvent vieilli en fût de chêne.', 6),
(30, 'Champagne Brut (Moët & Chandon, Veuve Clicquot, Do', 150, NULL, 'Un champagne sec, avec des arômes de fruits blancs, de brioche et de noisette, parfait pour l\'apéritif ou avec des fruits de mer.', 6),
(31, 'Champagne Rosé', 110, NULL, 'Un champagne avec des arômes de fruits rouges et une belle vivacité, idéal pour des moments festifs.', 6),
(32, 'Coca Cola', 5, NULL, 'Basics, Cherry, Zero', 6),
(33, 'Schweppes', 5, NULL, 'Agrume, Tonic, Pomme', 6),
(34, 'Ice Tea', 5, NULL, 'Pêche, Pêche framboise, Citron', 6),
(35, 'Jus de fruits', 5, NULL, 'Banane, Mangue, Fraise, Abricot', 6),
(36, 'San pelegrino demi', 4, NULL, 'un demi litre', 6),
(37, 'San pelegrino', 5, NULL, '1L', 6),
(38, 'Fiji', 7, NULL, '1L', 6),
(39, 'Evian', 5, NULL, '1L', 6);

-- TYPE
INSERT INTO `type` (`type_ID`, `type_libelle`) VALUES
(1, 'admin'),
(2, 'client'),
(3, 'commercial');

-- UTILISATEUR
INSERT INTO `utilisateur` (`utilisateur_ID`, `utilisateur_pseudo`, `utlisateur_email`, `utilisateur_password`, `type_ID`) VALUES
(1, 'StarGazer99', 'stargazer99@example.com', 'abc', 1),
(2, 'BookWorm42', 'bookworm42@example.com', 'def', 2),
(3, 'TechGuru88', 'techguru88@example.com', 'ghi', 3),
(4, 'ArtLover21', 'artlover21@example.com', 'Paint&Create21', 2),
(5, 'MusicMaestro77', 'musicmaestro77@example.com', 'Melody!Magic77', 2);

-- CLIENT
INSERT INTO `Client` (`client_ID`, `client_nom`, `client_prenom`, `client_tel`, `client_cp`, `client_ville`, `client_adresse1`, `client_adresse2`, `client_adresse3`, `utilisateur_ID`) VALUES
(1, 'Pierre', 'Dubois', '+33612345678', '75001', 'Paris', '10 Rue de Rivoli', 'Apt 3B', null, 1),
(2, 'Marie', 'Lefevre', '+33698765432', '69002', 'Lyon', '25 Rue Victor Hugo', 'Floor 2', null, 2),
(3, 'Jean', 'Martin', '+33623456789', '13001', 'Marseille', '5 Boulevard Longchamp', 'Suite 101', null, 3),
(4, 'Sophie', 'Bernard', '+33687654321', '06000', 'Nice', '15 Avenue Jean Médecin', 'Building A', null, 4),
(5, 'Luc', 'Moreau', '+33654321098', '44000', 'Nantes', '20 Rue Crébillon', 'Apt 4C', null, 5);

-- COMMANDE
INSERT INTO `commande` (`commande_ID`, `commande_date`, `commande_libelle`, `client_ID`) VALUES
(1, '2024-12-01 14:30:00', "En cours de validation", 1),
(2, '2024-12-05 09:15:00', "En cours de préparation", 2),
(3, '2024-12-10 18:45:00', "En cours de livraison", 3),
(4, '2024-12-15 11:00:00', "Livré", 4),
(5, '2024-12-20 16:20:00', "En cours de préparation", 5);

-- PEUT CONTENIR
INSERT INTO peut_contenir (`produit_ID`,`commande_ID`, `quantite`) VALUES (1, 1, 2);
INSERT INTO peut_contenir (`produit_ID`,`commande_ID`, `quantite`) VALUES (2, 2, 5);
INSERT INTO peut_contenir (`produit_ID`,`commande_ID`, `quantite`) VALUES (3, 3, 8);
INSERT INTO peut_contenir (`produit_ID`,`commande_ID`, `quantite`) VALUES (4, 4, 7);
INSERT INTO peut_contenir (`produit_ID`,`commande_ID`, `quantite`) VALUES (5, 5, 10);