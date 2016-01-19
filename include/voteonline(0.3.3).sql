SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `voteonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `voteonline`;

DROP TABLE IF EXISTS `adminlog`;
CREATE TABLE IF NOT EXISTS `adminlog` (
  `id` int(11) NOT NULL,
  `inituserinfo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `actiondate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `role` (`id`, `description`) VALUES
('Administrator', 'Zarządza innymi użytkownikami oraz bazą danych'),
('VoteAdministrator', 'Zarządza głosowaniami oraz odczytuje ich wyniki');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `login` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `password` char(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `roleid` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `users` (`id`, `login`, `password`, `email`, `roleid`) VALUES
(1, 'admin', '769371f4bc7414e07d90778085febe4f', 'admin@voteonline.com', 'Administrator'),
(2, 'voteadmin', '3ba63c57982e2f0c6fa5c392cda377fa', 'voteadmin@voteonline.com', 'VoteAdministrator');

DROP TABLE IF EXISTS `variants`;
CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `votingid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

DROP TABLE IF EXISTS `votelog`;
CREATE TABLE IF NOT EXISTS `votelog` (
  `id` int(11) NOT NULL,
  `inituserinfo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `actiondate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `variantid` int(11) NOT NULL,
  `votedate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

DROP TABLE IF EXISTS `voting`;
CREATE TABLE IF NOT EXISTS `voting` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


ALTER TABLE `adminlog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roleid` (`roleid`);

ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votingid` (`votingid`);

ALTER TABLE `votelog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variantid` (`variantid`);

ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `adminlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `votelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);

ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`votingid`) REFERENCES `voting` (`id`);

ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`variantid`) REFERENCES `variants` (`id`);

