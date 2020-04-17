-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 17 Avril 2020 à 11:54
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `dailyhealth`
--

-- --------------------------------------------------------

--
-- Structure de la table `dailystatut`
--

CREATE TABLE IF NOT EXISTS `dailystatut` (
  `idDaily` int(11) NOT NULL AUTO_INCREMENT,
  `Temperature` float NOT NULL,
  `Poux` float NOT NULL,
  `Tiredness` int(11) NOT NULL,
  `Mood` varchar(255) NOT NULL,
  `idPatient` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`idDaily`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `observation`
--

CREATE TABLE IF NOT EXISTS `observation` (
  `idObservation` int(11) NOT NULL AUTO_INCREMENT,
  `Sujet` varchar(255) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `idPatient` int(11) NOT NULL,
  `idMedecin` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`idObservation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(11) NOT NULL,
  `Age` int(11) NOT NULL,
  `Height` float NOT NULL,
  `Weight` float NOT NULL,
  `Role` varchar(255) NOT NULL,
  `IdMedecin` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
