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

INSERT INTO `velden` VALUES   (1,'Lamp boven lavabo','Lamp above the sink',1,1,0);
INSERT INTO `velden` VALUES   (2,'Grote lichten','Striplighting',1,1,0);
INSERT INTO `velden` VALUES   (3,'Lamp boven bed','Lamp above the bed',1,1,0);
INSERT INTO `velden` VALUES   (4,'Schakelaar boven lavabo','Switch of lamp above the sink',1,1,0);
INSERT INTO `velden` VALUES   (5,'Schakelaar grote lichten','Switch of striplighting',1,1,0);
INSERT INTO `velden` VALUES   (6,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,1,0);
INSERT INTO `velden` VALUES   (7,'Stopcontacten','Sockets',1,1,0);
INSERT INTO `velden` VALUES   (8,'Telefoon','Phone',1,1,0);
INSERT INTO `velden` VALUES   (9,'Sifon lavabo lekt','Drain sink drips',2,1,0);
INSERT INTO `velden` VALUES   (10,'Kraan lavabo lekt','Tap sink leaks',2,1,0);
INSERT INTO `velden` VALUES   (11,'Lavabo verstopt','Drain sink is clogged',2,1,0);
INSERT INTO `velden` VALUES   (12,'Radiator sluit niet af','Radiator can not be turned off',2,1,0);
INSERT INTO `velden` VALUES   (13,'Radiator kraan lekt','Radiator tap leaks',2,1,0);
INSERT INTO `velden` VALUES   (14,'geen warmte uit radiator','radiator gives no heating',2,1,0);
INSERT INTO `velden` VALUES   (15,'bedpoot afgebroken','leg of bed is broken',3,1,0);
INSERT INTO `velden` VALUES   (16,'skandiaflex','persian blind',3,1,0);
INSERT INTO `velden` VALUES   (17,'ingangsdeur slot','bedroomdoor lock is broken',3,1,0);
INSERT INTO `velden` VALUES   (18,'ingangsdeur sleept','bedroomdoor drags',3,1,0);
INSERT INTO `velden` VALUES   (19,'scharnier kast','hinge wardrobe',3,1,0);
INSERT INTO `velden` VALUES   (20,'kast sluit niet','wardrobe doesnt close',3,1,0);
INSERT INTO `velden` VALUES   (21,'bovenblad bureel beschadigd','desk has damaged tabletop',3,1,0);
INSERT INTO `velden` VALUES   (22,'schuiven bij bureel','drawers of writingdesk',3,1,0);
INSERT INTO `velden` VALUES   (23,'raamglas gebarsten','windowglass is broken',3,1,0);
INSERT INTO `velden` VALUES   (24,'raam gaat niet open','window does not open',3,1,0);
INSERT INTO `velden` VALUES   (25,'vloerbedekking beschadigd','floorcovering is damaged',3,1,0);
INSERT INTO `velden` VALUES   (26,'plinten los','skirting-board has come off',3,1,0);
INSERT INTO `velden` VALUES   (27,'Elektrisch vuurtje werkt niet','Electric stove doesnt work',4,1,0);
INSERT INTO `velden` VALUES   (28,'Microgolf kapot','Microwaveoven broken',4,1,0);
INSERT INTO `velden` VALUES   (29,'Niet schoongemaakt','Not cleaned well',7,1,0);
INSERT INTO `velden` VALUES   (30,'TV kapot','TV broken',8,1,0);
INSERT INTO `velden` VALUES   (31,'Pingpongtafel kapot','Pingpongtable broken',8,1,0);
INSERT INTO `velden` VALUES   (32,'zetel','armchair',3,1,0);
INSERT INTO `velden` VALUES   (33,'Niet schoongemaakt','Not cleaned well',4,1,0);
INSERT INTO `velden` VALUES   (34,'Niet schoongemaakt','Not cleaned well',5,1,0);
INSERT INTO `velden` VALUES   (35,'Niet schoongemaakt','Not cleaned well',6,1,0);
INSERT INTO `velden` VALUES   (36,'Lamp boven lavabo','Lamp above the sink',1,3,0);
INSERT INTO `velden` VALUES   (37,'Grote lichten','Striplighting',1,3,0);
INSERT INTO `velden` VALUES   (38,'Lamp boven bed','Lamp above the bed',1,3,0);
INSERT INTO `velden` VALUES   (39,'Schakelaar boven lavabo','Switch of lamp above the sink',1,3,0);
INSERT INTO `velden` VALUES   (40,'Schakelaar grote lichten','Switch of striplighting',1,3,0);
INSERT INTO `velden` VALUES   (41,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,3,0);
INSERT INTO `velden` VALUES   (42,'Stopkontacten','Sockets',1,3,0);
INSERT INTO `velden` VALUES   (43,'telefoon','telephone',1,3,0);
INSERT INTO `velden` VALUES   (44,'Lavabo hangt los','Sink is loos',2,3,0);
INSERT INTO `velden` VALUES   (45,'Lavabo sinfon lekt','Sink drain drips',2,3,0);
INSERT INTO `velden` VALUES   (46,'Lavabo kraan lekt','Sink tap leaks',2,3,0);
INSERT INTO `velden` VALUES   (47,'Lavabo verstopt','Sink drain is clogged',2,3,0);
INSERT INTO `velden` VALUES   (48,'handdoekdrager los','',3,3,0);
INSERT INTO `velden` VALUES   (49,'Radiator sluit niet af','Radiator can not be truned off',2,3,0);
INSERT INTO `velden` VALUES   (50,'Radiator kraan lekt','Radiator tap leaks',2,3,0);
INSERT INTO `velden` VALUES   (51,'Radiator geen warmte','Radiator no heating',2,3,0);
INSERT INTO `velden` VALUES   (52,'Lattenbodem kapot','Bed frame damaged',3,3,0);
INSERT INTO `velden` VALUES   (53,'Matrashoes vervangen','Replace zipper',3,3,0);
INSERT INTO `velden` VALUES   (54,'Skandiaflex','Persian blind',3,3,0);
INSERT INTO `velden` VALUES   (55,'Ingangsdeur slot','Bedroomdoor lock',3,3,0);
INSERT INTO `velden` VALUES   (56,'Ingangsdeur sleept','Bedroomdoor drags',3,3,0);
INSERT INTO `velden` VALUES   (57,'Kast scharnier','Wardrobe hinge',3,3,0);
INSERT INTO `velden` VALUES   (58,'Kast sluit niet','Wardrobe doesn\'t close',3,3,0);
INSERT INTO `velden` VALUES   (59,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,3,0);
INSERT INTO `velden` VALUES   (60,'Bureel schuiven','Desk drawers',3,3,0);
INSERT INTO `velden` VALUES   (61,'Raam gebarsten','Window is broken',3,3,0);
INSERT INTO `velden` VALUES   (62,'Raam gaat niet open','Window does not open',3,3,0);
INSERT INTO `velden` VALUES   (63,'Vloerbekleding beschadigd','Floorcovering is damaged',3,3,0);
INSERT INTO `velden` VALUES   (64,'Plinten los','Skirting-board has come off',3,3,0);
INSERT INTO `velden` VALUES   (65,'Stoel ontbreekt','Chair is missing',3,3,0);
INSERT INTO `velden` VALUES   (66,'Lamp boven lavabo','Lamp above the sink',1,4,0);
INSERT INTO `velden` VALUES   (67,'Grote lichten','Striplighting',1,4,0);
INSERT INTO `velden` VALUES   (68,'Lamp boven bed','Lamp above the bed',1,4,0);
INSERT INTO `velden` VALUES   (69,'Schakelaar boven lavabo','Switch of lamp above the sink',1,4,0);
INSERT INTO `velden` VALUES   (70,'Schakelaar grote lichten','Switch of striplighting',1,4,0);
INSERT INTO `velden` VALUES   (71,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,4,0);
INSERT INTO `velden` VALUES   (72,'Stopkontacten','Sockets',1,4,0);
INSERT INTO `velden` VALUES   (73,'telefoon','telephone',1,4,0);
INSERT INTO `velden` VALUES   (74,'Lavabo hangt los','Sink is loos',2,4,0);
INSERT INTO `velden` VALUES   (75,'Lavabo sinfon lekt','Sink drain drips',2,4,0);
INSERT INTO `velden` VALUES   (76,'Lavabo kraan lekt','Sink tap leaks',2,4,0);
INSERT INTO `velden` VALUES   (77,'Lavabo verstopt','Sink drain is clogged',2,4,0);
INSERT INTO `velden` VALUES   (78,'handdoekdrager los','',3,4,0);
INSERT INTO `velden` VALUES   (79,'Radiator sluit niet af','Radiator can not be truned off',2,4,0);
INSERT INTO `velden` VALUES   (80,'Radiator kraan lekt','Radiator tap leaks',2,4,0);
INSERT INTO `velden` VALUES   (81,'Radiator geen warmte','Radiator no heating',2,4,0);
INSERT INTO `velden` VALUES   (82,'Lattenbodem kapot','Bed frame damaged',3,4,0);
INSERT INTO `velden` VALUES   (83,'Matrashoes vervangen','Replace zipper',3,4,0);
INSERT INTO `velden` VALUES   (84,'Skandiaflex','Persian blind',3,4,0);
INSERT INTO `velden` VALUES   (85,'Ingangsdeur slot','Bedroomdoor lock',3,4,0);
INSERT INTO `velden` VALUES   (86,'Ingangsdeur sleept','Bedroomdoor drags',3,4,0);
INSERT INTO `velden` VALUES   (87,'Kast scharnier','Wardrobe hinge',3,4,0);
INSERT INTO `velden` VALUES   (88,'Kast sluit niet','Wardrobe doesn\'t close',3,4,0);
INSERT INTO `velden` VALUES   (89,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,4,0);
INSERT INTO `velden` VALUES   (90,'Bureel schuiven','Desk drawers',3,4,0);
INSERT INTO `velden` VALUES   (91,'Raam gebarsten','Window is broken',3,4,0);
INSERT INTO `velden` VALUES   (92,'Raam gaat niet open','Window does not open',3,4,0);
INSERT INTO `velden` VALUES   (93,'Vloerbekleding beschadigd','Floorcovering is damaged',3,4,0);
INSERT INTO `velden` VALUES   (94,'Plinten los','Skirting-board has come off',3,4,0);
INSERT INTO `velden` VALUES   (95,'Stoel ontbreekt','Chair is missing',3,4,0);

-- 
-- Dumping data for table `herstelformulier`
-- 

INSERT INTO `herstelformulier` (`id`, `factuurnummer`, `datum`, `status`, `userId`, `kamer`, `homeId`, `opmerking`) VALUES 
(1, '0', '2008-06-26 20:14:29', 'ongezien', 2, '91.01.240.030', 1, ''),
(2, '0', '2008-06-25 20:14:58', 'gezien', 1, '91.01.230.012', 1, 'Dit herstelformulier is al gezien, maar nog niet uitgevoerd.'),
(3, '0', '2008-06-17 20:15:45', 'gedaan', 1, '91.01.230.012', 1, 'Dit herstelformulier is uitgevoerd, maar niet geevalueerd.'),
(4, '0', '2008-06-03 20:16:03', 'afgesloten', 2, '91.01.240.030', 1, 'Dit herstelformulier is uitgevoerd en afgesloten door de student.');

--
-- Dumping data for table `personeel`
--
INSERT INTO `personeel` VALUES   (1,0,0);

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
(1, 7),
(4, 1);

-- 
-- Dumping data for table `relatie_personeel_home`
-- 

INSERT INTO `relatie_personeel_home` (`homeId`, `personeelId`) VALUES 
(1, 1),
(1, 2);
