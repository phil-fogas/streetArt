
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `street`
--

DELIMITER $$

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`) VALUES
(1, 'peinture'),
(2, 'grafiti'),
(3, 'collage'),
(4, 'sculpture'),
(10, 'tag'),
(11, 'fresque'),
(12, 'mosaïque ');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_street` int(11) NOT NULL,
  `date_ad` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE `droit` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` int(11) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `droit`
--

INSERT INTO `droit` (`id`, `name`, `valid`, `statut`) VALUES
(1, 'visiteur', 5, 3),
(2, 'menbre', 2, 2),
(5, 'modérateur', 1, 2),
(9, 'admin', -100, 0);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sujet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id` int(11) NOT NULL,
  `statut` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `statut`) VALUES
(1, 'archive'),
(2, 'effacée '),
(3, 'visible'),
(4, 'en réalisation');

-- --------------------------------------------------------

--
-- Structure de la table `street`
--

CREATE TABLE `street` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `dateCreation` date DEFAULT NULL,
  `dateFiche` datetime NOT NULL,
  `valid` int(1) DEFAULT NULL,
  `statut` int(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `categorie` int(1) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `droit` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `dateVisi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `droit`, `created_at`, `dateVisi`) VALUES
(1, 'anonyme', '', '4546556', 1, '2021-01-01 00:04:51', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE `validation` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_street` int(11) NOT NULL,
  `chose` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`id_users`),
  ADD KEY `street_id` (`id_street`);

--
-- Index pour la table `droit`
--
ALTER TABLE `droit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `street`
--
ALTER TABLE `street`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_street` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validation`
--
ALTER TABLE `validation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `street_id_valid` (`id_street`),
  ADD KEY `user_id_valid` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `droit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `street`
--
ALTER TABLE `street`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `validation`
--
ALTER TABLE `validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `street_id` FOREIGN KEY (`id_street`) REFERENCES `street` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `validation`
--
ALTER TABLE `validation`
  ADD CONSTRAINT `street_id_valid` FOREIGN KEY (`id_street`) REFERENCES `street` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_valid` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
