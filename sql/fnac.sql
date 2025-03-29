-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 29 mars 2025 à 10:02
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fnac`
--

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

DROP TABLE IF EXISTS `livres`;
CREATE TABLE IF NOT EXISTS `livres` (
  `id_livre` int NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Auteur` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_livre`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id_livre`, `ISBN`, `Auteur`, `Titre`, `Prix`) VALUES
(4, '254788', 'ODa', 'One piece', 5.00),
(2, '978-3-16-148411-7', 'Auteur2', 'Titre2z', 19.99),
(3, '978-3-16-148412-4', 'Auteur3', 'Titre3', 39.99);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'invite',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `login`, `mot_de_passe`, `role`) VALUES
(1, 'admin', '$2y$10$ZNINzfJzFZOiBqnIyhfB.uZqdPrX1gpAKNl1NH7vUZib1Tl.FCmWG', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
