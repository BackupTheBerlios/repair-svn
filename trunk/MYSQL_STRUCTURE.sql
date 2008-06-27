-- 
-- Table structure for table `categorie`
-- 

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL auto_increment,
  `naamNL` varchar(255) NOT NULL,
  `naamEN` varchar(255) NOT NULL,
  `locatie` enum('kot','verdiep','gemeenschappelijk') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `herstelformulier`
-- 

DROP TABLE IF EXISTS `herstelformulier`;
CREATE TABLE `herstelformulier` (
  `id` int(11) NOT NULL auto_increment,
  `datum` datetime NOT NULL,
  `status` enum('ongezien','gezien','gedaan','afgesloten') NOT NULL,
  `userId` int(11) NOT NULL,
  `kamer` varchar(13) NOT NULL,
  `homeId` int(11) NOT NULL,
  `opmerking` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`),
  KEY `homeId` (`homeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `home`
-- 

DROP TABLE IF EXISTS `home`;
CREATE TABLE `home` (
  `id` int(11) NOT NULL auto_increment,
  `korteNaam` varchar(255) NOT NULL,
  `langeNaam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `verdiepen` int(11) NOT NULL,
  `kamerPrefix` varchar(5) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `korteNaam` (`korteNaam`,`adres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `personeel`
-- 

DROP TABLE IF EXISTS `personeel`;
CREATE TABLE `personeel` (
  `userId` int(11) NOT NULL,
  PRIMARY KEY  (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `student`
-- 

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `userId` int(11) NOT NULL,
  `taal` enum('nl','en') NOT NULL,
  `homeId` int(11) NOT NULL,
  `kamer` varchar(13) NOT NULL,
  `telefoon` int(5) NOT NULL,
  UNIQUE KEY `userId` (`userId`,`kamer`,`telefoon`),
  KEY `homeId` (`homeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `gebruikersnaam` varchar(8) NOT NULL,
  `laatsteOnline` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `velden`
-- 

DROP TABLE IF EXISTS `velden`;
CREATE TABLE `velden` (
  `id` int(11) NOT NULL auto_increment,
  `naamNL` varchar(255) NOT NULL,
  `naamEN` varchar(255) NOT NULL,
  `categorieId` int(11) NOT NULL,
  `homeId` int(11) NOT NULL,
  `verwijderd` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `categorieId` (`categorieId`),
  KEY `homeId` (`homeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `herstelformulier`
-- 
ALTER TABLE `herstelformulier`
  ADD CONSTRAINT `herstelformulier_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `herstelformulier_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

-- 
-- Constraints for table `personeel`
-- 
ALTER TABLE `personeel`
  ADD CONSTRAINT `personeel_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `student`
-- 
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `velden`
-- 
ALTER TABLE `velden`
  ADD CONSTRAINT `velden_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `velden_ibfk_1` FOREIGN KEY (`categorieId`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;