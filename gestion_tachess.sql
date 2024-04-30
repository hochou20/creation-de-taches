-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 24 avr. 2024 à 19:57
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formulaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `gestion_tachess`
--

CREATE TABLE `gestion_tachess` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `deadline` date NOT NULL,
  `statut` enum('a faire','en cours','termine') NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) NOT NULL,
  `rappel` varchar(100) NOT NULL,
  `ORDER BY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `gestion_tachess`
--

INSERT INTO `gestion_tachess` (`id`, `title`, `description`, `deadline`, `statut`, `created_at`, `username`, `rappel`, `ORDER BY`) VALUES
(0000000017, 'projet', 'tp algo', '2024-05-09', 'a faire', '2024-04-22 13:58:35', 'axelharzi', '', 0),
(0000000032, 'projet', 'algo', '2024-05-24', 'a faire', '2024-04-22 18:44:38', 'hocineaxel', '', 0),
(0000000033, 'projet', 'odw', '2024-05-05', 'a faire', '2024-04-23 14:06:00', 'hocineaxel', '', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `gestion_tachess`
--
ALTER TABLE `gestion_tachess`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `gestion_tachess`
--
ALTER TABLE `gestion_tachess`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
