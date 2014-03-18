-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2014 at 10:02 AM
-- Server version: 5.5.35
-- PHP Version: 5.5.3-1ubuntu2.2

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_p` int(11) NOT NULL,
  `comune` varchar(100) NOT NULL,
  `address` mediumtext NOT NULL,
  `n_casa` varchar(100) NOT NULL,
  `n_cell` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `proclamatori`
--

CREATE TABLE IF NOT EXISTS `proclamatori` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gruppo_id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `d_nascita` date NOT NULL,
  `d_battesimo` date NOT NULL,
  `unto` int(11) NOT NULL,
  `anziano` int(11) NOT NULL,
  `servitore` int(11) NOT NULL,
  `pioniere` int(11) NOT NULL,
  `status` int(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`),
  KEY `gruppo_id` (`gruppo_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_p` int(11) NOT NULL,
  `kid` varchar(100) NOT NULL,
  `mese` varchar(100) NOT NULL,
  `anno` varchar(100) NOT NULL,
  `libri` int(11) NOT NULL,
  `opuscoli` int(11) NOT NULL,
  `ore` decimal(10,2) NOT NULL,
  `riviste` int(11) NOT NULL,
  `visite` int(11) NOT NULL,
  `studi` int(11) NOT NULL,
  `note` mediumtext NOT NULL,
  `pioniere` int(10) NOT NULL DEFAULT '0',
  `unto` int(10) NOT NULL DEFAULT '0',
  `anziano` int(10) NOT NULL DEFAULT '0',
  `servitore` int(10) NOT NULL DEFAULT '0',
  `irreg` int(10) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`kid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=889 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
