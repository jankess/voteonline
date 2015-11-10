SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `voteonline` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `voteonline`;

CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `role` (`id`, `description`) VALUES
('Administrator', 'Zarządza innymi użytkownikami oraz bazą danych'),
('VoteAdministrator', 'Zarządza głosowaniami oraz odczytuje ich wyniki');

CREATE TABLE IF NOT EXISTS `userrole` (
  `userlogin` varchar(255) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `userrole` (`userlogin`, `roleid`) VALUES
('admin', 'Administrator'),
('voteadmin', 'VoteAdministrator');

CREATE TABLE IF NOT EXISTS `users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`login`, `password`, `email`) VALUES
('admin', 'admin', 'admin@voteonline.com'),
('voteadmin', 'voteadmin', 'voteadmin@voteonline.com');

CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `votingid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `variants` (`id`, `name`, `votingid`) VALUES
(1, 'Dexter', 1),
(2, 'Suits', 1),
(3, 'White Collar', 1),
(4, 'Constantine', 1),
(5, 'Breaking Bad', 1),
(6, 'Dolina Krzemowa', 1),
(7, 'Wirus', 1),
(8, 'Grimm', 1),
(9, 'Arrow', 1),
(10, 'Dominion', 1),
(15, 'Test', 1),
(16, 'gdfgdfgdf', 1);

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `variantid` int(11) NOT NULL,
  `votedate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

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
(40, 10, '2015-10-19'),
(41, 1, '2015-10-19'),
(42, 1, '2015-10-19'),
(43, 4, '2015-10-19'),
(44, 2, '2015-10-19'),
(45, 7, '2015-10-19'),
(46, 5, '2015-10-19'),
(47, 2, '2015-10-19'),
(48, 1, '2015-10-19'),
(50, 6, '2015-10-25'),
(51, 6, '2015-10-25'),
(52, 2, '2015-10-25'),
(63, 10, '2015-11-03'),
(64, 1, '2015-11-03'),
(65, 1, '2015-11-03'),
(66, 1, '2015-11-03'),
(67, 5, '2015-11-03'),
(68, 3, '2015-11-05'),
(69, 15, '2015-11-09'),
(70, 16, '2015-11-09');

CREATE TABLE IF NOT EXISTS `voting` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `voting` (`id`, `name`, `description`) VALUES
(1, 'Ulubiony serial', 'Twój ulubiony serial to ?'),
(2, 'Ulubiony film', 'Jaki jest twój ulubiony film'),
(3, 'Ulubiona potrawa', 'Jaka jest Twoja ulubiona potrawa ?');


ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userrole`
  ADD PRIMARY KEY (`userlogin`,`roleid`),
  ADD KEY `roleid` (`roleid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);

ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votingid` (`votingid`);

ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variantid` (`variantid`);

ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=71;
ALTER TABLE `voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_ibfk_1` FOREIGN KEY (`userlogin`) REFERENCES `users` (`login`),
  ADD CONSTRAINT `userrole_ibfk_2` FOREIGN KEY (`userlogin`) REFERENCES `users` (`login`),
  ADD CONSTRAINT `userrole_ibfk_3` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);

ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`votingid`) REFERENCES `voting` (`id`);

ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`variantid`) REFERENCES `variants` (`id`);
