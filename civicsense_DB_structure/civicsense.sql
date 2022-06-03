-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 03, 2022 alle 20:04
-- Versione del server: 10.4.22-MariaDB
-- Versione PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `civicsense`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazioni`
--

CREATE TABLE `segnalazioni` (
  `id` int(20) UNSIGNED NOT NULL,
  `tipo` tinyint(1) UNSIGNED NOT NULL,
  `gravita` int(15) DEFAULT NULL,
  `datainv` date NOT NULL,
  `orainv` time NOT NULL,
  `via` varchar(40) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `latitudine` varchar(20) NOT NULL,
  `longitudine` varchar(20) NOT NULL,
  `descrizione` varchar(200) NOT NULL,
  `stato` varchar(255) NOT NULL,
  `team` varchar(255) DEFAULT NULL,
  `MONTH` tinyint(2) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `session`
--

CREATE TABLE `session` (
  `id` varchar(128) NOT NULL,
  `set_time` varchar(10) NOT NULL,
  `data` date NOT NULL,
  `session_key` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `team`
--

CREATE TABLE `team` (
  `codice` varchar(40) NOT NULL,
  `email_t` varchar(64) NOT NULL,
  `n_persone` int(255) UNSIGNED NOT NULL,
  `nomi` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `team`
--

INSERT INTO `team` (`codice`, `email_t`, `n_persone`, `nomi`, `password`, `admin`) VALUES
('', 'francesclaudia@sse.uniba.it', 2, 'Claudia Lorusso, Francesco Gre', 'admin', 0),
('top1', 'civicsense2019@gmail.com', 1, 'Claudia', 'admin', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `segnalazioni`
--
ALTER TABLE `segnalazioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`codice`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
