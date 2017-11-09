-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 08 Novembre 2017 à 22:33
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mecado`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_list` int(10) UNSIGNED NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `msg` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'item.png',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`id`, `id_prod`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'item.png', '2017-11-08 14:35:21', '2017-11-08 14:35:21'),
(2, 2, 'item.png', '2017-11-08 21:30:30', '2017-11-08 21:30:30'),
(3, 3, 'item.png', '2017-11-08 21:30:30', '2017-11-08 21:30:30'),
(4, 4, 'item.png', '2017-11-08 21:30:40', '2017-11-08 21:30:40'),
(5, 5, 'item.png', '2017-11-08 21:30:40', '2017-11-08 21:30:40'),
(6, 6, 'item.png', '2017-11-08 21:30:49', '2017-11-08 21:30:49'),
(7, 7, 'item.png', '2017-11-08 21:30:49', '2017-11-08 21:30:49');

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `date_exp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `url_share` varchar(255) DEFAULT NULL,
  `id_creator` int(10) UNSIGNED NOT NULL,
  `other_dest` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `list`
--

INSERT INTO `list` (`id`, `name`, `descr`, `date_exp`, `url_share`, `id_creator`, `other_dest`, `created_at`, `updated_at`) VALUES
(1, 'Admin_list', 'Liste créé par l\'admin pour tester les fonctionnalités du projet.', '2017-11-08 21:32:32', NULL, 1, 1, '2017-11-08 19:42:59', '2017-11-08 21:32:32');

-- --------------------------------------------------------

--
-- Structure de la table `list_products`
--

CREATE TABLE `list_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_list` int(10) UNSIGNED NOT NULL,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_list_products` int(10) UNSIGNED NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `msg` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) UNSIGNED DEFAULT NULL,
  `reserve` tinyint(1) NOT NULL DEFAULT '0',
  `user_reserve` varchar(255) DEFAULT NULL,
  `custom_product` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `descr`, `url`, `price`, `reserve`, `user_reserve`, `custom_product`, `created_at`, `updated_at`) VALUES
(1, 'test', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.', NULL, '135.00', 0, NULL, 0, '2017-11-08 10:47:17', '2017-11-08 14:26:12'),
(2, 'test2', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:13:36', '2017-11-08 12:13:36'),
(3, 'test3', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:13:36', '2017-11-08 12:13:36'),
(4, 'test4', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:13:57', '2017-11-08 12:13:57'),
(5, 'test5', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:13:57', '2017-11-08 12:13:57'),
(6, 'test6', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:14:17', '2017-11-08 12:14:17'),
(7, 'test7', NULL, NULL, NULL, 0, NULL, 0, '2017-11-08 12:14:17', '2017-11-08 12:14:17');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `mail`, `password`, `token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Root', 'admin@gmail.com', '$2y$10$oC5bodBGOfxAZFpo53Uhg.ZWcDWLNRZlwEntI39j6FrKR9YAGo3/C', NULL, '2017-11-08 21:29:46', '2017-11-08 15:49:03', '2017-11-08 21:29:46');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_list` (`id_list`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_creator` (`id_creator`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `list_products`
--
ALTER TABLE `list_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_list` (`id_list`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_list_product` (`id_list_products`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `list_products`
--
ALTER TABLE `list_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_list` FOREIGN KEY (`id_list`) REFERENCES `list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_product_image` FOREIGN KEY (`id_prod`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `fk_user_list` FOREIGN KEY (`id_creator`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `list_products`
--
ALTER TABLE `list_products`
  ADD CONSTRAINT `fk_product_list_list` FOREIGN KEY (`id_list`) REFERENCES `list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_list_product` FOREIGN KEY (`id_prod`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_list_products` FOREIGN KEY (`id_list_products`) REFERENCES `list_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
