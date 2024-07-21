-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 29 mars 2024 à 02:29
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
-- Base de données : `reseau-social`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentary`
--

CREATE TABLE `commentary` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commentary`
--

INSERT INTO `commentary` (`id`, `post_id`, `user_id`, `text`) VALUES
(1, 11, 6, 'cest bien beau tout ├ºa'),
(4, 11, 6, 'hello'),
(5, 11, 6, 'commentaire de admin'),
(6, 15, 8, 'bravo ! '),
(7, 17, 12, 'trés bonne photos ');

-- --------------------------------------------------------

--
-- Structure de la table `friendlist`
--

CREATE TABLE `friendlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friend_username` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `friendlist`
--

INSERT INTO `friendlist` (`id`, `friend_id`, `friend_username`, `user_id`) VALUES
(9, 8, 'test', 6),
(10, 7, 'admin2', 6),
(11, 9, 'cvcvv', 6),
(12, 11, 'tanmirt', 12),
(13, 12, 'khalef', 11);

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE `group` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `group_post`
--

CREATE TABLE `group_post` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `who_post` int(10) UNSIGNED NOT NULL,
  `texte` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `commentary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`commentary`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `send` text NOT NULL,
  `who_send` int(10) UNSIGNED NOT NULL,
  `who_receive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `created_at`, `send`, `who_send`, `who_receive`) VALUES
(2, '2022-05-18 08:25:09', 'test nouvelle db', 1, 2),
(4, '2022-05-18 12:00:18', 'test mess de autre', 1, 3),
(5, '2022-05-20 11:56:48', 'a', 6, 8),
(6, '2022-05-20 11:56:55', 'zz', 6, 9),
(7, '2022-05-20 11:56:57', 'zz', 6, 9),
(8, '2022-05-20 11:58:02', 'qq', 6, 8),
(9, '2022-05-20 12:05:49', 'hbiurn', 6, 7),
(10, '2022-05-22 08:28:02', 'rijenth', 6, 6),
(11, '2022-05-22 08:28:02', 'rijenth', 6, 6),
(12, '2022-05-22 08:28:44', 'salut je suis test', 8, 6);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE `page` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `admin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`admin`)),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `commentary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `text`, `image`, `commentary`) VALUES
(4, 6, 'noah', 'salut noah ', '../upload/post/16527049961684082274.png', ''),
(11, 8, 'yoyooyyoyo', 'njfklneljfen', '../upload/post/16527966891091481610.png', ''),
(12, 6, 'Ma nouvelle publication !', 'eifezfj', '../upload/post/16528009731806651709.png', ''),
(15, 6, 'mon nouveau post', 'ceci est un contenu', NULL, ''),
(16, 6, 'Ma photo de profil', 'est incroyable', '../upload/post/1653213655982493422.png', ''),
(17, 11, 'le pluit a paris ', 'le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris le pluit a paris ', '../upload/post/17116610421376188901.jpeg', ''),
(18, 12, 'bonjpour', 'bonjour', '../upload/post/1711662285601737871.jpg', ''),
(19, 11, 'un matin a paris  ', 'un matin un matin un matin ', '../upload/post/1711662611362655443.jpg', ''),
(20, 12, 'un matin a paris  ', 'un matin un matin un matin ', '../upload/post/17116634101941108551.jpg', ''),
(21, 11, 'couple kabyle ', 'couple kabyle a tizi ', '../upload/post/17116741671959489753.jpg', '');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner` varchar(255) NOT NULL,
  `profil_picture` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `banner`, `profil_picture`, `description`, `user_id`) VALUES
(1, '../upload/default_banner.png', '../upload/default_pp.png', 'Ceci est la description de imageban', 1),
(4, '../upload/default_banner.png', '../upload/default_pp.png', 'Ceci est la description de egjoziegjze', 4),
(5, '../upload/default_banner.png', '../upload/default_pp.png', 'Ceci est la description de rtyvubhinjo', 5),
(6, '../upload/profil/admin/banner/16530532521299876361.png', '../upload/profil/admin/profilPicture/16530532522063134516.png', 'Bonjour, je suis l\'admin ! ', 6),
(7, '../upload/default/default_banner.png', '../upload/default/default_pp.png', 'Ceci est la description de admin2', 7),
(8, '../upload/default/default_banner.png', '../upload/profil/test/profilPicture/1652980902327079186.png', 'Ceci est la description de test', 8),
(9, '../upload/default/default_banner.png', '../upload/default/default_pp.png', 'Ceci est la description de cvcvv', 9),
(10, '../upload/default/default_banner.png', '../upload/default/default_pp.png', 'Ceci est la description de GREGE', 10),
(11, '../upload/default/default_banner.png', '../upload/default/default_pp.png', 'Ceci est la description de tanmirt', 11),
(12, '../upload/profil/khalef/banner/1711661314207492679.jpeg', '../upload/profil/khalef/profilPicture/17116613141420142673.jpg', 'bonjour', 12);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `phone` char(10) NOT NULL,
  `account_state` enum('0','1') DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastname`, `name`, `mail`, `country`, `password`, `birthday`, `phone`, `account_state`, `username`) VALUES
