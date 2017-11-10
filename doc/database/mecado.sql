-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 10 Novembre 2017 à 14:23
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

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `id_list`, `author`, `msg`, `created_at`, `updated_at`) VALUES
(2, 1, 'Enzo', 'Cette liste est très bien, je n\'avais pas d\'idées de cadeaux à offrir à Hugo', '2017-11-10 12:49:28', '2017-11-10 12:49:28'),
(3, 2, 'Théo', 'J\'avais déjà cette idée de cadeau, mais ta liste me permet de savoir quel ballon tu voulais exactement, c\'était une très bonne idée', '2017-11-10 12:52:44', '2017-11-10 12:52:44');

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
(1, 1, 'televiseur.png', '2017-11-10 11:56:00', '2017-11-10 11:56:00'),
(2, 2, 'cafetiere.png', '2017-11-10 11:56:00', '2017-11-10 11:56:00'),
(3, 3, 'ballon.png', '2017-11-10 11:56:00', '2017-11-10 11:56:00'),
(4, 4, 'ps4.png', '2017-11-10 11:56:00', '2017-11-10 11:56:00'),
(5, 5, 'disque_dur.png', '2017-11-10 11:56:00', '2017-11-10 11:56:00'),
(6, 6, 'asterix.png', '2017-11-10 11:57:47', '2017-11-10 11:57:47'),
(7, 7, 'casque_audio.png', '2017-11-10 11:57:47', '2017-11-10 11:57:47'),
(8, 8, 'portable.png', '2017-11-10 11:57:47', '2017-11-10 11:57:47'),
(9, 9, 'calendrier.png', '2017-11-10 11:57:47', '2017-11-10 11:57:47'),
(10, 10, 'bapteme_vol.png', '2017-11-10 11:57:47', '2017-11-10 11:57:47'),
(11, 11, 'item.png', '2017-11-10 12:36:15', '2017-11-10 12:36:15');

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
(1, 'List de Hugo', 'Liste de cadeaux destiné à Hugo', '2017-11-10 12:23:36', '5a0598ef03077', 6, 1, '2017-11-10 12:14:49', '2017-11-10 12:23:36'),
(2, 'Ma liste de cadeaux', 'Ma liste de cadeaux que j\'aimerais pour Noël', '2017-11-10 12:50:06', '5a05a07e0f1af', 6, 0, '2017-11-10 12:24:44', '2017-11-10 12:50:06');

-- --------------------------------------------------------

--
-- Structure de la table `list_products`
--

CREATE TABLE `list_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_list` int(10) UNSIGNED NOT NULL,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `reserve` tinyint(1) NOT NULL DEFAULT '0',
  `user_reserve` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `list_products`
--

INSERT INTO `list_products` (`id`, `id_list`, `id_prod`, `reserve`, `user_reserve`, `created_at`, `updated_at`) VALUES
(4, 2, 1, 0, NULL, '2017-11-10 12:39:39', '2017-11-10 12:39:39'),
(5, 2, 2, 0, NULL, '2017-11-10 12:39:42', '2017-11-10 12:39:42'),
(6, 2, 3, 1, 'Théo', '2017-11-10 12:39:43', '2017-11-10 12:51:04'),
(7, 2, 4, 0, NULL, '2017-11-10 12:39:45', '2017-11-10 12:39:45'),
(8, 2, 5, 0, NULL, '2017-11-10 12:44:12', '2017-11-10 12:44:12'),
(9, 2, 6, 0, NULL, '2017-11-10 12:44:14', '2017-11-10 12:44:14'),
(10, 1, 11, 0, NULL, '2017-11-10 12:44:29', '2017-11-10 12:44:29'),
(11, 1, 10, 1, 'Enzo', '2017-11-10 12:44:31', '2017-11-10 12:46:24'),
(12, 1, 9, 0, NULL, '2017-11-10 12:44:35', '2017-11-10 12:44:35');

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

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `id_list_products`, `author`, `msg`, `created_at`, `updated_at`) VALUES
(2, 11, 'Enzo', 'Bon anniversaire Hugo ! Tu vas aimer ce vol !', '2017-11-10 12:46:24', '2017-11-10 12:46:44'),
(3, 6, 'Théo', 'Joyeux Noël Jean, tu vas pouvoir t\'entraîner à frapper dans un ballon maintenant ', '2017-11-10 12:51:04', '2017-11-10 12:51:04');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `url` text,
  `price` decimal(10,2) UNSIGNED DEFAULT NULL,
  `custom_product` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `descr`, `url`, `price`, `custom_product`, `created_at`, `updated_at`) VALUES
