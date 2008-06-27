-- 
-- Dumping data for table `categorie`
-- 

INSERT INTO `categorie` (`id`, `naamNL`, `naamEN`, `locatie`) VALUES 
(1, 'Elektriciteit', 'Electricity', 'kot'),
(2, 'Elektriciteit', 'Electricity', 'verdiep'),
(3, 'Meubilair', 'Furniture', 'kot'),
(4, 'Elektriciteit', 'Electricity', 'gemeenschappelijk'),
(5, 'Loodgieterswerk', 'Plumbing', 'kot'),
(6, 'Loodgieterswerk', 'Plumbing', 'verdiep'),
(7, 'Allerlei', 'Extra', 'kot');

-- 
-- Dumping data for table `herstelformulier`
-- 

INSERT INTO `herstelformulier` (`id`, `datum`, `status`, `userId`, `kamer`, `homeId`, `opmerking`) VALUES 
(1, '2008-06-26 20:14:29', 'ongezien', 2, '91.01.240.030', 1, 'Dit is mijn eerste herstelformuliertje ooit, cool h'),
(2, '2008-06-25 20:14:58', 'gezien', 1, '91.01.230.012', 1, 'Dit herstelformulier is al gezien, maar nog niet uitgevoerd.'),
(3, '2008-06-17 20:15:45', 'gedaan', 1, '91.01.230.012', 1, 'Dit herstelformulier is uitgevoerd, maar niet ge?valueerd.'),
(4, '2008-06-03 20:16:03', 'afgesloten', 2, '91.01.240.030', 1, 'Dit herstelformulier is uitgevoerd en afgesloten door de student.');

-- 
-- Dumping data for table `home`
-- 

INSERT INTO `home` (`id`, `korteNaam`, `langeNaam`, `adres`, `verdiepen`, `kamerPrefix`) VALUES 
(1, 'Boudewijn', 'Home Koning Boudewijn', 'Harelbekestraat 70', 14, '91.01'),
(2, 'Astrid', 'Home Koningin Astrid', 'Krijgslaan 250', 5, '91.02'),
(3, 'Fabiola', 'Home Koningin Fabiola', 'Stalhof 4', 7, '91.03'),
(4, 'Vermeylen', 'Home August Vermeylen', 'Stalhof 6', 8, '91.04'),
(5, 'Bertha', 'Home Bertha De Vriese', 'De Pintelaan 260B', 4, '91.05'),
(6, 'Heymans', 'Home Corneel Heymans', 'Isabellakaai 120', 7, '91.06');

-- 
-- Dumping data for table `personeel`
-- 

INSERT INTO `personeel` (`userId`) VALUES 
(1),
(2);

-- 
-- Dumping data for table `student`
-- 

INSERT INTO `student` (`userId`, `taal`, `homeId`, `kamer`, `telefoon`) VALUES 
(1, 'nl', 1, '91.01.230.012', 14715),
(2, 'nl', 1, '91.01.240.030', 14765);

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` (`id`, `gebruikersnaam`, `laatsteOnline`, `email`) VALUES 
(1, 'bmesuere', '2008-06-26 19:56:05', 'bart.mesuere@ugent.be'),
(2, 'bevdeghi', '2008-06-26 19:56:23', 'bert.vandeghinste@ugent.be');

-- 
-- Dumping data for table `velden`
-- 

INSERT INTO `velden` (`id`, `naamNL`, `naamEN`, `categorieId`, `homeId`, `verwijderd`) VALUES 
(1, 'Lamp boven lavabo', 'Lamp above the sink', 1, 1, 0),
(2, 'Bed: poot afgebroken', 'Bed: leg is broken', 3, 1, 0),
(3, 'Grote lichten', 'Striplighting', 1, 1, 0),
(4, 'Lamp boven bed', 'Lamp above the bed', 1, 1, 0),
(5, 'Schakelaar boven lavabo', 'Switch of lamp above the sink', 1, 1, 0),
(6, 'Schakelaar grote lichten', 'Switch of striplighting', 1, 1, 0),
(7, 'Schakelaar lamp boven bed', 'Switch of lamp above the bed', 1, 1, 0),
(8, 'Stopcontacten', 'Sockets', 1, 1, 0),
(9, 'Sifon lavabo lekt', 'Drain sink drips', 5, 1, 0),
(10, 'Kraan lavabo lekt', 'Tap sink leaks', 5, 1, 0),
(11, 'Lavabo verstopt', 'Sinkdrain is clogged', 5, 1, 0),
(12, 'Radiator sluit niet af', 'Radiator can not be turned off', 5, 1, 0),
(13, 'Radiator kraan lekt', 'Radiator tap leaks', 5, 1, 0),
(14, 'Radiator geeft geen warmte', 'No heating from radiator', 5, 1, 0),
(15, 'Skandiaflex', 'Persian blind', 7, 1, 0),
(16, 'Scharnier kast', 'Wardrobe hinge', 3, 1, 0);