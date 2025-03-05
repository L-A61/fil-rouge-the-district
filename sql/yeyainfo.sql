-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 03 mars 2025 à 01:29
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
-- Base de données : `yeyainfo`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `categorie_ID` int(11) NOT NULL,
  `categorie_libelle` varchar(50) NOT NULL,
  `categorie_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`categorie_ID`, `categorie_libelle`, `categorie_image`) VALUES
(1, 'Ordinateur Portable', 'Portable1.jpg'),
(2, 'Ordinateur de Bureau', 'OrdinateurBureau.png'),
(3, 'Logiciel', 'logiciel.WEBP'),
(4, 'Imprimantes et Accessoires', 'photo15.jpg'),
(5, 'Téléphones et Tablettes', 'accessoires.png'),
(6, 'Ecran PC', 'ecran.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `client_ID` int(11) NOT NULL,
  `client_nom` varchar(50) NOT NULL,
  `client_prenom` varchar(50) NOT NULL,
  `client_tel` varchar(13) NOT NULL,
  `client_cp` varchar(5) NOT NULL,
  `client_ville` varchar(50) NOT NULL,
  `client_adresse1` varchar(50) NOT NULL,
  `client_adresse2` varchar(50) DEFAULT NULL,
  `client_adresse3` varchar(50) DEFAULT NULL,
  `utilisateur_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`client_ID`, `client_nom`, `client_prenom`, `client_tel`, `client_cp`, `client_ville`, `client_adresse1`, `client_adresse2`, `client_adresse3`, `utilisateur_ID`) VALUES
(24, 'guillaume', 'lacroix', '+331111111111', '76000', 'ROUEN', 'adresse', 'adresse2', 'adresse3', 2),
(25, 'nom3', 'prénom3', '+330627023102', '12345', 'ville3', 'adresse', '', '', 3),
(26, 'nom1', 'prénom1', '+330202020202', '12345', 'ville1', 'adresse', 'adresse2', 'adresse3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `commande_ID` int(11) NOT NULL,
  `commande_date` datetime NOT NULL,
  `commande_libelle` varchar(50) NOT NULL,
  `client_ID` int(11) NOT NULL,
  `commande_quantite` int(11) DEFAULT NULL,
  `commande_prix` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`commande_ID`, `commande_date`, `commande_libelle`, `client_ID`, `commande_quantite`, `commande_prix`) VALUES
(149, '2025-03-06 10:23:05', 'Ordinateur Portable', 25, 10, 400.00),
(150, '2025-03-06 10:23:05', 'Apple iMac M3 (2023) 24 8 Go 256 Go Bleu (MQRQ3FNA', 25, 2, 1960.00),
(151, '2025-03-06 10:23:05', 'Altyk Le Grand PC Entreprise P1-I716-N05', 25, 1, 500.00),
(152, '2025-03-06 10:23:05', 'Antivol universel pour tablette 7,10', 25, 1, 45.00),
(153, '2025-03-06 10:23:05', 'Apple MacBook Air M2 13 pouces (2022) Argent 16 Go', 25, 1, 2034.00),
(154, '2025-03-06 10:23:05', 'Acer AOpen QF15a', 25, 1, 455.00),
(155, '2025-03-06 10:23:05', 'ASUS ExpertCenter D5 Mini Tour D500MDCZ-312100027X', 24, 1, 300.00),
(156, '2025-03-06 10:23:05', 'Apple iPhone 16 128 Go Noir', 24, 1, 400.00),
(157, '2025-03-06 10:23:05', 'Apple iPhone 14 512 Go (PRODUCT)RED', 24, 1, 200.00),
(158, '2025-03-06 10:23:05', 'Belkin Station d\'accueil GaN USB-C 11-en-1 Dock Co', 24, 1, 34.00),
(159, '2025-02-06 16:16:59', 'Brother MFC-L6910DN', 24, 1, 760.00),
(160, '2025-02-06 16:18:36', 'Fox Spirit 27 LED  PGM270 V2', 26, 1, 218.00),
(161, '2025-03-06 10:23:05', 'Ergotron Stand Neo-Flex', 26, 1, 40.00),
(162, '2025-03-06 10:23:05', 'Belkin Station d\'accueil GaN USB-C 6-en-1 Dock Cor', 26, 1, 75.00),
(163, '2025-03-06 10:23:05', 'Creality Capot anti-bruit pour Ender 3 Series', 26, 1, 811.00),
(164, '2025-03-06 10:23:05', 'Brother MFC-J6955DW', 26, 1, 60.00);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `favori_ID` int(11) NOT NULL,
  `utilisateur_ID` int(11) NOT NULL,
  `produit_ID` int(11) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `peut_contenir`
