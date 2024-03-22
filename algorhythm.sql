-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 18, 2024 alle 08:42
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `algorhythm`
--
CREATE DATABASE IF NOT EXISTS `algorhythm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `algorhythm`;

-- --------------------------------------------------------

--
-- Struttura della tabella `album`
--

CREATE TABLE `album` (
  `ID_Album` varchar(30) NOT NULL,
  `ID_Artist` varchar(30) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `ReleaseDate` date DEFAULT NULL,
  `Popularity` int(11) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `artist`
--

CREATE TABLE `artist` (
  `ID_Artist` varchar(30) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Cognome` varchar(30) DEFAULT NULL,
  `Popularity` int(11) DEFAULT NULL,
  `Followers` int(11) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `containeralbum`
--

CREATE TABLE `containeralbum` (
  `ID_Album` varchar(30) DEFAULT NULL,
  `ID_Track` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `containerplaylist`
--

CREATE TABLE `containerplaylist` (
  `ID_Playlist` varchar(30) DEFAULT NULL,
  `ID_Track` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `follow`
--

CREATE TABLE `follow` (
  `ID_Artist` varchar(30) DEFAULT NULL,
  `ID_User` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `ID_User` varchar(30) DEFAULT NULL,
  `ID_Track` varchar(30) DEFAULT NULL,
  `IsFollowing` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `playlist`
--

CREATE TABLE `playlist` (
  `ID_Playlist` varchar(30) NOT NULL,
  `Owner` varchar(30) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Public` int(11) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `publish`
--

CREATE TABLE `publish` (
  `ID_Artist` varchar(30) DEFAULT NULL,
  `ID_Track` varchar(30) DEFAULT NULL,
  `Publisher` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `track`
--

CREATE TABLE `track` (
  `ID_Track` varchar(30) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Genre` varchar(30) DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `filePath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `track`
--

INSERT INTO `track` (`ID_Track`, `Name`, `Genre`, `Image`, `filePath`) VALUES
('65f7ef7bb1883', 'La Noia', 'Pop', 'songpictures/87233a74-019e-4d2c-b48a-af59cea9c720.jpeg', 'uploads/Angelina Mango - La noia (Official Video - Sanremo 2024).mp3'),
('65f7ef9a1b7', 'Tuta Gold', 'Pop', 'songpictures/120316919-01451dc4-bd7d-4753-a9bf-4f430712bc70.jpg', 'uploads/Mahmood - TUTA GOLD (Sanremo 2024).mp3'),
('65f7efb4', 'Oceans', 'Rock', 'songpictures/download.jpg', 'uploads/FRANK IERO and the PATIENCE - Oceans [Audio].mp3'),
('65f7efc7', 'Mary On A Cross', 'Pop', 'songpictures/ab67616d0000b273bef9b0a348ea8dd18a581025.jpg', 'uploads/Mary On A Cross (Slowed + Reverb).mp3'),
('65f7efda20ba0', 'Beggin', 'Rock', 'songpictures/Maneskin_2018.jpg', 'uploads/Måneskin - Beggin (LyricsTesto).mp3');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `ID_User` varchar(30) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DisplayName` varchar(16) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`ID_User`, `Email`, `DisplayName`, `Password`, `Country`, `Image`) VALUES
('65f7edf87', 'terranova@gmail.com', 'Terranova', 'Terranova123', 'IT', 'terranova.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `userhistory`
--

CREATE TABLE `userhistory` (
  `Date` datetime NOT NULL,
  `ID_User` varchar(30) DEFAULT NULL,
  `ID_Track` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`ID_Album`),
  ADD KEY `ID_Artist` (`ID_Artist`);

--
-- Indici per le tabelle `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`ID_Artist`);

--
-- Indici per le tabelle `containeralbum`
--
ALTER TABLE `containeralbum`
  ADD KEY `ID_Album` (`ID_Album`),
  ADD KEY `ID_Track` (`ID_Track`);

--
-- Indici per le tabelle `containerplaylist`
--
ALTER TABLE `containerplaylist`
  ADD KEY `ID_Playlist` (`ID_Playlist`),
  ADD KEY `ID_Track` (`ID_Track`);

--
-- Indici per le tabelle `follow`
--
ALTER TABLE `follow`
  ADD KEY `ID_Artist` (`ID_Artist`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Track` (`ID_Track`);

--
-- Indici per le tabelle `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`ID_Playlist`),
  ADD KEY `Owner` (`Owner`);

--
-- Indici per le tabelle `publish`
--
ALTER TABLE `publish`
  ADD KEY `ID_Artist` (`ID_Artist`),
  ADD KEY `ID_Track` (`ID_Track`);

--
-- Indici per le tabelle `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`ID_Track`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_User`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indici per le tabelle `userhistory`
--
ALTER TABLE `userhistory`
  ADD PRIMARY KEY (`Date`),
  ADD KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Track` (`ID_Track`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`ID_Artist`) REFERENCES `artist` (`ID_Artist`);

--
-- Limiti per la tabella `containeralbum`
--
ALTER TABLE `containeralbum`
  ADD CONSTRAINT `containeralbum_ibfk_1` FOREIGN KEY (`ID_Album`) REFERENCES `album` (`ID_Album`),
  ADD CONSTRAINT `containeralbum_ibfk_2` FOREIGN KEY (`ID_Track`) REFERENCES `track` (`ID_Track`);

--
-- Limiti per la tabella `containerplaylist`
--
ALTER TABLE `containerplaylist`
  ADD CONSTRAINT `containerplaylist_ibfk_1` FOREIGN KEY (`ID_Playlist`) REFERENCES `playlist` (`ID_Playlist`),
  ADD CONSTRAINT `containerplaylist_ibfk_2` FOREIGN KEY (`ID_Track`) REFERENCES `track` (`ID_Track`);

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`ID_Artist`) REFERENCES `artist` (`ID_Artist`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `user` (`ID_User`);

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `user` (`ID_User`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`ID_Track`) REFERENCES `track` (`ID_Track`);

--
-- Limiti per la tabella `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`Owner`) REFERENCES `user` (`ID_User`);

--
-- Limiti per la tabella `publish`
--
ALTER TABLE `publish`
  ADD CONSTRAINT `publish_ibfk_1` FOREIGN KEY (`ID_Artist`) REFERENCES `artist` (`ID_Artist`),
  ADD CONSTRAINT `publish_ibfk_2` FOREIGN KEY (`ID_Track`) REFERENCES `track` (`ID_Track`);

--
-- Limiti per la tabella `userhistory`
--
ALTER TABLE `userhistory`
  ADD CONSTRAINT `userhistory_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `user` (`ID_User`),
  ADD CONSTRAINT `userhistory_ibfk_2` FOREIGN KEY (`ID_Track`) REFERENCES `track` (`ID_Track`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
