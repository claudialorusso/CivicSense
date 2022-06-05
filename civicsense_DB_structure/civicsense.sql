-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 05, 2022 alle 12:26
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

--
-- Dump dei dati per la tabella `segnalazioni`
--

INSERT INTO `segnalazioni` (`id`, `tipo`, `gravita`, `datainv`, `orainv`, `via`, `foto`, `email`, `latitudine`, `longitudine`, `descrizione`, `stato`, `team`, `MONTH`) VALUES
(0, 1, NULL, '2022-06-15', '19:25:00', 'pippo 11', '', 'c.lorusso36@studenti.uniba.it', '11', '10', 'SOS', 'In attesa', '1', NULL),
(1, 1, 2, '0000-00-00', '19:20:00', 'Enrico 11', NULL, 'prova@example.com', '12', '11', 'oddio si è rotto il semaforo è FUXIAAA', 'In risoluzione', '1', 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `session`
--

CREATE TABLE `session` (
  `id` varchar(128) NOT NULL,
  `set_time` mediumblob NOT NULL,
  `data` mediumblob NOT NULL,
  `session_key` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `session`
--

INSERT INTO `session` (`id`, `set_time`, `data`, `session_key`) VALUES
('6oicarthdg9ojvkip1a28riikt', 0x31363534343234363433, 0x6e4478306a397a2b315177317666582f477a71652f31785345664553706d4b5254737a65663931427a49515466646878365667516a5456456e2f41364f38432f346f69352f382f634d79746e6e3238774b794947554244627546324d50746f354a55566453773d3d, 0x3631623961643034623362653738313861626531633937333864646364336564636539366336396238616664323139323439303764373866316234333064383435636636623832313830373166386233303465353466646264396237333538313432613138343663323262356433626462393437396339336539383266616664);

-- --------------------------------------------------------

--
-- Struttura della tabella `team`
--

CREATE TABLE `team` (
  `codice` int(40) NOT NULL,
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
(0, 'civicsense2019@gmail.com', 1, 'Claudia', 'admin', 1),
(1, 'francesclaudia@sse.uniba.it', 2, 'Claudia Lorusso, Francesco Gre', 'admin', 0);

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
