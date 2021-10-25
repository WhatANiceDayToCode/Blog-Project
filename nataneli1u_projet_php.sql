-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Client :  devbdd.iutmetz.univ-lorraine.fr
-- Généré le :  Lun 25 Octobre 2021 à 14:30
-- Version du serveur :  10.3.31-MariaDB
-- Version de PHP :  7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `nataneli1u_projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `redacteur`
--

CREATE TABLE IF NOT EXISTS `redacteur` (
  `idRedacteur` int(5) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `adresseMail` varchar(50) NOT NULL,
  `motDePasse` varchar(30) NOT NULL,
  `pseudo` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `redacteur`
--

INSERT INTO `redacteur` (`idRedacteur`, `nom`, `prenom`, `adresseMail`, `motDePasse`, `pseudo`) VALUES
(1, 'Jean', 'Charles', 'charles.jean@gmail.com', 'Zozo123', 'JeanCharles1'),
(2, 'Pouetpouet', 'Hugo', 'tutut.pouetpouet@gmail.com', 'LaTotoMobile', 'Hugo_Lescargot');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
  `idReponse` int(11) NOT NULL,
  `idSujet` int(11) NOT NULL,
  `idRedacteur` int(11) NOT NULL,
  `dateRep` date NOT NULL,
  `texteReponse` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`idReponse`, `idSujet`, `idRedacteur`, `dateRep`, `texteReponse`) VALUES
(1, 1, 1, '2021-10-25', 'Très certainement car leurs bec permet de casser les aliments en morceaux'),
(2, 1, 2, '2021-10-26', 'Je suis tout a fait d''accord et ca me parait être cohérent');

-- --------------------------------------------------------

--
-- Structure de la table `sujet`
--

CREATE TABLE IF NOT EXISTS `sujet` (
  `idSujet` int(11) NOT NULL,
  `idRedacteur` int(11) NOT NULL,
  `titreSujet` varchar(50) NOT NULL,
  `texteSujet` varchar(255) NOT NULL,
  `dateSujet` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sujet`
--

INSERT INTO `sujet` (`idSujet`, `idRedacteur`, `titreSujet`, `texteSujet`, `dateSujet`) VALUES
(1, 2, 'Pourquoi les poules n''ont pas de dents ?', 'Je me demande vraiment pourquoi les poules n''ont pas de dents alors qu''elles pourraient manger des pommes', '2021-10-25');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `redacteur`
--
ALTER TABLE `redacteur`
  ADD PRIMARY KEY (`idRedacteur`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`idReponse`),
  ADD KEY `idSujet` (`idSujet`),
  ADD KEY `idRedacteur` (`idRedacteur`);

--
-- Index pour la table `sujet`
--
ALTER TABLE `sujet`
  ADD PRIMARY KEY (`idSujet`),
  ADD KEY `idRedacteur` (`idRedacteur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `redacteur`
--
ALTER TABLE `redacteur`
  MODIFY `idRedacteur` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `idReponse` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `sujet`
--
ALTER TABLE `sujet`
  MODIFY `idSujet` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`idSujet`) REFERENCES `sujet` (`idSujet`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `reponse_ibfk_2` FOREIGN KEY (`idRedacteur`) REFERENCES `redacteur` (`idRedacteur`);

--
-- Contraintes pour la table `sujet`
--
ALTER TABLE `sujet`
  ADD CONSTRAINT `sujet_ibfk_1` FOREIGN KEY (`idRedacteur`) REFERENCES `redacteur` (`idRedacteur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
