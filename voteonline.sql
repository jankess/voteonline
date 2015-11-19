SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `voteonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `voteonline`;

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `role` (`id`, `description`) VALUES
('Administrator', 'Zarządza innymi użytkownikami oraz bazą danych'),
('VoteAdministrator', 'Zarządza głosowaniami oraz odczytuje ich wyniki');

DROP TABLE IF EXISTS `userrole`;
CREATE TABLE IF NOT EXISTS `userrole` (
  `userid` int(11) NOT NULL,
  `roleid` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `userrole` (`userid`, `roleid`) VALUES
('1', 'Administrator'),
('2', 'Administrator'),
('3', 'VoteAdministrator');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id`  int(11) NOT NULL, 
  `login` varchar(64) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `users` (`id`,`login`, `password`, `email`) VALUES
('1','admin', '769371f4bc7414e07d90778085febe4f', 'admin@voteonline.com'),
('2','test', 'bc900db7b68b78cf4dc51d3a889ab7a0', 'test@test.pl'),
('3','voteadmin', '3ba63c57982e2f0c6fa5c392cda377fa', 'voteadmin@voteonline.com');

DROP TABLE IF EXISTS `variants`;
CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `votingid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `variants` (`id`, `name`, `votingid`) VALUES
(1, 'Dexter', 1),
(2, 'Suits', 1),
(3, 'White Collar', 1),
(4, 'Constantine', 1),
(5, 'Breaking Bad', 1),
(6, 'Dolina Krzemowa', 1),
(7, 'Wirus', 1),
(8, 'Grimm', 1),
(9, 'Arrow', 1);

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `variantid` int(11) NOT NULL,
  `votedate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `votes` (`id`, `variantid`, `votedate`) VALUES
(1, 4, '2015-11-17'),
(2, 7, '2015-11-17'),
(3, 6, '2015-11-17');

DROP TABLE IF EXISTS `voting`;
CREATE TABLE IF NOT EXISTS `voting` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE utf8_polish_ci;

INSERT INTO `voting` (`id`, `name`, `description`, `active`) VALUES
(1, 'Ulubiony serial', 'Twój ulubiony serial', 1),
(2, 'Test głosowania', 'Pytanko', 0);


ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userrole`
  ADD PRIMARY KEY (`userid`,`roleid`),
  ADD KEY `roleid` (`roleid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votingid` (`votingid`);

ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variantid` (`variantid`);

ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
ALTER TABLE `voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userrole_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userrole_ibfk_3` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);

ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`votingid`) REFERENCES `voting` (`id`);

ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`variantid`) REFERENCES `variants` (`id`);

