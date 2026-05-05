-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 07 oct. 2025 à 15:15
-- Version du serveur : 10.3.39-MariaDB-0+deb10u1
-- Version de PHP : 7.3.31-1~deb10u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `RugbyDIVISION`
--

-- --------------------------------------------------------

--
-- Structure de la table `Arbitre`
--

CREATE TABLE `Arbitre` (
  `idArbitre` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  `nationalite` varchar(50) NOT NULL,
  `categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Arbitre`
--

INSERT INTO `Arbitre` (`idArbitre`, `nom`, `prenom`, `dateNaissance`, `nationalite`, `categorie`) VALUES
(1, 'Attisson', 'Luc', NULL, 'Française', 'Top 14'),
(2, 'Berthezène', 'Pierre', NULL, 'Française', 'Top 14'),
(3, 'Bru', 'Pierre', NULL, 'Française', 'Top 14'),
(4, 'Castets', 'Adrien', NULL, 'Française', 'Top 14'),
(5, 'Charabas', 'Thomas', NULL, 'Française', 'Top 14'),
(6, 'Chaventy', 'Cédric', NULL, 'Française', 'Top 14'),
(7, 'Dumas', 'Alexandre', NULL, 'Française', 'Top 14'),
(8, 'Gauzère', 'Jérôme', NULL, 'Française', 'Top 14'),
(9, 'Gauzins', 'Laurent', NULL, 'Française', 'Top 14'),
(10, 'Giraud', 'Vivien', NULL, 'Française', 'Top 14'),
(11, 'Hernandez', 'Benjamin', NULL, 'Française', 'Top 14'),
(12, 'Méné', 'Ludovic', NULL, 'Française', 'Top 14'),
(13, 'Millotte', 'Maxime', NULL, 'Française', 'Top 14'),
(14, 'Pascal', 'Mathieu', NULL, 'Française', 'Top 14'),
(15, 'Rambaud', 'Pierre-Baptiste', NULL, 'Française', 'Top 14'),
(16, 'Rosich', 'Sylvain', NULL, 'Française', 'Top 14'),
(17, 'Ruhl', 'Tual', NULL, 'Française', 'Top 14');

-- --------------------------------------------------------

--
-- Structure de la table `Club`
--

CREATE TABLE `Club` (
  `idClub` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `anneeCreation` smallint(5) UNSIGNED DEFAULT NULL,
  `idStade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Club`
--

INSERT INTO `Club` (`idClub`, `nom`, `ville`, `anneeCreation`, `idStade`) VALUES
(1, 'Aviron Bayonnais', 'Bayonne', 1904, 1),
(2, 'Union Bordeaux-Bègles', 'Bordeaux', 2006, 2),
(3, 'Castres Olympique', 'Castres', 1898, 3),
(4, 'ASM Clermont Auvergne', 'Clermont-Ferrand', 1911, 4),
(5, 'La Rochelle', 'La Rochelle', 1898, 5),
(6, 'LOU Rugby', 'Lyon', 1896, 6),
(7, 'Montpellier Hérault Rugby', 'Montpellier', 1986, 7),
(8, 'Section Paloise', 'Pau', 1902, 8),
(9, 'USA Perpignan', 'Perpignan', 1902, 9),
(10, 'Racing 92', 'Nanterre', 1882, 10),
(11, 'Stade Français Paris', 'Paris', 1883, 11),
(12, 'RC Toulon', 'Toulon', 1908, 12),
(13, 'Stade Toulousain', 'Toulouse', 1907, 13),
(14, 'US Montauban', 'Montauban', 1903, 14);

-- --------------------------------------------------------

--
-- Structure de la table `FaitObjetDeTransfert`
--

CREATE TABLE `FaitObjetDeTransfert` (
  `idTransfert` int(11) NOT NULL,
  `idJoueur` int(11) DEFAULT NULL,
  `idClub` int(11) DEFAULT NULL,
  `dateTransfert` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `FaitObjetDeTransfert`
--

INSERT INTO `FaitObjetDeTransfert` (`idTransfert`, `idJoueur`, `idClub`, `dateTransfert`) VALUES
(1, 34, 1, '2023-2024'),
(2, 8, 1, '2024-2025');

-- --------------------------------------------------------

--
-- Structure de la table `Joueur`
--

CREATE TABLE `Joueur` (
  `idJoueur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  `poste` varchar(50) NOT NULL,
  `nationalite` varchar(50) DEFAULT NULL,
  `idClub` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Joueur`
--

INSERT INTO `Joueur` (`idJoueur`, `nom`, `prenom`, `dateNaissance`, `poste`, `nationalite`, `idClub`) VALUES
(1, 'Anscombe', 'Gareth', '1991-05-10', 'Demi d\'ouverture', 'Pays de Galles', 1),
(2, 'Bordelai', 'Andy', '2000-03-29', 'Pilier gauche', 'France', 1),
(3, 'Bosch', 'Facundo', '1991-08-08', 'Talonneur', 'Argentine', 1),
(4, 'Bruni', 'Rodrigo', '1993-09-03', 'Troisième ligne centre', 'Argentine', 1),
(5, 'Calles', 'Ignacio', '1995-10-24', 'Pilier gauche', 'Argentine', 1),
(6, 'Capilla', 'Esteban', '2003-01-05', 'Troisième ligne centre', 'France', 1),
(7, 'Carreras', 'Mateo', '1999-12-17', 'Ailier droit', 'Argentine', 1),
(8, 'Castillon', 'Pierre', '2003-09-20', 'Talonneur', 'France', 1),
(9, 'Chouzenoux', 'Baptiste', '1993-08-07', 'Troisième ligne aile', 'France', 1),
(10, 'Cormenier', 'Swan', '1996-01-18', 'Pilier gauche', 'France', 1),
(11, 'Cotet', 'Pascal', '1993-10-12', 'Pilier droit', 'France', 1),
(12, 'Erbinartegaray', 'Arnaud', '2000-09-16', 'Arrière', 'France', 1),
(13, 'Fischer', 'Alexandre', '1998-01-19', 'Troisième ligne aile', 'France', 1),
(14, 'Fraser', 'Gerard', '1978-11-05', 'Demi de mêlée', 'Nouvelle-Zélande', 1),
(15, 'Germain', 'Baptiste', '2000-11-21', 'Demi de mêlée', 'France', 1),
(16, 'Giudicelli', 'Vincent', '1997-06-25', 'Talonneur', 'France', 1),
(17, 'Habel-Kueffner', 'Giovanni', '1995-01-09', 'Troisième ligne aile', 'France', 1),
(18, 'Hannoun', 'Victor', '2003-08-20', 'Ailier gauche', 'France', 1),
(19, 'Heguy', 'Baptiste', '1998-05-11', 'Troisième ligne aile', 'France', 1),
(20, 'Hodge', 'Reece', '1994-08-26', 'Arrière', 'Australie', 1),
(21, 'Iturria', 'Arthur', '1994-05-13', 'Troisième ligne aile', 'France', 1),
(22, 'Jantjies', 'Herschel', '1996-04-22', 'Demi de mêlée', 'Afrique du Sud', 1),
(23, 'Johnson', 'Ewan', '1999-06-27', 'Deuxième ligne', 'Écosse', 1),
(24, 'Leota', 'Rob', '1997-03-03', 'Deuxième ligne', 'Australie', 1),
(25, 'Machenaud', 'Maxime', '1988-12-30', 'Demi de mêlée', 'France', 1),
(26, 'Maqala', 'Sireli', '2000-03-20', 'Ailier droit', 'Fidji', 1),
(27, 'Martin', 'Lucas', '2002-09-12', 'Talonneur', 'France', 1),
(28, 'Martocq', 'Guillaume', '1999-08-23', 'Trois-quarts centre', 'France', 1),
(29, 'Megdoud', 'Nadir', '1997-03-26', 'Ailier gauche', 'Algérie', 1),
(30, 'Moon', 'Alex', '1996-09-06', 'Deuxième ligne', 'Angleterre', 1),
(31, 'Mori', 'Federico', '2000-10-13', 'Trois-quarts centre', 'Italie', 1),
(32, 'Orabé', 'Yohan', '2002-05-21', 'Arrière', 'France', 1),
(33, 'Paulos', 'Lucas', '1998-01-09', 'Deuxième ligne', 'Argentine', 1),
(34, 'Segonds', 'Joris', '1997-04-06', 'Demi d\'ouverture', 'France', 1),
(35, 'Setiano', 'Emerick', '1996-07-19', 'Pilier droit', 'France', 1),
(36, 'Spring', 'Tom', '2002-08-26', 'Arrière', 'France', 1),
(37, 'Tagi', 'Luke', '1997-06-23', 'Pilier droit', 'Fidji', 1),
(38, 'Tatafu', 'Tevita', '2002-10-13', 'Pilier droit', 'France', 1),
(39, 'Tiberghien', 'Cheikh', '2000-01-08', 'Ailier gauche', 'France', 1),
(40, 'Tuilagi', 'Manu', '1991-05-18', 'Trois-quarts centre', 'Angleterre', 1),
(41, 'Anyanwu', 'Lennox', NULL, 'Arrière / Centre', NULL, 2),
(42, 'Banks', 'George', NULL, 'Arrière', NULL, 2),
(43, 'Cadot', 'Paul', NULL, 'Trois-quarts centre', NULL, 2),
(44, 'Darmon', 'Thomas', NULL, 'Trois-quarts centre', NULL, 2),
(45, 'Hogg', 'Stuart', NULL, 'Arrière', NULL, 2),
(46, 'Martin', 'Arthur', NULL, 'Trois-quarts aile', NULL, 2),
(47, 'Moustin', 'Enzo', NULL, 'Trois-quarts aile', NULL, 2),
(48, 'Ngandebe', 'Gabriel', NULL, 'Ailier', NULL, 2),
(49, 'Piccardo', 'Lucas', NULL, 'Ailier', NULL, 2),
(50, 'Tambwe', 'Madosh', NULL, 'Ailier', NULL, 2),
(51, 'Taofifenua', 'Setareki', NULL, 'Trois-quarts centre', NULL, 2),
(52, 'Vincent', 'Arthur', NULL, 'Trois-quarts centre', NULL, 2),
(53, 'Reus', 'Hugo', NULL, 'Demi d\'ouverture', NULL, 2),
(54, 'Vincent', 'Thomas', NULL, 'Demi d\'ouverture', NULL, 2),
(55, 'Miotti', 'Domingo', NULL, 'Demi d\'ouverture', NULL, 2),
(56, 'Barreau', 'Aurélien', NULL, 'Demi d\'ouverture', NULL, 2),
(57, 'Price', 'Ali', NULL, 'Demi de mêlée', NULL, 2),
(58, 'Coly', 'Léo', NULL, 'Demi de mêlée', NULL, 2),
(59, 'Bernadet', 'Alexis', NULL, 'Demi de mêlée', NULL, 2),
(60, 'Vunipola', 'Billy', NULL, 'Troisième ligne centre', NULL, 2),
(61, 'Gleeson', 'Langi', NULL, 'Troisième ligne centre', NULL, 2),
(62, 'Nouchi', 'Lenni', NULL, 'Troisième ligne aile', NULL, 2),
(63, 'Bécognée', 'Alexandre', NULL, 'Troisième ligne aile', NULL, 2),
(64, 'Camara', 'Yacouba', NULL, 'Troisième ligne aile', NULL, 2),
(65, 'Tauleigne', 'Marco', NULL, 'Troisième ligne centre', NULL, 2),
(66, 'Chalureau', 'Bastien', NULL, 'Deuxième ligne', NULL, 2),
(67, 'Duguid', 'Tyler', NULL, 'Deuxième ligne', NULL, 2),
(68, 'Beard', 'Adam', NULL, 'Deuxième ligne', NULL, 2),
(69, 'Verhaeghe', 'Florian', NULL, 'Deuxième ligne', NULL, 2),
(70, 'Soucouna', 'Youssouf', NULL, 'Deuxième ligne', NULL, 2),
(71, 'Uhila', 'Matthieu', NULL, 'Deuxième ligne', NULL, 2),
(72, 'Uelese', 'Jordan', NULL, 'Talonneur', NULL, 2),
(73, 'Tolofua', 'Christopher', NULL, 'Talonneur', NULL, 2),
(74, 'Abuladze', 'Guram', NULL, 'Pilier', NULL, 2),
(75, 'Akrab', 'Karim', NULL, 'Pilier', NULL, 2),
(76, 'Haouas', 'Mohamed', NULL, 'Pilier droit', NULL, 2),
(77, 'Hounkpatin', 'Dorian', NULL, 'Pilier droit', NULL, 2),
(78, 'Erdocio', 'Titi', NULL, 'Pilier', NULL, 2),
(79, 'Forletta', 'Enzo', NULL, 'Pilier gauche', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `MatchRugby`
--

CREATE TABLE `MatchRugby` (
  `idMatch` int(11) NOT NULL,
  `dateMatch` date NOT NULL,
  `heure` time DEFAULT NULL,
  `scoreDomicile` int(11) DEFAULT NULL,
  `scoreExterieur` int(11) DEFAULT NULL,
  `annee` varchar(50) NOT NULL,
  `division` varchar(50) NOT NULL,
  `idStade` int(11) DEFAULT NULL,
  `idArbitre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `MatchRugby`
--

INSERT INTO `MatchRugby` (`idMatch`, `dateMatch`, `heure`, `scoreDomicile`, `scoreExterieur`, `annee`, `division`, `idStade`, `idArbitre`) VALUES
(1, '2025-09-06', '19:00:00', 47, 24, '2025-2026', 'Top14', 11, NULL),
(2, '2025-09-06', '19:00:00', 19, 26, '2025-2026', 'Top14', 9, NULL),
(3, '2025-09-06', '19:00:00', 15, 17, '2025-2026', 'Top14', 3, NULL),
(4, '2025-09-06', '21:05:00', 32, 7, '2025-2026', 'Top14', 6, NULL),
(5, '2025-09-06', '21:05:00', 17, 27, '2025-2026', 'Top14', 13, NULL),
(6, '2025-09-07', '17:00:00', 24, 34, '2025-2026', 'Top14', 4, NULL),
(7, '2025-09-07', '21:05:00', 23, 18, '2025-2026', 'Top14', 2, NULL),
(8, '2025-09-13', '18:30:00', 18, 25, '2025-2026', 'Top14', 14, NULL),
(9, '2025-09-13', '18:30:00', 26, 23, '2025-2026', 'Top14', 1, NULL),
(10, '2025-09-13', '18:30:00', 34, 10, '2025-2026', 'Top14', 8, NULL),
(11, '2025-09-13', '18:30:00', 23, 20, '2025-2026', 'Top14', 13, NULL),
(12, '2025-09-14', '14:30:00', 31, 13, '2025-2026', 'Top14', 12, NULL),
(13, '2025-09-14', '16:35:00', 44, 32, '2025-2026', 'Top14', 10, NULL),
(14, '2025-09-14', '21:05:00', 19, 23, '2025-2026', 'Top14', 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Oppose`
--

CREATE TABLE `Oppose` (
  `idMatch` int(11) NOT NULL,
  `idClub` int(11) NOT NULL,
  `role` enum('domicile','exterieur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Oppose`
--

INSERT INTO `Oppose` (`idMatch`, `idClub`, `role`) VALUES
(1, 11, 'domicile'),
(1, 14, 'exterieur'),
(2, 1, 'exterieur'),
(2, 9, 'domicile'),
(3, 3, 'domicile'),
(3, 8, 'exterieur'),
(4, 6, 'domicile'),
(4, 10, 'exterieur'),
(5, 7, 'exterieur'),
(5, 13, 'domicile'),
(6, 4, 'domicile'),
(6, 12, 'exterieur'),
(7, 2, 'domicile'),
(7, 5, 'exterieur'),
(8, 6, 'exterieur'),
(8, 14, 'domicile'),
(9, 1, 'domicile'),
(9, 13, 'exterieur'),
(10, 8, 'domicile'),
(10, 11, 'exterieur'),
(11, 5, 'domicile'),
(11, 7, 'exterieur'),
(12, 9, 'exterieur'),
(12, 12, 'domicile'),
(13, 2, 'exterieur'),
(13, 10, 'domicile'),
(14, 3, 'domicile'),
(14, 4, 'exterieur');

-- --------------------------------------------------------

--
-- Structure de la table `Produit_Stat`
--

CREATE TABLE `Produit_Stat` (
  `idJoueur` int(11) NOT NULL,
  `idMatch` int(11) NOT NULL,
  `points` int(11) DEFAULT NULL,
  `essais` int(11) DEFAULT NULL,
  `penalites` int(11) DEFAULT NULL,
  `transformations` int(11) DEFAULT NULL,
  `drops` int(11) NOT NULL,
  `cartonsJaunes` int(11) DEFAULT NULL,
  `cartonsRouges` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Produit_Stat`
--

INSERT INTO `Produit_Stat` (`idJoueur`, `idMatch`, `points`, `essais`, `penalites`, `transformations`, `drops`, `cartonsJaunes`, `cartonsRouges`) VALUES
(1, 2, 0, 0, 0, 0, 0, 0, 0),
(1, 9, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 0, 0, 0, 0, 0, 0, 0),
(2, 9, 0, 0, 0, 0, 0, 0, 0),
(3, 2, 0, 0, 0, 0, 0, 0, 0),
(3, 9, 0, 0, 0, 0, 0, 0, 0),
(4, 2, 5, 1, 0, 0, 0, 0, 0),
(4, 9, 0, 0, 0, 0, 0, 0, 0),
(5, 2, 0, 0, 0, 0, 0, 0, 0),
(5, 9, 0, 0, 0, 0, 0, 0, 0),
(6, 2, 5, 1, 0, 0, 0, 0, 0),
(6, 9, 5, 1, 0, 0, 0, 0, 0),
(7, 2, 0, 0, 0, 0, 0, 0, 0),
(7, 9, 0, 0, 0, 0, 0, 0, 0),
(8, 2, 0, 0, 0, 0, 0, 0, 0),
(8, 9, 0, 0, 0, 0, 0, 0, 0),
(9, 2, 13, 0, 3, 2, 0, 0, 0),
(9, 9, 16, 0, 4, 2, 0, 0, 0),
(10, 2, 0, 0, 0, 0, 0, 0, 0),
(10, 9, 0, 0, 0, 0, 0, 0, 0),
(11, 2, 0, 0, 0, 0, 0, 0, 0),
(11, 9, 0, 0, 0, 0, 0, 0, 0),
(12, 2, 0, 0, 0, 0, 0, 0, 0),
(12, 9, 0, 0, 0, 0, 0, 0, 0),
(13, 2, 0, 0, 0, 0, 0, 0, 0),
(13, 9, 0, 0, 0, 0, 0, 0, 0),
(14, 2, 0, 0, 0, 0, 0, 0, 0),
(14, 9, 0, 0, 0, 0, 0, 0, 0),
(15, 2, 0, 0, 0, 0, 0, 0, 0),
(15, 9, 0, 0, 0, 0, 0, 0, 0),
(16, 2, 0, 0, 0, 0, 0, 0, 0),
(16, 9, 0, 0, 0, 0, 0, 0, 0),
(17, 2, 0, 0, 0, 0, 0, 0, 0),
(17, 9, 0, 0, 0, 0, 0, 0, 0),
(18, 2, 0, 0, 0, 0, 0, 0, 0),
(18, 9, 0, 0, 0, 0, 0, 0, 0),
(19, 2, 0, 0, 0, 0, 0, 0, 0),
(19, 9, 0, 0, 0, 0, 0, 0, 0),
(20, 2, 0, 0, 0, 0, 0, 0, 0),
(20, 9, 0, 0, 0, 0, 0, 0, 0),
(21, 2, 0, 0, 0, 0, 0, 0, 0),
(21, 9, 0, 0, 0, 0, 0, 0, 0),
(22, 2, 0, 0, 0, 0, 0, 0, 0),
(22, 9, 0, 0, 0, 0, 0, 0, 0),
(23, 2, 0, 0, 0, 0, 0, 0, 0),
(23, 9, 0, 0, 0, 0, 0, 0, 0),
(24, 2, 0, 0, 0, 0, 0, 0, 0),
(24, 9, 0, 0, 0, 0, 0, 0, 0),
(25, 2, 0, 0, 0, 0, 0, 0, 0),
(25, 9, 0, 0, 0, 0, 0, 0, 0),
(26, 2, 0, 0, 0, 0, 0, 0, 0),
(26, 9, 5, 1, 0, 0, 0, 0, 0),
(27, 2, 0, 0, 0, 0, 0, 0, 0),
(27, 9, 0, 0, 0, 0, 0, 0, 0),
(28, 2, 0, 0, 0, 0, 0, 0, 0),
(28, 9, 0, 0, 0, 0, 0, 0, 0),
(29, 2, 0, 0, 0, 0, 0, 0, 0),
(29, 9, 0, 0, 0, 0, 0, 0, 0),
(30, 2, 0, 0, 0, 0, 0, 0, 0),
(30, 9, 0, 0, 0, 0, 0, 0, 0),
(31, 2, 0, 0, 0, 0, 0, 0, 0),
(31, 9, 0, 0, 0, 0, 0, 0, 0),
(32, 2, 0, 0, 0, 0, 0, 0, 0),
(32, 9, 0, 0, 0, 0, 0, 0, 0),
(33, 2, 0, 0, 0, 0, 0, 0, 0),
(33, 9, 0, 0, 0, 0, 0, 0, 0),
(34, 2, 3, 0, 1, 0, 0, 0, 0),
(34, 9, 0, 0, 0, 0, 0, 0, 0),
(35, 2, 0, 0, 0, 0, 0, 0, 0),
(35, 9, 0, 0, 0, 0, 0, 0, 0),
(36, 2, 0, 0, 0, 0, 0, 0, 0),
(36, 9, 0, 0, 0, 0, 0, 0, 0),
(37, 2, 0, 0, 0, 0, 0, 0, 0),
(37, 9, 0, 0, 0, 0, 0, 0, 0),
(38, 2, 0, 0, 0, 0, 0, 0, 0),
(38, 9, 0, 0, 0, 0, 0, 0, 0),
(39, 2, 0, 0, 0, 0, 0, 0, 0),
(39, 9, 0, 0, 0, 0, 0, 0, 0),
(40, 2, 0, 0, 0, 0, 0, 0, 0),
(40, 9, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Saison`
--

CREATE TABLE `Saison` (
  `annee` varchar(50) NOT NULL,
  `division` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Saison`
--

INSERT INTO `Saison` (`annee`, `division`) VALUES
('2025-2026', 'Nationale'),
('2025-2026', 'Nationale 2'),
('2025-2026', 'ProD2'),
('2025-2026', 'Top14');

-- --------------------------------------------------------

--
-- Structure de la table `Stade`
--

CREATE TABLE `Stade` (
  `idStade` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `capacite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Stade`
--

INSERT INTO `Stade` (`idStade`, `nom`, `ville`, `capacite`) VALUES
(1, 'Stade Jean Dauger', 'Bayonne', 14370),
(2, 'Stade Chaban-Delmas', 'Bordeaux', 34635),
(3, 'Stade Pierre-Fabre', 'Castres', 11778),
(4, 'Stade Marcel-Michelin', 'Clermont-Ferrand', 19357),
(5, 'Stade Marcel-Deflandre', 'La Rochelle', 16700),
(6, 'Matmut Stadium de Gerland', 'Lyon', 35000),
(7, 'GGL Stadium', 'Montpellier', 15697),
(8, 'Stade du Hameau', 'Pau', 14588),
(9, 'Stade Aimé Giral', 'Perpignan', 14593),
(10, 'Stade de la Beaujoire', 'Nanterre', 35323),
(11, 'Stade Jean-Bouin', 'Paris', 20000),
(12, 'Stade Ernest-Wallon', 'Toulouse', 19500),
(13, 'Stade Ernest-Argelès', 'Toulon', 12000),
(14, 'Stade Yves-du-Manoir', 'Montauban', 12000);

-- --------------------------------------------------------

--
-- Structure de la table `Staff`
--

CREATE TABLE `Staff` (
  `idStaff` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `dateNaissanceStaff` date DEFAULT NULL,
  `specialite` varchar(50) DEFAULT NULL,
  `nationalite` varchar(50) DEFAULT NULL,
  `idClub` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Staff`
--

INSERT INTO `Staff` (`idStaff`, `nom`, `prenom`, `dateNaissanceStaff`, `specialite`, `nationalite`, `idClub`) VALUES
(1, 'PATAT', 'Grégory', NULL, 'Manager Général', 'Française', 1),
(2, 'FRASER', 'Gerard', NULL, 'Entraîneur des arrières', 'Écossaise', 1),
(3, 'REY', 'Joël', NULL, 'Entraîneur des avants', 'Française', 1),
(4, 'BARBERENA', 'Stéphane', NULL, 'Entraîneur de la touche', 'Française', 1),
(5, 'ABENDANON', 'Nick', NULL, 'Entraîneur des Skills', 'Française', 1),
(6, 'LOUIT', 'Loïc', NULL, 'Responsable de la performance', 'Française', 1),
(7, 'CARLOD', 'Louis', NULL, 'Team Manager', 'Française', 1),
(8, 'BARATCHART', 'Arnaud', NULL, 'Préparateur physique', 'Française', 1),
(9, 'ARQUIER', 'Benjamin', NULL, 'Préparateur physique', 'Française', 1),
(10, 'GUENIN', 'Vincent', NULL, 'Préparateur physique', 'Française', 1),
(11, 'GUILLEMOT', 'Romain', NULL, 'Médecin', 'Française', 1),
(12, 'LAFFOURCADE', 'Benjamin', NULL, 'Médecin', 'Française', 1),
(13, 'GAILLET', 'Ludovic', NULL, 'Kinésithérapeute', 'Française', 1),
(14, 'MARTIN', 'Thibault', NULL, 'Kinésithérapeute', 'Française', 1),
(15, 'CHAMPRES', 'Nicolas', NULL, 'Kinésithérapeute', 'Française', 1),
(16, 'DUCASSOU', 'Patxi', NULL, 'Kinésithérapeute', 'Française', 1),
(17, 'MERLEN', 'Virgile', NULL, 'Data Scientist', 'Française', 1),
(18, 'PICARD', 'Hippolyte', NULL, 'Analyste vidéo', 'Française', 1),
(19, 'GRASSIGNOUX', 'Thibaud', NULL, 'Analyste vidéo', 'Française', 1),
(20, 'FORT', 'David', NULL, 'Intendant', 'Française', 1),
(21, 'LETARD', 'Bruno', NULL, 'Intendant', 'Française', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `motDePasse` varchar(50) NOT NULL,
  `dateInscription` date DEFAULT NULL,
  `droits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Arbitre`
--
ALTER TABLE `Arbitre`
  ADD PRIMARY KEY (`idArbitre`);

--
-- Index pour la table `Club`
--
ALTER TABLE `Club`
  ADD PRIMARY KEY (`idClub`),
  ADD KEY `fk_club_stade` (`idStade`);

--
-- Index pour la table `FaitObjetDeTransfert`
--
ALTER TABLE `FaitObjetDeTransfert`
  ADD PRIMARY KEY (`idTransfert`),
  ADD KEY `idJoueur` (`idJoueur`),
  ADD KEY `idClub` (`idClub`);

--
-- Index pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD PRIMARY KEY (`idJoueur`),
  ADD KEY `idClub` (`idClub`);

--
-- Index pour la table `MatchRugby`
--
ALTER TABLE `MatchRugby`
  ADD PRIMARY KEY (`idMatch`),
  ADD KEY `fk_match_saison` (`annee`,`division`),
  ADD KEY `idStade` (`idStade`),
  ADD KEY `idArbitre` (`idArbitre`);

--
-- Index pour la table `Oppose`
--
ALTER TABLE `Oppose`
  ADD PRIMARY KEY (`idMatch`,`idClub`),
  ADD KEY `idClub` (`idClub`);

--
-- Index pour la table `Produit_Stat`
--
ALTER TABLE `Produit_Stat`
  ADD PRIMARY KEY (`idJoueur`,`idMatch`),
  ADD KEY `idMatch` (`idMatch`);

--
-- Index pour la table `Saison`
--
ALTER TABLE `Saison`
  ADD PRIMARY KEY (`annee`,`division`);

--
-- Index pour la table `Stade`
--
ALTER TABLE `Stade`
  ADD PRIMARY KEY (`idStade`);

--
-- Index pour la table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`idStaff`),
  ADD KEY `idClub` (`idClub`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Arbitre`
--
ALTER TABLE `Arbitre`
  MODIFY `idArbitre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Club`
--
ALTER TABLE `Club`
  MODIFY `idClub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `FaitObjetDeTransfert`
--
ALTER TABLE `FaitObjetDeTransfert`
  MODIFY `idTransfert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Joueur`
--
ALTER TABLE `Joueur`
  MODIFY `idJoueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `MatchRugby`
--
ALTER TABLE `MatchRugby`
  MODIFY `idMatch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Stade`
--
ALTER TABLE `Stade`
  MODIFY `idStade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Staff`
--
ALTER TABLE `Staff`
  MODIFY `idStaff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Club`
--
ALTER TABLE `Club`
  ADD CONSTRAINT `Club_ibfk_1` FOREIGN KEY (`idStade`) REFERENCES `Stade` (`idStade`);

--
-- Contraintes pour la table `FaitObjetDeTransfert`
--
ALTER TABLE `FaitObjetDeTransfert`
  ADD CONSTRAINT `FaitObjetDeTransfert_ibfk_1` FOREIGN KEY (`idJoueur`) REFERENCES `Joueur` (`idJoueur`),
  ADD CONSTRAINT `FaitObjetDeTransfert_ibfk_2` FOREIGN KEY (`idClub`) REFERENCES `Club` (`idClub`);

--
-- Contraintes pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD CONSTRAINT `Joueur_ibfk_1` FOREIGN KEY (`idClub`) REFERENCES `Club` (`idClub`);

--
-- Contraintes pour la table `MatchRugby`
--
ALTER TABLE `MatchRugby`
  ADD CONSTRAINT `MatchRugby_ibfk_1` FOREIGN KEY (`annee`,`division`) REFERENCES `Saison` (`annee`, `division`),
  ADD CONSTRAINT `MatchRugby_ibfk_2` FOREIGN KEY (`idStade`) REFERENCES `Stade` (`idStade`),
  ADD CONSTRAINT `MatchRugby_ibfk_3` FOREIGN KEY (`idArbitre`) REFERENCES `Arbitre` (`idArbitre`);

--
-- Contraintes pour la table `Oppose`
--
ALTER TABLE `Oppose`
  ADD CONSTRAINT `Oppose_ibfk_1` FOREIGN KEY (`idMatch`) REFERENCES `MatchRugby` (`idMatch`),
  ADD CONSTRAINT `Oppose_ibfk_2` FOREIGN KEY (`idClub`) REFERENCES `Club` (`idClub`);

--
-- Contraintes pour la table `Produit_Stat`
--
ALTER TABLE `Produit_Stat`
  ADD CONSTRAINT `Produit_Stat_ibfk_1` FOREIGN KEY (`idJoueur`) REFERENCES `Joueur` (`idJoueur`),
  ADD CONSTRAINT `Produit_Stat_ibfk_2` FOREIGN KEY (`idMatch`) REFERENCES `MatchRugby` (`idMatch`);

--
-- Contraintes pour la table `Staff`
--
ALTER TABLE `Staff`
  ADD CONSTRAINT `Staff_ibfk_1` FOREIGN KEY (`idClub`) REFERENCES `Club` (`idClub`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
