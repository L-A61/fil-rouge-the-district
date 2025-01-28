-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 28 jan. 2025 à 16:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `thedistrict`
--
CREATE DATABASE IF NOT EXISTS `thedistrict` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `thedistrict`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_ID` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_libelle` varchar(50) NOT NULL,
  `categorie_image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categorie_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`categorie_ID`, `categorie_libelle`, `categorie_image`) VALUES
(1, 'Entrées', 'Entrée.jpg'),
(2, 'Plats', 'fiche-produit-boeuf-noel-1024x751.png'),
(3, 'Accompagnements', 'recettes d\'accompagnement.jpg'),
(4, 'Desserts', 'photo15.jpg'),
(5, 'Plats du jour', 'photo6.jpeg'),
(6, 'Boissons', 'Cosmopolitan.webp');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `client_ID` int(11) NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(50) NOT NULL,
  `client_prenom` varchar(50) NOT NULL,
  `client_tel` varchar(13) NOT NULL,
  `client_cp` varchar(5) NOT NULL,
  `client_ville` varchar(50) NOT NULL,
  `client_adresse1` varchar(50) NOT NULL,
  `client_adresse2` varchar(50) DEFAULT NULL,
  `client_adresse3` varchar(50) DEFAULT NULL,
  `utilisateur_ID` int(11) NOT NULL,
  PRIMARY KEY (`client_ID`),
  UNIQUE KEY `utilisateur_ID` (`utilisateur_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `commande_ID` int(11) NOT NULL AUTO_INCREMENT,
  `commande_date` datetime NOT NULL,
  `commande_libelle` varchar(50) NOT NULL,
  `client_ID` int(11) NOT NULL,
  PRIMARY KEY (`commande_ID`),
  KEY `client_ID` (`client_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `peut_contenir`
--

DROP TABLE IF EXISTS `peut_contenir`;
CREATE TABLE IF NOT EXISTS `peut_contenir` (
  `produit_ID` int(11) NOT NULL,
  `commande_ID` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`produit_ID`,`commande_ID`),
  KEY `commande_ID` (`commande_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `produit_ID` int(11) NOT NULL AUTO_INCREMENT,
  `produit_libelle` varchar(50) NOT NULL,
  `produit_prix` decimal(19,2) NOT NULL,
  `produit_image` varchar(50) DEFAULT NULL,
  `produit_description` varchar(500) NOT NULL,
  `categorie_ID` int(11) NOT NULL,
  PRIMARY KEY (`produit_ID`),
  KEY `categorie_ID` (`categorie_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`produit_ID`, `produit_libelle`, `produit_prix`, `produit_image`, `produit_description`, `categorie_ID`) VALUES
(1, 'Velouté de Topinambours à la Truffe Noire', 18.00, 'Velouté de Topinambours à la Truffe Noire.jpg', 'Une crème veloutée onctueuse sublimée par des lamelles de truffe noire.', 1),
(2, 'Carpaccio de Saint-Jacques et Caviar', 22.00, 'photo2.jpg', 'Fines tranches de Saint-Jacques avec une touche de caviar Osciètre et une vinaigrette citronnée.', 1),
(3, 'Foie Gras de Canard Maison, Chutney de Figues', 22.00, 'photo3.webp', 'Foie gras mariné et cuit lentement, servi avec un chutney de figues et un pain brioché.', 1),
(4, 'Tartare de Langoustines, Espuma de Citron Vert', 20.00, 'photo4.webp', 'Langoustines fraîches finement hachées, accompagnées d\'une mousse légère au citron vert et d\'une tuile croustillante au sésame noir.', 1),
(5, 'Filet de Bœuf Rossini', 38.00, 'photo5.jpg', 'Filet de bœuf tendre avec foie gras poêlé, sauce Périgueux, et pommes Anna.', 2),
(6, 'Homard Bleu au Beurre Blanc Safrané', 45.00, 'photo6.jpeg', 'Demi-homard bleu rôti accompagné d’un beurre blanc infusé au safran et d\'un risotto crémeux.', 2),
(7, 'Bar Sauvage en Croûte de Sel', 34.00, 'photo7.jpg', 'Bar sauvage cuit en croûte de sel, servi avec une purée de céleri et une émulsion citronnée.', 2),
(8, 'Ris de Veau Rôti aux Morilles', 40.00, 'photo8.jpeg', 'Ris de veau délicatement rôti, accompagné de morilles fraîches et d’une sauce crème.', 2),
(9, 'Délice de pain aux figues', 0.00, 'photo9.png', 'Tranche de pain offert pour accompagner vos entrées', 3),
(10, 'Délice de pain au noix', 0.00, 'photo10.jpg', 'Tranche de pain toasté pour accompagner vos entrées', 3),
(11, 'Potatoes de patate douce', 5.00, 'photo11.jpg', 'Potatoes de patate douce cuit en deux fois', 3),
(12, 'Potatoes de pomme de terre La Bonotte', 5.00, 'photo12.jpg', 'Délicieuse pomme de terre, selection La Bonotte, choisi par nos cuisinier', 3),
(13, 'Riz parfumés', 6.00, 'photo13.jpg', 'Sompteux riz parfumée au safran avec un zeste de citron pour plus de saveur', 3),
(14, 'Sphère Chocolatée, Cœur Coulant de Caramel', 12.00, 'photo14.jpg', 'Une sphère en chocolat fondant dévoilant un caramel liquide et une glace vanille.', 4),
(15, 'Tarte Fine aux Pommes et Glace au Calvados', 11.00, 'photo15.jpg', 'Pâte feuilletée croustillante avec de fines tranches de pomme et une boule de glace au Calvados.', 4),
(16, 'Soufflé Grand Marnier', 15.00, 'photo16.jpg', 'Soufflé aérien et léger, subtilement parfumé au Grand Marnier.', 3),
(17, 'Assiette Gourmande de Fromages Affinés', 20.00, 'photo17.jpg', 'Sélection de quatre fromages français accompagnée d’un chutney et de fruits secs.', 3),
(18, 'Salade de fruits et sa chantilly', 9.00, 'photo18.jpg', 'Salade de fruits de saison avec sa crème chantilly', 3),
(19, 'Ravioles Maison aux Truffes et Ricotta', 38.00, 'photo19.jpg', 'Ravioles fraîches farcies de ricotta crémeuse et de truffes, nappées d\'un beurre noisette et d\'une touche de parmesan.', 5),
(20, 'Saint-Pierre Poêlé, Beurre d\'Ail et Ciboulette', 42.00, 'photo20.webp', 'Filet de Saint-Pierre poêlé, servi avec un beurre d\'ail et ciboulette, accompagné de légumes grillés et de pommes de terre fondantes.', 5),
(21, 'Caviar d\'Aubergine et Foie Gras Poêlé sur Brioche ', 65.00, 'photo21.jpeg', 'Un mariage audacieux de caviar d\'aubergine crémeux et de foie gras poêlé, sur une brioche toastée légèrement beurrée, accompagné d\'une sauce balsamique réduite.', 5),
(22, 'Tartare de Saint-Jacques, Perles de Yuzu et Caviar', 72.00, 'photo22.jpg', 'Tartare de Saint-Jacques fraîches agrémenté de perles de yuzu, parsemé de caviar, et accompagné d\'une émulsion légère de citron vert.', 5),
(23, 'Mojito', 8.00, 'photo23.jpg', 'Rhum blanc, menthe fraîche, sucre de canne, citron vert, eau pétillante.', 6),
(24, 'Margarita', 8.00, 'photo24.webp', 'Tequila, triple sec (Cointreau), lime, sel pour le rebord du verre.', 6),
(25, 'Cosmopolitan', 10.00, 'photo25.jpg', 'Vodka, triple sec, cranberry (jus de canneberge), lime.', 6),
(26, 'Chardonnay (Bourgogne)', 60.00, 'photo26.png', 'Un vin blanc rond et complexe avec des notes de fruits jaunes et parfois de beurre ou de noisette, souvent élevé en fût de chêne.', 6),
(27, 'Chenin Blanc (Vouvray, Loire)', 65.00, 'photo27.webp', 'Un vin blanc complexe, offrant des arômes de fruits à chair blanche, de miel et une belle minéralité.', 6),
(28, 'Pinot Noir (Bourgogne)', 70.00, 'photo28.jpeg', 'Un vin élégant, avec des arômes de fruits rouges et une belle finesse en bouche', 6),
(29, 'Tempranillo (Rioja, Espagne)', 57.00, 'photo29.webp', 'Un vin espagnol avec des arômes de cerise, de prune, et des nuances de cuir et de tabac, souvent vieilli en fût de chêne.', 6),
(30, 'Champagne Brut (Moët & Chandon, Veuve Clicquot, Do', 150.00, 'photo30.jpg', 'Un champagne sec, avec des arômes de fruits blancs, de brioche et de noisette, parfait pour l\'apéritif ou avec des fruits de mer.', 6),
(31, 'Champagne Rosé', 110.00, 'photo31.jpg', 'Un champagne avec des arômes de fruits rouges et une belle vivacité, idéal pour des moments festifs.', 6),
(32, 'Coca Cola', 5.00, 'photo32.webp', 'Basics, Cherry, Zero', 6),
(33, 'Schweppes', 5.00, 'photo33.webp', 'Agrume, Tonic, Pomme', 6),
(34, 'Ice Tea', 5.00, 'photo34.webp', 'Pêche, Pêche framboise, Citron', 6),
(35, 'Jus de fruits', 5.00, 'photo35.webp', 'Banane, Mangue, Fraise, Abricot', 6),
(36, 'San pelegrino demi', 4.00, 'photo36.webp', 'un demi litre', 6),
(37, 'San pelegrino', 5.00, 'photo37.jpg', '1L', 6),
(38, 'Fiji', 7.00, 'photo38.webp', '1L', 6),
(39, 'Evian', 5.00, 'photo39.jpg', '1L', 6);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `type_ID` int(11) NOT NULL AUTO_INCREMENT,
  `type_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`type_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`type_ID`, `type_libelle`) VALUES
(1, 'admin'),
(2, 'client'),
(3, 'commercial');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `utilisateur_ID` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_pseudo` varchar(50) NOT NULL,
  `utilisateur_email` varchar(50) DEFAULT NULL,
  `utilisateur_password` varchar(255) DEFAULT NULL,
  `type_ID` int(11) NOT NULL,
  PRIMARY KEY (`utilisateur_ID`),
  KEY `type_ID` (`type_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_ID`, `utilisateur_pseudo`, `utilisateur_email`, `utilisateur_password`, `type_ID`) VALUES
(9, 'axel', 'axe.lou@gmail.com', '$2y$10$Ypvi9meulWUmNNx2euJogOoa3sl8EuoElPFm1xnd8Di', 1),
(11, 'test', 'test@test.com', '$2y$10$Ie6HVNXxbTu4rS7imv06vOP/CptFlD2Pe1ZMs29LXqtLUyEcQtmM.', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`utilisateur_ID`) REFERENCES `utilisateur` (`utilisateur_ID`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
