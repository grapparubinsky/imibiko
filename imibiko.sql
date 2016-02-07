-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `contatti`;
CREATE TABLE `contatti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_p` int(3) DEFAULT NULL,
  `comune` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `n_casa` varchar(255) DEFAULT NULL,
  `n_cell` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `gruppi`;
CREATE TABLE `gruppi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_gruppo` varchar(100) NOT NULL,
  `sorvegliante_id` int(11) NOT NULL,
  `assistente_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `proclamatori`;
CREATE TABLE `proclamatori` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gruppo_id` int(10) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `d_nascita` date DEFAULT NULL,
  `d_battesimo` date DEFAULT NULL,
  `unto` int(1) DEFAULT NULL,
  `anziano` int(1) DEFAULT NULL,
  `servitore` int(1) DEFAULT NULL,
  `pioniere` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `gruppo_id` (`gruppo_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_p` int(10) NOT NULL,
  `ts_report` int(10) unsigned NOT NULL,
  `pubb` int(11) DEFAULT NULL,
  `video` int(11) DEFAULT NULL,
  `ore` decimal(10,2) DEFAULT NULL,
  `visite` int(11) DEFAULT NULL,
  `studi` int(11) DEFAULT NULL,
  `note` mediumtext,
  `pioniere` int(10) NOT NULL DEFAULT '0',
  `irreg` int(10) NOT NULL DEFAULT '0',
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_p_ts_report` (`id_p`,`ts_report`),
  KEY `id_p` (`id_p`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-02-07 14:58:16
