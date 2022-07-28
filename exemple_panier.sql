-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 26 juil. 2022 à 12:05
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `exemple_panier`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `ID_adresse` int(11) NOT NULL AUTO_INCREMENT,
  `nom_adresse` varchar(255) NOT NULL,
  `prefixe_adresse` varchar(60) NOT NULL,
  `n_adresse` varchar(3) NOT NULL,
  `ID_ville` int(11) NOT NULL,
  PRIMARY KEY (`ID_adresse`),
  KEY `ID_ville` (`ID_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(255) NOT NULL,
  `img_categorie` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ID_commande` int(11) NOT NULL AUTO_INCREMENT,
  `total_commande` float NOT NULL,
  `statut_commande` int(11) NOT NULL,
  `ID_user_commande` int(11) NOT NULL,
  `identifiant_commande` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_commande`),
  KEY `ID_user_commande` (`ID_user_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_ligne`
--

DROP TABLE IF EXISTS `commande_ligne`;
CREATE TABLE IF NOT EXISTS `commande_ligne` (
  `ID_commande_ligne` int(11) NOT NULL AUTO_INCREMENT,
  `qte_commande_ligne` int(11) NOT NULL,
  `ID_commande_commande_ligne` int(11) NOT NULL,
  `ID_produit_commande_ligne` int(11) NOT NULL,
  PRIMARY KEY (`ID_commande_ligne`),
  KEY `ID_commande_commande_ligne` (`ID_commande_commande_ligne`),
  KEY `ID_produit_commande_ligne` (`ID_produit_commande_ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

DROP TABLE IF EXISTS `horaire`;
CREATE TABLE IF NOT EXISTS `horaire` (
  `ID_horaire` int(11) NOT NULL AUTO_INCREMENT,
  `debut_horaire` varchar(255) NOT NULL,
  `fin_horaire` varchar(255) NOT NULL,
  `ID_jour_horaire` int(11) NOT NULL,
  PRIMARY KEY (`ID_horaire`),
  KEY `ID_jour_horaire` (`ID_jour_horaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `info`
--

DROP TABLE IF EXISTS `info`;
CREATE TABLE IF NOT EXISTS `info` (
  `ID_info` int(11) NOT NULL AUTO_INCREMENT,
  `nom_info` varchar(255) NOT NULL,
  `tel_info` varchar(255) NOT NULL,
  `ID_adresse` int(11) NOT NULL,
  PRIMARY KEY (`ID_info`),
  KEY `ID_adresse` (`ID_adresse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `ID_ingredient` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ingredient` varchar(255) NOT NULL,
  `prix_ingredient` float NOT NULL,
  `dispo_ingredient` tinyint(1) NOT NULL,
  `ID_type_ingredient` int(11) NOT NULL,
  PRIMARY KEY (`ID_ingredient`),
  KEY `ID_type_ingredient` (`ID_type_ingredient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient_produit`
--

DROP TABLE IF EXISTS `ingredient_produit`;
CREATE TABLE IF NOT EXISTS `ingredient_produit` (
  `ID_ingredient_ingredient_produit` int(11) NOT NULL,
  `ID_produit_ingredient_produit` int(11) NOT NULL,
  KEY `ID_ingredient_ingredient_produit` (`ID_ingredient_ingredient_produit`),
  KEY `ID_produit_ingredient_produit` (`ID_produit_ingredient_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

DROP TABLE IF EXISTS `jour`;
CREATE TABLE IF NOT EXISTS `jour` (
  `ID_jour` int(11) NOT NULL AUTO_INCREMENT,
  `nom_jour` varchar(255) NOT NULL,
  `ID_info` int(11) NOT NULL,
  PRIMARY KEY (`ID_jour`),
  KEY `ID_info` (`ID_info`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `ID_offre` int(11) NOT NULL AUTO_INCREMENT,
  `taux_offre` float NOT NULL,
  `date_debut_offre` varchar(255) NOT NULL,
  `date_fin_offre` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_offre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `ID_panier` int(11) NOT NULL AUTO_INCREMENT,
  `total_panier` float NOT NULL,
  `ID_user_panier` int(11) NOT NULL,
  PRIMARY KEY (`ID_panier`),
  KEY `ID_user_panier` (`ID_user_panier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier_ligne`
--

DROP TABLE IF EXISTS `panier_ligne`;
CREATE TABLE IF NOT EXISTS `panier_ligne` (
  `ID_panier_ligne` int(11) NOT NULL AUTO_INCREMENT,
  `ID_panier_panier_ligne` int(11) NOT NULL,
  `ID_produit_panier_ligne` int(11) NOT NULL,
  `qte_panier_ligne` int(11) NOT NULL,
  PRIMARY KEY (`ID_panier_ligne`),
  KEY `ID_panier_panier_ligne` (`ID_panier_panier_ligne`),
  KEY `ID_produit_panier_ligne` (`ID_produit_panier_ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) NOT NULL,
  `prix_produit` varchar(255) NOT NULL,
  `img_produit` varchar(255) NOT NULL,
  `ID_taxe` int(11) NOT NULL,
  `ID_offre` int(11) DEFAULT NULL,
  `ID_categorie` int(11) NOT NULL,
  PRIMARY KEY (`ID_produit`),
  KEY `ID_taxe` (`ID_taxe`),
  KEY `ID_offre` (`ID_offre`),
  KEY `ID_categorie` (`ID_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `ID_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) NOT NULL DEFAULT '[ROLE_USER]',
  PRIMARY KEY (`ID_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplement_commande`
--

DROP TABLE IF EXISTS `supplement_commande`;
CREATE TABLE IF NOT EXISTS `supplement_commande` (
  `ID_ingredient_supplement_commande` int(11) NOT NULL,
  `ID_commande_ligne_supplement_commande` int(11) NOT NULL,
  KEY `ID_ingredient_supplement_commande` (`ID_ingredient_supplement_commande`),
  KEY `ID_commande_ligne_supplement_commande` (`ID_commande_ligne_supplement_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplement_panier`
--

DROP TABLE IF EXISTS `supplement_panier`;
CREATE TABLE IF NOT EXISTS `supplement_panier` (
  `ID_ingredient_supplement_panier` int(11) NOT NULL,
  `ID_panier_ligne_supplement_ipanier` int(11) NOT NULL,
  KEY `ID_ingredient_supplement_panier` (`ID_ingredient_supplement_panier`),
  KEY `ID_panier_ligne_supplement_ipanier` (`ID_panier_ligne_supplement_ipanier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `taxe`
--

DROP TABLE IF EXISTS `taxe`;
CREATE TABLE IF NOT EXISTS `taxe` (
  `ID_taxe` int(11) NOT NULL AUTO_INCREMENT,
  `taux_taxe` float NOT NULL,
  PRIMARY KEY (`ID_taxe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_ingredient`
--

DROP TABLE IF EXISTS `type_ingredient`;
CREATE TABLE IF NOT EXISTS `type_ingredient` (
  `ID_type_ingredient` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_ingredient` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_type_ingredient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(255) NOT NULL,
  `mail_user` varchar(255) NOT NULL,
  `mdp_user` varchar(255) NOT NULL,
  `prenom_user` varchar(255) NOT NULL,
  `tel_user` varchar(255) NOT NULL,
  `ID_role` int(11) NOT NULL,
  `ID_adresse` int(11) NOT NULL,
  PRIMARY KEY (`ID_user`),
  KEY `ID_adresse` (`ID_adresse`),
  KEY `ID_role` (`ID_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `ID_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(255) NOT NULL,
  `codePostal_ville` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`ID_ville`) REFERENCES `ville` (`ID_ville`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`ID_user_commande`) REFERENCES `user` (`ID_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande_ligne`
--
ALTER TABLE `commande_ligne`
  ADD CONSTRAINT `commande_ligne_ibfk_1` FOREIGN KEY (`ID_commande_commande_ligne`) REFERENCES `commande` (`ID_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ligne_ibfk_2` FOREIGN KEY (`ID_produit_commande_ligne`) REFERENCES `produit` (`ID_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `horaire`
--
ALTER TABLE `horaire`
  ADD CONSTRAINT `horaire_ibfk_1` FOREIGN KEY (`ID_jour_horaire`) REFERENCES `jour` (`ID_jour`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`ID_adresse`) REFERENCES `adresse` (`ID_adresse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`ID_type_ingredient`) REFERENCES `type_ingredient` (`ID_type_ingredient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ingredient_produit`
--
ALTER TABLE `ingredient_produit`
  ADD CONSTRAINT `ingredient_produit_ibfk_1` FOREIGN KEY (`ID_ingredient_ingredient_produit`) REFERENCES `ingredient` (`ID_ingredient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredient_produit_ibfk_2` FOREIGN KEY (`ID_produit_ingredient_produit`) REFERENCES `produit` (`ID_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `jour`
--
ALTER TABLE `jour`
  ADD CONSTRAINT `jour_ibfk_1` FOREIGN KEY (`ID_info`) REFERENCES `info` (`ID_info`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`ID_user_panier`) REFERENCES `user` (`ID_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier_ligne`
--
ALTER TABLE `panier_ligne`
  ADD CONSTRAINT `panier_ligne_ibfk_1` FOREIGN KEY (`ID_panier_panier_ligne`) REFERENCES `panier` (`ID_panier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `panier_ligne_ibfk_2` FOREIGN KEY (`ID_produit_panier_ligne`) REFERENCES `produit` (`ID_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`ID_categorie`) REFERENCES `categorie` (`ID_categorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`ID_offre`) REFERENCES `offre` (`ID_offre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`ID_taxe`) REFERENCES `taxe` (`ID_taxe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `supplement_commande`
--
ALTER TABLE `supplement_commande`
  ADD CONSTRAINT `supplement_commande_ibfk_1` FOREIGN KEY (`ID_commande_ligne_supplement_commande`) REFERENCES `commande_ligne` (`ID_commande_ligne`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supplement_commande_ibfk_2` FOREIGN KEY (`ID_ingredient_supplement_commande`) REFERENCES `ingredient` (`ID_ingredient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `supplement_panier`
--
ALTER TABLE `supplement_panier`
  ADD CONSTRAINT `supplement_panier_ibfk_1` FOREIGN KEY (`ID_panier_ligne_supplement_ipanier`) REFERENCES `panier_ligne` (`ID_panier_ligne`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supplement_panier_ibfk_2` FOREIGN KEY (`ID_ingredient_supplement_panier`) REFERENCES `ingredient` (`ID_ingredient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`ID_adresse`) REFERENCES `adresse` (`ID_adresse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`ID_role`) REFERENCES `role` (`ID_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
