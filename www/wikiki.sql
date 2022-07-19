-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : mar. 19 juil. 2022 à 09:06
-- Version du serveur : 5.7.35
-- Version de PHP : 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wikiki`
--

-- --------------------------------------------------------

--
-- Structure de la table `wk_article`
--

CREATE TABLE `wk_article` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(200) DEFAULT 'NULL',
  `content` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `media_id` int(11) DEFAULT NULL,
  `clickedOn` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_category`
--

CREATE TABLE `wk_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_comment`
--

CREATE TABLE `wk_comment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_log`
--

CREATE TABLE `wk_log` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `action` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_media`
--

CREATE TABLE `wk_media` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_meta`
--

CREATE TABLE `wk_meta` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_navigation`
--

CREATE TABLE `wk_navigation` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `wk_navigation`
--

INSERT INTO `wk_navigation` (`id`, `value`, `name`) VALUES
(1, 'navbar', 'Navbar'),
(2, 'footer', 'Footer');

-- --------------------------------------------------------

--
-- Structure de la table `wk_page`
--

CREATE TABLE `wk_page` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `subtitle` varchar(240) NOT NULL,
  `navigation_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_passwordreset`
--

CREATE TABLE `wk_passwordreset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `changeKey` varchar(255) NOT NULL,
  `expDate` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `wk_user`
--

CREATE TABLE `wk_user` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `token` char(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `emailVerifyToken` varchar(64) DEFAULT NULL COMMENT 'Token de vérification d''email.',
  `role` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1 = admin (création de page etc)\n2 = modo (modération des coms ...)\n3 = user (juste voir les page et articles, liker et commenter)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `wk_article`
--
ALTER TABLE `wk_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articleAuthor` (`user_id`),
  ADD KEY `articleCategorie` (`category_id`),
  ADD KEY `articleMedia` (`media_id`);

--
-- Index pour la table `wk_category`
--
ALTER TABLE `wk_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`name`);

--
-- Index pour la table `wk_comment`
--
ALTER TABLE `wk_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user-comment` (`user_id`),
  ADD KEY `article-comment` (`article_id`);

--
-- Index pour la table `wk_log`
--
ALTER TABLE `wk_log`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wk_media`
--
ALTER TABLE `wk_media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_name` (`name`),
  ADD UNIQUE KEY `media_path` (`path`),
  ADD KEY `mediaAuthor` (`user_id`);

--
-- Index pour la table `wk_meta`
--
ALTER TABLE `wk_meta`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wk_navigation`
--
ALTER TABLE `wk_navigation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wk_page`
--
ALTER TABLE `wk_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pageNavigation` (`navigation_id`),
  ADD KEY `pageAuthor` (`user_id`);

--
-- Index pour la table `wk_passwordreset`
--
ALTER TABLE `wk_passwordreset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`);

--
-- Index pour la table `wk_user`
--
ALTER TABLE `wk_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `emailVerifyToken` (`emailVerifyToken`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `wk_article`
--
ALTER TABLE `wk_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_category`
--
ALTER TABLE `wk_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_comment`
--
ALTER TABLE `wk_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_log`
--
ALTER TABLE `wk_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_media`
--
ALTER TABLE `wk_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_meta`
--
ALTER TABLE `wk_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_navigation`
--
ALTER TABLE `wk_navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `wk_page`
--
ALTER TABLE `wk_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_passwordreset`
--
ALTER TABLE `wk_passwordreset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wk_user`
--
ALTER TABLE `wk_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wk_article`
--
ALTER TABLE `wk_article`
  ADD CONSTRAINT `articleAuthor` FOREIGN KEY (`user_id`) REFERENCES `wk_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articleCategorie` FOREIGN KEY (`category_id`) REFERENCES `wk_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articleMedia` FOREIGN KEY (`media_id`) REFERENCES `wk_media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wk_comment`
--
ALTER TABLE `wk_comment`
  ADD CONSTRAINT `article-comment` FOREIGN KEY (`article_id`) REFERENCES `wk_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user-comment` FOREIGN KEY (`user_id`) REFERENCES `wk_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wk_media`
--
ALTER TABLE `wk_media`
  ADD CONSTRAINT `mediaAuthor` FOREIGN KEY (`user_id`) REFERENCES `wk_user` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `wk_page`
--
ALTER TABLE `wk_page`
  ADD CONSTRAINT `navigation` FOREIGN KEY (`navigation_id`) REFERENCES `wk_navigation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pageAuthor` FOREIGN KEY (`user_id`) REFERENCES `wk_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `wk_passwordreset`
--
ALTER TABLE `wk_passwordreset`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `wk_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
