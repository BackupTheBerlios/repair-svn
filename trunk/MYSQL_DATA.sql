-- 
-- Dumping data for table `categorie`
-- 

INSERT INTO `categorie` (`id`, `naamNL`, `naamEN`, `locatie`) VALUES 
(1, 'Elektriciteit', 'Electricity', 'kot'),
(2, 'Loodgieterswerk', 'Plumbing', 'kot'),
(3, 'Meubilair', 'Furniture', 'kot'),
(4, 'Keuken', 'Kitchen', 'verdiep'),
(5, 'Badkamer Keukenkant', 'Bathroom Kitchenside', 'verdiep'),
(6, 'Badkamer Bijkeukenkant', 'Bathroom Sidekitchen', 'verdiep'),
(7, 'Bijkeuken', 'Sidekitchen', 'verdiep'),
(8, 'Gemeenschapsruimte', 'Recreationroom', 'gemeenschappelijk');

-- 
-- Dumping data for table `home`
-- 

INSERT INTO `home` (`id`, `korteNaam`, `langeNaam`, `adres`, `verdiepen`, `kamerPrefix`, `ldapNaam`, `verwijderd`, `basistelefoonnummer`, `kamersperverdiep`) VALUES 
(1, 'Boudewijn', 'Home Koning Boudewijn', 'Harelbekestraat 70', 14, '91.01', 'HOME BOUDEWIJN', 0, '14287', '32'),
(2, 'Astrid', 'Home Koningin Astrid', 'Krijgslaan 250', 5, '53.01', 'HOME ASTRID', 0, '12622', '55'),
(3, 'Fabiola', 'Home Koningin Fabiola', 'Stalhof 4', 7, '31.02', 'HOME FABIOLA', 0, '13987', '32'),
(4, 'Vermeylen', 'Home August Vermeylen', 'Stalhof 6', 8, '55.01', 'HOME VERMEYLEN', 0, '00000', '32'),
(5, 'Bertha', 'Home Bertha De Vriese', 'De Pintelaan 260B', 4, '40.13', 'HOME BERTHA DE VRIESE', 0, '00000', '32'),
(6, 'Heymans', 'Home Corneel Heymans', 'Isabellakaai 120', 7, '55.02', 'HOME HEYMANS', 0, '00000', '32');

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` (`id`, `gebruikersnaam`, `voornaam`, `achternaam`, `laatsteOnline`, `email`) VALUES 
(1, 'bmesuere', 'Bart', 'Mesuere', '2008-06-26 19:56:05', 'bart.mesuere@ugent.be'),
(2, 'bevdeghi', 'Bert', 'Vandeghinste', '2008-06-26 19:56:23', 'bert.vandeghinste@ugent.be');



-- 
-- Dumping data for table `student`
-- 

INSERT INTO `student` (`userId`, `taal`, `homeId`, `kamer`, `telefoon`) VALUES 
(1, 'nl', 1, '91.01.230.012', 14715),
(2, 'nl', 1, '91.01.240.030', 14765);

-- 
-- Dumping data for table `velden`
--

INSERT INTO `velden` (`id`, `naamNL`, `naamEN`, `categorieId`, `homeId`, `verwijderd`) VALUES 
(1, 'Lamp boven lavabo', 'Lamp above the sink', 1, 1, 0),
(2, 'Grote lichten', 'Striplighting', 1, 1, 0),
(3, 'Lamp boven bed', 'Lamp above the bed', 1, 1, 0),
(4, 'Schakelaar boven lavabo', 'Switch of lamp above the sink', 1, 1, 0),
(5, 'Schakelaar grote lichten', 'Switch of striplighting', 1, 1, 0),
(6, 'Schakelaar lamp boven bed', 'Switch of lamp above the bed', 1, 1, 0),
(7, 'Stopcontacten', 'Sockets', 1, 1, 0),
(8, 'Telefoon', 'Phone', 1, 1, 0),
(9, 'Sifon lavabo lekt', 'Drain sink drips', 2, 1, 0),
(10, 'Kraan lavabo lekt', 'Tap sink leaks', 2, 1, 0),
(11, 'Lavabo verstopt', 'Drain sink is clogged', 2, 1, 0),
(12, 'Radiator sluit niet af', 'Radiator can not be turned off', 2, 1, 0),
(13, 'Radiator kraan lekt', 'Radiator tap leaks', 2, 1, 0),
(14, 'geen warmte uit radiator', 'radiator gives no heating', 2, 1, 0),
(15, 'bedpoot afgebroken', 'leg of bed is broken', 3, 1, 0),
(16, 'skandiaflex', 'persian blind', 3, 1, 0),
(17, 'ingangsdeur slot', 'bedroomdoor lock is broken', 3, 1, 0),
(18, 'ingangsdeur sleept', 'bedroomdoor drags', 3, 1, 0),
(19, 'scharnier kast', 'hinge wardrobe', 3, 1, 0),
(20, 'kast sluit niet', 'wardrobe doesnt close', 3, 1, 0),
(21, 'bovenblad bureel beschadigd', 'desk has damaged tabletop', 3, 1, 0),
(22, 'schuiven bij bureel', 'drawers of writingdesk', 3, 1, 0),
(23, 'raamglas gebarsten', 'windowglass is broken', 3, 1, 0),
(24, 'raam gaat niet open', 'window does not open', 3, 1, 0),
(25, 'vloerbedekking beschadigd', 'floorcovering is damaged', 3, 1, 0),
(26, 'plinten los', 'skirting-board has come off', 3, 1, 0),
(27, 'Elektrisch vuurtje werkt niet', 'Electric stove doesnt work', 4, 1, 0),
(28, 'Microgolf kapot', 'Microwaveoven broken', 4, 1, 0),
(29, 'Niet schoongemaakt', 'Not cleaned well', 7, 1, 0),
(30, 'TV kapot', 'TV broken', 8, 1, 0),
(31, 'Pingpongtafel kapot', 'Pingpongtable broken', 8, 1, 0);

-- 
-- Dumping data for table `herstelformulier`
-- 

INSERT INTO `herstelformulier` (`id`, `factuurnummer`, `datum`, `status`, `userId`, `kamer`, `homeId`, `opmerking`) VALUES 
(1, '0', '2008-06-26 20:14:29', 'ongezien', 2, '91.01.240.030', 1, ''),
(2, '0', '2008-06-25 20:14:58', 'gezien', 1, '91.01.230.012', 1, 'Dit herstelformulier is al gezien, maar nog niet uitgevoerd.'),
(3, '0', '2008-06-17 20:15:45', 'gedaan', 1, '91.01.230.012', 1, 'Dit herstelformulier is uitgevoerd, maar niet geevalueerd.'),
(4, '0', '2008-06-03 20:16:03', 'afgesloten', 2, '91.01.240.030', 1, 'Dit herstelformulier is uitgevoerd en afgesloten door de student.');

-- 
-- Dumping data for table `relatie_herstelformulier_velden`
-- 

INSERT INTO `relatie_herstelformulier_velden` (`herstelformulierId`, `veldId`) VALUES 
(1, 2),
(1, 6),
(2, 8),
(3, 4),
(2, 4),
(1, 15),
(1, 6),
(4, 1);

-- 
-- Dumping data for table `relatie_personeel_home`
-- 

INSERT INTO `relatie_personeel_home` (`homeId`, `personeelId`) VALUES 
(1, 1),
(1, 2);
