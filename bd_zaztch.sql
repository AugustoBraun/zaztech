-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.23 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for zaztech
CREATE DATABASE IF NOT EXISTS `zaztech` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `zaztech`;

-- Dumping structure for table zaztech.login
CREATE TABLE IF NOT EXISTS `login` (
  `id_login` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nivel` int(11) DEFAULT '3',
  `nome` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `login` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `senha` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table zaztech.login: ~8 rows (approximately)
DELETE FROM `login`;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`id_login`, `nivel`, `nome`, `email`, `login`, `senha`) VALUES
	(1, 1, 'Usuário Teste', 'augusto@augustobraun.com', 'usuario', 'e8d95a51f3af4a3b134bf6bb680a213a'),
	(2, 3, 'Vitoria Pereira', '', '', NULL),
	(3, 3, 'Debora Castro', '', '', NULL),
	(4, 3, 'Sofia Rodrigues', '', '', NULL),
	(5, 3, 'Beatriz Souza', '', '', NULL),
	(6, 3, 'Diogo Dias', '', '', NULL),
	(7, 3, 'Matheus Cardoso', '', '', NULL),
	(8, 3, 'Lucas Rocha', '', '', NULL);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;

-- Dumping structure for table zaztech.tarefas
CREATE TABLE IF NOT EXISTS `tarefas` (
  `tarefaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioId` int(10) unsigned DEFAULT NULL,
  `tarefaNome` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tarefaPrioridade` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '2',
  `tarefaStatus` enum('a','b','c') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a = pendente, b = andamento, c = finalizada',
  `tarefaConcluida` timestamp NULL DEFAULT NULL,
  `tarefaInicio` date DEFAULT NULL,
  `tarefaFim` date DEFAULT NULL,
  `tarefaDescricao` text COLLATE utf8_unicode_ci,
  `tarefaCriada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tarefaEditada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tarefaAtiva` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `tarefaDesativada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tarefaId`),
  KEY `tarefaId` (`tarefaId`),
  KEY `usuarioId` (`usuarioId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table zaztech.tarefas: 0 rows
DELETE FROM `tarefas`;
/*!40000 ALTER TABLE `tarefas` DISABLE KEYS */;
INSERT INTO `tarefas` (`tarefaId`, `usuarioId`, `tarefaNome`, `tarefaPrioridade`, `tarefaStatus`, `tarefaConcluida`, `tarefaInicio`, `tarefaFim`, `tarefaDescricao`, `tarefaCriada`, `tarefaEditada`, `tarefaAtiva`, `tarefaDesativada`) VALUES
	(1, 3, NULL, '3', 'a', '2021-04-03 18:18:30', NULL, NULL, NULL, '2021-04-03 18:09:57', '2021-04-03 18:35:18', 'N', '2021-04-03 18:35:18'),
	(2, 6, NULL, '1', 'b', NULL, NULL, NULL, NULL, '2021-04-03 18:30:33', '2021-04-03 18:36:19', 'Y', NULL),
	(3, NULL, NULL, '2', 'a', NULL, NULL, NULL, NULL, '2021-04-03 18:36:32', '2021-04-03 18:36:32', 'Y', NULL),
	(4, NULL, NULL, '2', 'a', NULL, NULL, NULL, NULL, '2021-04-03 18:40:43', '2021-04-03 18:40:48', 'N', '2021-04-03 18:40:48'),
	(5, NULL, NULL, '2', 'a', NULL, NULL, NULL, NULL, '2021-04-03 18:53:48', '2021-04-03 18:53:48', 'Y', NULL),
	(6, NULL, NULL, '2', 'a', NULL, NULL, NULL, NULL, '2021-04-03 18:53:54', '2021-04-03 18:53:54', 'Y', NULL);
/*!40000 ALTER TABLE `tarefas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
