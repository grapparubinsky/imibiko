-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2014 at 01:08 AM
-- Server version: 5.5.35
-- PHP Version: 5.4.6-1ubuntu1.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `imibiko`
--

-- --------------------------------------------------------

--
-- Table structure for table `contatti`
--

CREATE TABLE IF NOT EXISTS `contatti` (
  `id_p` int(11) NOT NULL,
  `comune` varchar(100) NOT NULL,
  `address` mediumtext NOT NULL,
  `n_casa` varchar(100) NOT NULL,
  `n_cell` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contatti`
--

INSERT INTO `contatti` (`id_p`, `comune`, `address`, `n_casa`, `n_cell`) VALUES
(1, 'Roma', 'Via Roma 1', '', '3332854984'),
(8, 'Frascati', 'Via anagnina 15', '', '356531221'),
(9, 'Frascati', 'Via Dante, 18', '0651658655', '3912654231');

-- --------------------------------------------------------

--
-- Table structure for table `gruppi`
--

CREATE TABLE IF NOT EXISTS `gruppi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_gruppo` varchar(100) NOT NULL,
  `sorvegliante_id` int(11) NOT NULL,
  `assistente_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gruppi`
--

INSERT INTO `gruppi` (`id`, `nome_gruppo`, `sorvegliante_id`, `assistente_id`, `timestamp`) VALUES
(3, 'Rossi', 5, 9, '2014-03-01 23:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `proclamatori`
--

CREATE TABLE IF NOT EXISTS `proclamatori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gruppo_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `d_nascita` date NOT NULL,
  `d_battesimo` date NOT NULL,
  `unto` int(11) NOT NULL,
  `anziano` int(11) NOT NULL,
  `servitore` int(11) NOT NULL,
  `pioniere` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`),
  KEY `gruppo_id` (`gruppo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `proclamatori`
--

INSERT INTO `proclamatori` (`id`, `gruppo_id`, `nome`, `cognome`, `d_nascita`, `d_battesimo`, `unto`, `anziano`, `servitore`, `pioniere`, `timestamp`) VALUES
(1, 0, 'Mario', 'Rossi', '1994-07-28', '2010-11-27', 0, 0, 0, 0, '2014-03-01 19:51:44'),
(8, 0, 'Flavio', 'Insinna', '1955-10-25', '1975-10-10', 0, 1, 0, 0, '2014-03-01 20:51:08'),
(9, 3, 'John', 'Doe', '1991-05-19', '2014-03-04', 0, 1, 0, 2, '2014-03-01 21:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_p` int(11) NOT NULL,
  `mese` varchar(100) NOT NULL,
  `anno` varchar(100) NOT NULL,
  `libri` int(11) NOT NULL,
  `opuscoli` int(11) NOT NULL,
  `ore` int(11) NOT NULL,
  `riviste` int(11) NOT NULL,
  `visite` int(11) NOT NULL,
  `studi` int(11) NOT NULL,
  `note` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_p`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_p` (`id_p`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