--

CREATE TABLE `peut_contenir` (
  `produit_ID` int(11) NOT NULL,
  `commande_ID` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `produit_ID` int(11) NOT NULL,
  `produit_libelle` varchar(50) NOT NULL,
  `produit_prix` decimal(19,2) NOT NULL,
  `produit_image` varchar(50) DEFAULT NULL,
  `produit_description` varchar(500) NOT NULL,
  `categorie_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`produit_ID`, `produit_libelle`, `produit_prix`, `produit_image`, `produit_description`, `categorie_ID`) VALUES
(1, 'Ordinateur Portable', 400.00, 'photo.jpg', 'HP EliteOne 870 G9 (A0ZA5EA).', 1),
(2, 'Apple iMac M3 (2023) 24 8 Go 256 Go Bleu (MQRQ3FNA', 1960.00, 'photo2.jpg', 'Apple iMac M3 (2023) 24 8 Go 256 Go Bleu (MQRQ3FNA)', 1),
(3, 'Altyk Le Grand PC Entreprise P1-I716-N05', 500.00, 'photo3.jpg', 'Altyk Le Grand PC Entreprise P1-I716-N05', 1),
(4, 'Antivol universel pour tablette 7,10', 20.00, 'photo4.jpg', 'Antivol universel pour tablette 7,10', 1),
(5, 'Apple MacBook Air M2 13 pouces (2022) Argent 16 Go', 2034.00, 'photo5.jpg', 'Apple MacBook Air M2 13 pouces (2022) Argent 16 Go256 Go (MC7V4FNA)', 2),
(6, 'Acer AOpen QF15a', 455.00, 'photo6.jpeg', 'Acer AOpen QF15a', 2),
(7, 'ASUS ExpertCenter D5 Mini Tour D500MDCZ-312100027X', 300.00, 'photo7.jpg', 'ASUS ExpertCenter D5 Mini Tour D500MDCZ-312100027X', 2),
(8, 'Apple iPhone 16 128 Go Noir', 400.00, 'photo8.jpeg', 'Apple iPhone 16 128 Go Noir', 2),
(9, 'Apple iPhone 14 512 Go (PRODUCT)RED', 200.00, 'photo9.jpg', 'Apple iPhone 14 512 Go (PRODUCT)RED', 3),
(10, 'Belkin Station d\'accueil GaN USB-C 11-en-1 Dock Co', 34.00, 'photo10.jpg', 'Belkin Station d\'accueil GaN USB-C 11-en-1 Dock Core (150W)', 3),
(11, 'Brother MFC-L6910DN', 760.00, 'photo11.jpg', 'Brother MFC-L6910DN', 3),
(12, 'Fox Spirit 27 LED  PGM270 V2', 5.00, 'photo12.jpg', 'Fox Spirit 27 LED  PGM270 V2', 3),
(13, 'Ergotron Stand Neo-Flex', 218.00, 'photo13.jpg', 'Ergotron Stand Neo-Flex', 3),
(14, 'Belkin Station d\'accueil GaN USB-C 6-en-1 Dock Cor', 75.00, 'photo14.jpg', 'Belkin Station d\'accueil GaN USB-C 6-en-1 Dock Core (130W)', 4),
(15, 'Creality Capot anti-bruit pour Ender 3 Series', 811.00, 'photo15.jpg', 'Creality Capot anti-bruit pour Ender 3 Series', 4),
(16, 'Brother MFC-J6955DW', 60.00, 'photo16.jpg', 'Brother MFC-J6955DW', 3),
(17, '3M BP133W1E1', 299.00, 'photo17.jpg', '3M BP133W1E1', 3),
(18, 'Petit PC Altyk F2-N30516-N05 est un PC de bureau s', 342.00, 'photo18.jpg', 'Petit PC Altyk F2-N30516-N05 est un PC de bureau simple et efficace', 3),
(19, 'Brother MFC-L8900CDW', 838.00, 'photo19.jpg', 'Brother MFC-L8900CDW.', 5),
(20, 'Creality Halot-Mage S 14K', 442.00, 'photo20.jpg', 'Creality Halot-Mage S 14K', 5),
(21, 'Apple iPhone 15 Plus 128 Go Vert1', 897.00, 'photo21.jpeg', 'Apple iPhone 15 Plus 128 Go Vert1', 5),
(22, 'LDLC PC11 Bazooka Gen 12', 720.00, 'photo22.jpg', 'LDLC PC11 Bazooka Gen 12', 5),
(23, 'Apple iPhone 13 128 Go Lumière Stellaire', 238.00, 'photo23.jpg', 'Apple iPhone 13 128 Go Lumière Stellaire', 6),
(24, 'ASUS ROG NUC RNUC14SRKU7168A2I', 812.00, 'photo24.jpg', 'ASUS ROG NUC RNUC14SRKU7168A2I', 6),
(25, 'Clavier pour PC portable LDLC Saturne SB6', 34.00, 'photo25.jpg', 'Clavier pour PC portable LDLC Saturne SB6', 6),
(26, 'Brother DCP-1610W', 160.00, 'photo26.jpg', 'Brother DCP-1610W.', 6),
(27, 'LDLC PC Perfect Gen15 Seven-Ti', 465.00, 'photo27.jpg', 'LDLC PC Perfect Gen15 Seven-Ti', 6),
(28, 'LDLC PC ART', 370.00, 'photo28.jpeg', 'LDLC PC ART', 6),
(29, 'HP Pro 400 G9 (99P70ET)', 57.00, 'photo29.jpg', 'HP Pro 400 G9 (99P70ET)', 6),
(30, 'tablette', 150.00, 'photo30.jpg', 'tablette.', 6),
(31, 'HP EliteOne 870 G9 (A0ZA5EA)', 610.00, 'photo31.jpg', 'HP EliteOne 870 G9 (A0ZA5EA)', 6),
(32, 'Brother MFC-L8690CDW + TN-421', 1200.00, 'photo32.jpg', 'Brother MFC-L8690CDW + TN-421', 6),
(33, 'Mac book', 1890.00, 'photo33.jpg', 'Mac book', 6),
(34, 'LDLC PC Plus Perfect DDR5', 322.00, 'photo34.jpg', 'LDLC PC Plus Perfect DDR5', 6),
(35, 'LDLC PC CHALLENGER Powered By ASUS', 545.00, 'photo35.jpg', 'LDLC PC CHALLENGER Powered By ASUS', 6),
(36, 'Lenovo ThinkSystem ST250 V3 (7DCEA02WEA)', 666.00, 'photo36.jpg', 'Lenovo ThinkSystem ST250 V3 (7DCEA02WEA)', 6),
(37, 'Performance et confort de travail', 760.00, 'photo37.jpg', 'Performance et confort de travail', 6),
(38, 'Brother MFC-L2800DW', 237.00, 'photo38.jpg', 'Brother MFC-L2800DW', 6),
(39, 'computer', 555.00, 'photo39.jpg', 'computer', 6);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `type_ID` int(11) NOT NULL,
  `type_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `utilisateur` (
  `utilisateur_ID` int(11) NOT NULL,
  `utilisateur_pseudo` varchar(50) NOT NULL,
  `utilisateur_email` varchar(50) DEFAULT NULL,
  `utilisateur_password` varchar(255) DEFAULT NULL,
  `type_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_ID`, `utilisateur_pseudo`, `utilisateur_email`, `utilisateur_password`, `type_ID`) VALUES
(1, 'testAdmin', 'testAdmin@test.com', '$2y$10$vebp.l.r47lvCQbxgK/jx.gR1IBhj5yphYNQ43I459NmOEQZIBtyO', 1),
(2, 'testClient', 'testClient@test.com', '$2y$10$GgX1S.nFu5p8rEEIhHBtRu27Cc0Sl4Dwkk/m/6qYyiKrzyMLHdJI2', 2),
(3, 'testCommercial', 'testCommercial@test.com', '$2y$10$kifzwjRDY1N3savszLOkNuVIVDUXTbsbz7WQzV83sLfppyCbyflta', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_ID`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_ID`),
  ADD UNIQUE KEY `utilisateur_ID` (`utilisateur_ID`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`commande_ID`),
  ADD KEY `client_ID` (`client_ID`);

--
-- Index pour la table `peut_contenir`
--
ALTER TABLE `peut_contenir`
  ADD PRIMARY KEY (`produit_ID`,`commande_ID`),
  ADD KEY `commande_ID` (`commande_ID`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`produit_ID`),
  ADD KEY `categorie_ID` (`categorie_ID`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_ID`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`utilisateur_ID`),
  ADD KEY `type_ID` (`type_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `client_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `commande_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `produit_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `utilisateur_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