(1, 'test', 'test', 'test@mvcdlg.Fr', 'France', '$2y$10$yVpQ1YYb8qA/O64npmbArOhObYAbC.IHHiOvr4cZdH1TDmZ/T0pUG', '2000-01-01', '0611223344', '0', 'imageban'),
(4, 'fezrthsdyj', 'hubijnklrety', 'grger@live.fr', 'France', '$2y$10$w70HB0Vk3jegVwLlrb0ONuHLZ2ozMefbg4TUN54X5Ym8inF4QbbNG', '2000-01-01', '0612345678', '0', 'egjoziegjze'),
(5, 'cytvubi', 'cyvubi', 'vuybi@live.Fr', 'France', '$2y$10$FKwbrT4n12QhuS2AG05vbuap0LVASSQ/b5CjVVxKPTjnzL/LgAMba', '2000-01-01', '0611223344', '0', 'rtyvubhinjo'),
(6, 'admin', 'admin', 'admin@admin.admin', 'France', '$2y$10$vXCkM2MC4jc6QTtqspbM1.focO6odDUgDfsLFx4AhmXVgxJ7C27ti', '2021-04-01', '0611223344', '0', 'admin'),
(7, 'admin2', 'aizodnajfn', 'test123@test123.fr', 'France', '$2y$10$03QvPxravI79rV6/5sjBl.nd/ME42Eaxe2yoErSjnbtcGoBEQ.K72', '1990-03-15', '0622334455', '0', 'admin2'),
(8, 'zaoifnaiofn', 'ivonezknzei', 'izgze@live.Fr', 'France', '$2y$10$2dxBBO3BY7t6xu5WBDv5C.onvH27ivJBcp9fRa.9u/YbBcaXozUh.', '2007-07-07', '0707070707', '0', 'test'),
(9, 'yyy', 'hyyyy', 'dsfs@live.fr', 'France', '$2y$10$llWHTZwsa5703sUCxp2CBOm62/JrX4RhxLzHpulb7SZYpA4hGG09W', '9999-09-09', '0611223344', '0', 'cvcvv'),
(10, 'rijenth13', 'test', 'gregerg@gmail.com', 'France', '$2y$10$Qgba.kr9Wv/.3sIKGMpQ.e71srIJCo/teR7NeazOZpnoUJrPoxXCu', '9999-12-10', '0622334455', '0', 'GREGE'),
(11, 'sdvsdvsdv', 'xfvsdvdfv', 'tanmirt@gmail.com', 'France', '$2y$10$vGE1RJe43MYt/eL9llvgyOy1GgElLnjqn3kgsngYga0XNoosXBmFy', '2000-05-15', '011111111', '0', 'tanmirt'),
(12, 'khalef', 'khalef', 'khalef@gmail.com', 'France', '$2y$10$4CI/ZOJOEFPu5XPb8551KOlmAtGhtNNcfKLxd0HPA2C2sK9sMRX5G', '1995-12-16', '0111111111', '0', 'khalef');

-- --------------------------------------------------------

--
-- Structure de la table `user_membership`
--

CREATE TABLE `user_membership` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_group` int(10) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_candidate` tinyint(1) NOT NULL,
  `is_member` tinyint(1) NOT NULL,
  `is_exclude` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id_foreign` (`post_id`),
  ADD KEY `user_id_foreign` (`user_id`);

--
-- Index pour la table `friendlist`
--
ALTER TABLE `friendlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friendlist_user_id_foreign` (`user_id`);

--
-- Index pour la table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_post`
--
ALTER TABLE `group_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_post_group_id_foreign` (`group_id`),
  ADD KEY `group_post_who_post_foreign` (`who_post`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_user_id_foreign` (`user_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_user_id_foreign` (`user_id`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_id_foreign_key` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `user_membership`
--
ALTER TABLE `user_membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_membership_user_id_foreign` (`user_id`),
  ADD KEY `user_membership_user_group_foreign` (`user_group`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentary`
--
ALTER TABLE `commentary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `friendlist`
--
ALTER TABLE `friendlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `group_post`
--
ALTER TABLE `group_post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user_membership`
--
ALTER TABLE `user_membership`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD CONSTRAINT `post_id_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `friendlist`
--
ALTER TABLE `friendlist`
  ADD CONSTRAINT `friendlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `group_post`
--
ALTER TABLE `group_post`
  ADD CONSTRAINT `group_post_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_post_who_post_foreign` FOREIGN KEY (`who_post`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `profil_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_membership`
--
ALTER TABLE `user_membership`
  ADD CONSTRAINT `user_membership_user_group_foreign` FOREIGN KEY (`user_group`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_membership_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
