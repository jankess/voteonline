-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Paź 2015, 11:47
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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('Administrator', 'Zarządza innymi użytkownikami oraz bazą danych');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `userrole`
--

CREATE TABLE IF NOT EXISTS `userrole` (
  `userlogin` varchar(255) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `userrole`
--

INSERT INTO `userrole` (`userlogin`, `roleid`) VALUES
('admin', 'Administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`login`, `password`, `email`) VALUES
('admin', 'admin', 'admin@voteonline.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `variants`
--

CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `variants`
--

INSERT INTO `variants` (`id`, `name`) VALUES
(1, 'Dexter'),
(2, 'Suits'),
(3, 'White Collar'),
(4, 'Constantine'),
(5, 'Breaking Bad'),
(6, 'Dolina Krzemowa'),
(7, 'Wirus'),
(8, 'Grimm'),
(9, 'Arrow'),
(10, 'Dominion');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `variantid` int(11) NOT NULL,
  `votedate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `votes`
--

INSERT INTO `votes` (`id`, `variantid`, `votedate`) VALUES
(1, 1, '2015-10-05'),
(2, 1, '2015-10-05'),
(3, 3, '2015-10-05'),
(4, 4, '2015-10-05'),
(5, 2, '2015-10-05'),
(6, 2, '2015-10-05'),
(7, 4, '2015-10-05'),
(8, 6, '2015-10-05'),
(10, 1, '2015-10-05'),
(11, 2, '2015-10-05'),
(12, 6, '2015-10-05'),
(14, 3, '2015-10-05'),
(15, 5, '2015-10-05'),
(16, 4, '2015-10-05'),
(19, 2, '2015-10-05'),
(20, 8, '2015-10-05'),
(21, 7, '2015-10-05'),
(22, 9, '2015-10-05'),
(23, 2, '2015-10-06'),
(24, 2, '2015-10-06'),
(25, 1, '2015-10-06'),
(26, 9, '2015-10-06'),
(27, 9, '2015-10-06'),
(28, 4, '2015-10-06'),
(29, 5, '2015-10-06'),
(30, 8, '2015-10-06'),
(31, 1, '2015-10-12'),
(32, 7, '2015-10-14'),
(33, 10, '2015-10-14'),
(34, 10, '2015-10-14'),
(35, 10, '2015-10-14'),
(36, 10, '2015-10-14'),
(37, 10, '2015-10-16'),
(38, 7, '2015-10-18'),
(39, 7, '2015-10-18'),
(40, 10, '2015-10-19');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`userlogin`,`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variantid` (`variantid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`variantid`) REFERENCES `variants` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
