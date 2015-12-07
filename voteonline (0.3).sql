-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Gru 2015, 18:29
-- Wersja serwera: 5.6.26
-- Wersja PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `voteonline`
--
CREATE DATABASE IF NOT EXISTS `voteonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `voteonline`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adminlog`
--

DROP TABLE IF EXISTS `adminlog`;
CREATE TABLE IF NOT EXISTS `adminlog` (
  `id` int(11) NOT NULL,
  `inituserinfo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `actiondate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `adminlog`
--

INSERT INTO `adminlog` (`id`, `inituserinfo`, `action`, `actiondate`) VALUES
(1, 'admin', 'TEST LOGU', '2015-12-07 00:00:00'),
(6, 'admin', 'Usunięcie użytkownika "inny"', '2015-12-07 16:49:22'),
(7, 'admin', 'Usunięcie użytkownika "test"', '2015-12-07 16:49:23'),
(8, 'admin', 'Dodanie użytkownika "test"', '2015-12-07 16:51:43'),
(12, 'admin', 'Edycja danych użytkownika test1 (nowy login "test")', '2015-12-07 16:58:05'),
(13, 'admin', 'Edycja danych użytkownika test', '2015-12-07 16:58:20'),
(14, 'admin', 'Zmiana własnego hasła dostępowego', '2015-12-07 17:00:13'),
(15, 'admin', 'Edycja danych użytkownika test', '2015-12-07 17:12:30'),
(16, 'admin', 'Edycja hasła użytkownika "test', '2015-12-07 17:12:41'),
(17, 'admin', 'Edycja hasła użytkownika "test"', '2015-12-07 17:13:45'),
(26, 'admin', 'Logowanie do aplikacji', '2015-12-07 17:20:53'),
(27, 'voteadmin', 'Logowanie do aplikacji', '2015-12-07 17:21:15'),
(28, 'admin', 'Logowanie do aplikacji', '2015-12-07 17:21:25'),
(29, 'admin', 'Logowanie do aplikacji', '2015-12-07 17:24:40'),
(30, 'admin', 'Logowanie do aplikacji z adresu ip:192.168.1.106', '2015-12-07 17:26:19'),
(31, 'admin', 'Dodanie użytkownika "admin2"', '2015-12-07 17:27:28'),
(35, 'voteadmin', 'Logowanie do aplikacji z IP:::1', '2015-12-07 17:31:39'),
(37, 'voteadmin', 'Zmiana własnego hasła dostępowego', '2015-12-07 18:24:14'),
(38, 'admin', 'Logowanie do aplikacji z IP:::1', '2015-12-07 18:24:20');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('Administrator', 'Zarządza innymi użytkownikami oraz bazą danych'),
('VoteAdministrator', 'Zarządza głosowaniami oraz odczytuje ich wyniki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `login` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `password` char(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `roleid` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `roleid`) VALUES
(1, 'admin', '769371f4bc7414e07d90778085febe4f', 'admin@voteonline.com', 'Administrator'),
(3, 'voteadmin', '3ba63c57982e2f0c6fa5c392cda377fa', 'voteadmin@voteonline.com', 'VoteAdministrator'),
(12, 'test', 'bc900db7b68b78cf4dc51d3a889ab7a0', 'test@test.pl', 'VoteAdministrator'),
(13, 'admin2', 'ca4e551be0973d0d623f59e17a1d0a91', 'admin2@voteonline.pl', 'Administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `variants`
--

DROP TABLE IF EXISTS `variants`;
CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `votingid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `variants`
--

INSERT INTO `variants` (`id`, `name`, `votingid`) VALUES
(1, 'Dexter', 1),
(2, 'Suits', 1),
(3, 'White Collar', 1),
(4, 'Constantine', 1),
(5, 'Breaking Bad', 1),
(6, 'Dolina Krzemowa', 1),
(7, 'Wirus', 1),
(8, 'Grimm', 1),
(10, 'One Punch Man', 1),
(13, 'C/C++', 3),
(14, 'C#', 3),
(15, 'Java', 3),
(16, 'Arrow', 1),
(17, 'Blindspot', 1),
(18, 'Flash', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votelog`
--

DROP TABLE IF EXISTS `votelog`;
CREATE TABLE IF NOT EXISTS `votelog` (
  `id` int(11) NOT NULL,
  `inituserinfo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `actiondate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `votelog`
--

INSERT INTO `votelog` (`id`, `inituserinfo`, `action`, `actiondate`) VALUES
(1, 'voteadmin', 'Dodanie nowego wariantu ("Flash") do głosowania (id:1)', '2015-12-07 18:03:14'),
(2, 'voteadmin', 'Dodanie nowego głosowania (Test)', '2015-12-07 18:21:26'),
(3, 'voteadmin', 'Dodanie nowego wariantu ("Test") do głosowania (id:4)', '2015-12-07 18:21:36'),
(4, 'voteadmin', 'Zmiana danych głosowania (id:4)', '2015-12-07 18:21:43'),
(5, 'voteadmin', 'Edycja danych wariantu (id:19)', '2015-12-07 18:21:56'),
(6, 'voteadmin', 'Usunięcie wariantu (id:19) oraz powiązanych z nim głosów', '2015-12-07 18:22:03'),
(7, 'voteadmin', 'Usunięcie głosowania (id:4) oraz powiązanych z nim wariantów i głosów', '2015-12-07 18:22:09'),
(8, 'voteadmin', 'Głosowanie o id :3" zostało aktywowane', '2015-12-07 18:22:15'),
(9, 'voteadmin', 'Głosowanie o id :"1" zostało aktywowane', '2015-12-07 18:23:31'),
(10, 'voteadmin', 'Głosowanie o id :3 zostało aktywowane', '2015-12-07 18:23:47'),
(11, 'voteadmin', 'Głosowanie o id :1 zostało aktywowane', '2015-12-07 18:23:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `variantid` int(11) NOT NULL,
  `votedate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `votes`
--

INSERT INTO `votes` (`id`, `variantid`, `votedate`) VALUES
(1, 4, '2015-11-17'),
(2, 7, '2015-11-17'),
(3, 6, '2015-11-17'),
(4, 10, '2015-11-19'),
(5, 10, '2015-11-19'),
(6, 10, '2015-12-06'),
(7, 10, '2015-12-07'),
(8, 14, '2015-12-07'),
(9, 15, '2015-12-07'),
(10, 13, '2015-12-07'),
(11, 14, '2015-12-07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `voting`
--

DROP TABLE IF EXISTS `voting`;
CREATE TABLE IF NOT EXISTS `voting` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `voting`
--

INSERT INTO `voting` (`id`, `name`, `description`, `active`) VALUES
(1, 'Ulubiony serial', 'Twój ulubiony serial', 1),
(3, 'Język programowania', 'Jaki język programowania preferujesz?', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `adminlog`
--
ALTER TABLE `adminlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roleid` (`roleid`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votingid` (`votingid`);

--
-- Indexes for table `votelog`
--
ALTER TABLE `votelog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variantid` (`variantid`);

--
-- Indexes for table `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `adminlog`
--
ALTER TABLE `adminlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT dla tabeli `votelog`
--
ALTER TABLE `votelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `voting`
--
ALTER TABLE `voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);

--
-- Ograniczenia dla tabeli `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`votingid`) REFERENCES `voting` (`id`);

--
-- Ograniczenia dla tabeli `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`variantid`) REFERENCES `variants` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
