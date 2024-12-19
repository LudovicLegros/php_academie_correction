-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 déc. 2024 à 14:13
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `perigueux_academie`
--

-- --------------------------------------------------------

--
-- Structure de la table `creature`
--

DROP TABLE IF EXISTS `creature`;
CREATE TABLE IF NOT EXISTS `creature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `famille_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `creature`
--

INSERT INTO `creature` (`id`, `nom`, `description`, `image`, `users_id`, `famille_id`) VALUES
(10, 'Cyclope', 'Sorte de géant monstrueux qui n&#039;avait qu&#039;un œil, de forme ronde, au milieu du front. L&#039;antre des cyclopes. Quelques récits mythologiques donnent les cyclopes pour forgerons à Vulcain.', 'cyclope1673273852600.webp', 7, 2),
(11, 'Dragon rouge', 'Engager un combat contre un Dragon Rouge est une preuve indubitable de folie furieuse. Lorsque ces monstres tombent du ciel, tout est anéanti par les flammes, et nul ne peut échapper à leur morsure. Si la bravoure a des limites, elles se situent sans conteste à proximité d&#039;un Dragon Rouge...', 'dragon_rouge1673273945769.webp', 6, 3),
(12, 'Elementaire de lave', 'Cette créature n&#039;est pas vivante. Elle est immunisée contre le Poison, l&#039;Aveuglement ou le Contrôle Mental, mais ne peut ni être ressuscitée, ni soignée par une Tente de Premiers Soins.', 'elementaire_lave1673343193948.webp', 6, 3),
(13, 'Cerbere', 'Dans la mythologie grecque, Cerbère est le chien polycéphale gardant l&#039;entrée des Enfers. Il empêche les morts de s&#039;échapper de l&#039;antre d&#039;Hadès et les vivants de venir récupérer certains morts. ', 'cerbere1673431382371.webp', 7, 3),
(22, 'Centaure', 'Mi cheval Mi humain', 'centaure1734613029746.jpg', 6, 2),
(21, 'squellette', 'un mec qui n&#039;a plus de peaux', 'squelette1733923807571.jpg', 10, 1),
(23, 'Harpie', 'Mi oiseau mi humain', 'harpie1734613335657.jpg', 10, 2),
(24, 'Seigneur des abimes', 'il fait peur', 'seigneur des abimes1734613382122.jpg', 11, 3),
(25, 'Succube', 'Démone avec un fouet', 'succube1734617411976.jpg', 11, 3),
(26, 'Liche', 'Mort vivant et magique', 'liche1734617432779.jpg', 12, 1),
(27, 'Fantome', 'Peut traverser les murs', 'fantome1734617448298.jpg', 12, 1),
(28, 'Elementaire d&#039;eau', 'Pratique quand on a soif', 'elementaire_d\'eau1734617482622.jpg', 12, 4),
(29, 'Kappa', 'Un gros crapeau', 'kappa1734617498138.jpg', 13, 4),
(30, 'Kirin', 'Dragon des mers', 'kirin1734617514195.jpg', 13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `ecole`
--

DROP TABLE IF EXISTS `ecole`;
CREATE TABLE IF NOT EXISTS `ecole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ecole`
--

INSERT INTO `ecole` (`id`, `type`) VALUES
(1, 'lumière'),
(2, 'eau'),
(3, 'feu'),
(4, 'air');

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

DROP TABLE IF EXISTS `famille`;
CREATE TABLE IF NOT EXISTS `famille` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_famille` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `famille`
--

INSERT INTO `famille` (`id`, `nom_famille`) VALUES
(1, 'mort-vivant'),
(2, 'mi-bête'),
(3, 'démonique'),
(4, 'aquatique');

-- --------------------------------------------------------

--
-- Structure de la table `magie`
--

DROP TABLE IF EXISTS `magie`;
CREATE TABLE IF NOT EXISTS `magie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `ecole_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `magie`
--

INSERT INTO `magie` (`id`, `label`, `description`, `image`, `ecole_id`) VALUES
(2, 'Blizzard', 'Balance un big blizzard sur des gens', 'Blizzard.webp', 2),
(3, 'armure céleste', 'une armure divine faite de lumière', 'armure_celeste1673615700362.webp', 1),
(4, 'mur de glace', 'Création d&#039;un mur de glace d&#039;une hauteur de 20m !', 'mur_de_glace1734612349176.webp', 2),
(6, 'bouclier de feu', 'un bouclier fait de feu', 'bouclier_de_feu1673615887755.webp', 3),
(7, 'éclair', 'Envoie un éclair', 'Eclair1734612009265.webp', 4),
(8, 'Armure de glace', 'Créer une armure totalement de glace', 'Armure de glace1734612455591.webp', 2),
(9, 'Invocation d&#039;élémentaire d&#039;eau', 'Invoque un élémentaire fait d&#039;eau', 'Elementaire d\'eau173461249017.webp', 2),
(10, 'Invocation d&#039;élémentaire d&#039;air', 'invoque un élémentaire fait d&#039;air', 'Elementair d\'air1734612524456.webp', 4),
(11, 'Vent violent', 'Créé un vent très violent', 'Vent violent1734612548744.webp', 4),
(12, 'Soin', 'Permet de soigner', 'soin1734612575139.webp', 1),
(13, 'Purification', 'Soigne tout les maux des personnes alentour', 'Purification1734612605930.webp', 1),
(14, 'Tempête de feu', 'des gerbes de flammes tombent du ciel', 'Tempête de feu1734612638383.webp', 3),
(15, 'Boule de feu', 'Envoie une boule de feu', 'boule_de_feu1734612665388.webp', 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(7, 'kiril', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER'),
(6, 'catherine', '7a51f605bf53d58175af55a7aa0f2ad2d933201e', 'ADMIN'),
(9, 'anton', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER'),
(10, 'anastasya', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER'),
(11, 'irina', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER'),
(12, 'jorgen', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER'),
(13, 'kalindra', '2768bd5b76f176c4226b4151e2c71a4432b51dc0', 'USER');

-- --------------------------------------------------------

--
-- Structure de la table `user_ecole`
--

DROP TABLE IF EXISTS `user_ecole`;
CREATE TABLE IF NOT EXISTS `user_ecole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ecole_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_ecole`
--

INSERT INTO `user_ecole` (`id`, `user_id`, `ecole_id`) VALUES
(22, 10, 2),
(21, 7, 3),
(4, 9, 1),
(5, 9, 2),
(20, 7, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