(1, 'Téléviseur', 'LG 43UJ634V - TV LED UHD 4K de 43 Pouces (Active HDR, Smart TV WebOS 3.5, Ultra Surround) [Classe énergétique A+]', 'https://www.amazon.fr/gp/product/B071RCW1KY/ref=s9_acsd_zgift_hd_bw_bwzc7_c_x_w?pf_rd_m=A1X6FK5RDHNB96&pf_rd_s=merchandised-search-4&pf_rd_r=XZGRQJYZ9X9ZAEHH6SEE&pf_rd_t=101&pf_rd_p=682c2c4d-91bd-57e8-9ce1-2e40fb210734&pf_rd_i=14059871', '460.89', 0, '2017-11-10 11:31:19', '2017-11-10 11:35:29'),
(2, 'Cafetière', 'Indesit cm HPS Machine à café No noir', 'https://www.amazon.fr/Indesit-HPS-Machine-caf%C3%A9-noir/dp/B00PZGPBDK/ref=sr_1_1?s=electronics&ie=UTF8&qid=1510313493&sr=1-1&keywords=cafetiere&dpID=41FtzL2VWOL&preST=_SY300_QL70_&dpSrc=srch', '37.15', 0, '2017-11-10 11:33:22', '2017-11-10 11:35:34'),
(3, 'Ballon', 'Premier League Skills Football -White/Black', 'https://www.amazon.fr/Nike-SKILLS-Ballon-Unisex-Blanc/dp/B0195PH3K0/ref=sr_1_5?s=sports&ie=UTF8&qid=1510313658&sr=1-5&keywords=ballon+de+foot', '20.00', 0, '2017-11-10 11:35:19', '2017-11-10 11:35:38'),
(4, 'PlayStation 4', 'PS4 Pro 1To + Call of Duty: World War II ', 'https://www.amazon.fr/Sony-9887157-Playstation-4-Pro/dp/B076J1YRQK/ref=sr_1_1?ie=UTF8&qid=1510313781&sr=8-1&keywords=ps4%2Bpro%2Bdeux%2Bmanettes&th=1', '570.89', 0, '2017-11-10 11:37:52', '2017-11-10 11:37:52'),
(5, 'Disque dur', 'Maxtor STSHX-M101TCBM Disque Dur Externe 1 To USB 3.0 Noir ', 'https://www.amazon.fr/Maxtor-STSHX-M101TCBM-Disque-Externe-Noir/dp/B01AJWNYLA/ref=sr_1_1?s=computers&ie=UTF8&qid=1510313913&sr=1-1&keywords=disque+dur', '60.50', 0, '2017-11-10 11:44:23', '2017-11-10 11:44:23'),
(6, 'Bande dessinée Astérix', 'Astérix - Tome 36 - Le Papyrus de César', 'https://www.amazon.fr/Ast%C3%A9rix-Papyrus-C%C3%A9sar-Ren%C3%A9-Goscinny/dp/2864972719/ref=sr_1_1?ie=UTF8&qid=1510314143&sr=8-1&keywords=bande+dessin%C3%A9e+asterix', '9.95', 0, '2017-11-10 11:44:23', '2017-11-10 11:44:23'),
(7, 'Casque audio', 'Mpow Casque Bluetooth Sans fil, Casque Audio MP3 Lecteur, Écouteurs Stéréo Sport Intra-Auriculaires,Micro Oreillette Anti Bruit / Hip-Hop / Jeux Vidéo Gaming / Bluetooth CSR Signal Stable / Bandeau Pliable Pivotant / Micro Intégré / 13 Heures Jeux Continu / Bluetooth CSR Signal Stable / CVC6.0 Suppression du Bruit / 250 Heures en Veille / Kit Main Libre pour Wiko, Iphone,PC, Ordinateurs Portables et Smartphones - Rouge', 'https://www.amazon.fr/Mpow-Intra-Auriculaires-Suppression-Ordinateurs-Smartphones/dp/B01MYS5D6D/ref=sr_1_7?ie=UTF8&qid=1510314351&sr=8-7&keywords=casque+audio', '29.98', 0, '2017-11-10 11:47:21', '2017-11-10 11:47:21'),
(8, 'Portable Huawei', 'Huawei P8 Lite version 2017 Smartphone débloqué 4G (Ecran: 5,2 pouces - 16 Go - Double Nano-SIM - Android 7.0 Nougat) Noir', 'https://www.amazon.fr/Huawei-version-Smartphone-d%C3%A9bloqu%C3%A9-Ecran/dp/B01MU9R2EN/ref=sr_1_8?s=electronics&ie=UTF8&qid=1510314481&sr=1-8&keywords=t%C3%A9l%C3%A9phone+portable&dpID=41NNN1NttFL&preST=_SY300_QL70_&dpSrc=srch', '194.40', 0, '2017-11-10 11:49:06', '2017-11-10 11:49:06'),
(9, 'Calendrier de l\'avent', 'CALENDRIER DE L\'AVENT BEER OF THE WORLD ', 'https://www.amazon.fr/Plan%C3%A8te-Drinks-CALENDRIER-LAVENT-WORLD/dp/B076B3CRLX/ref=sr_1_1?ie=UTF8&qid=1510314630&sr=8-1&keywords=calendrier+de+l%27avent+de+biere&dpID=51qk3mBTpIL&preST=_SX342_QL70_&dpSrc=srch', '64.90', 0, '2017-11-10 11:53:45', '2017-11-10 11:53:45'),
(10, 'Baptème vol', 'Baptême vol en patrouille – près de Bordeaux', 'https://www.ideecadeau.fr/bapteme-vol-en-patrouille-pres-de-bordeaux.html', '150.00', 0, '2017-11-10 11:53:45', '2017-11-10 11:53:45'),
(11, 'Fifa 18 édition Ronaldo', 'Le célèbre jeu de football Fifa année 2018 sur ps4', 'https://www.amazon.fr/Electronic-Arts-FIFA-18-Edition/dp/B071WK2M5Z/ref=sr_1_2?s=videogames&ie=UTF8&qid=1510317202&sr=1-2&keywords=fifa+18+ps4&dpID=51wmRLCXAHL&preST=_SY300_QL70_&dpSrc=srch', '109.99', 1, '2017-11-10 12:36:15', '2017-11-10 12:36:46');

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
(6, 'Dupont', 'Jean', 'jean.dupont@gmail.com', '$2y$10$zQaLqWpn9wQ82hinjmzz0eQoN4UI/WEzEGYu6n.3NcOAJ0KCIUzB6', NULL, '2017-11-10 12:00:22', '2017-11-10 12:00:22', '2017-11-10 12:00:22');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `list_products`
--
ALTER TABLE `list_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
