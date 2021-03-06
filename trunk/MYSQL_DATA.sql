-- 
-- Dumping data for table `categorie`
-- 

INSERT INTO `categorie` VALUES  (1,'Elektriciteit','Electricity','kamer'),
 (2,'Sanitair','Plumbing','kamer'),
 (3,'Meubilair','Furniture','kamer'),
 (4,'Keuken','Kitchen','verdiep'),
 (5,'Badkamer Keukenkant','Bathroom Kitchenside','verdiep'),
 (6,'Badkamer Bijkeukenkant','Bathroom Sidekitchen','verdiep'),
 (7,'Bijkeuken','Sidekitchen','verdiep'),
 (8,'Gemeenschapsruimte','Recreationroom','gemeenschappelijk'),
 (9,'Hall','Hall','kamer'),
 (10,'Badkamer','Bathroom','kamer'),
 (11,'Kookhoek','Kitchen','kamer'),
 (12,'Verlichting','Lighting','kamer'),
 (13,'Schakelaars','Switches','kamer'),
 (14,'Stopcontacten','Sockets','kamer'),
 (15,'Overige','miscellaneous','kamer');

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

INSERT INTO `user` VALUES  (1,'bmesuere','Bart','Mesuere','2008-06-26 19:56:05','bart.mesuere@ugent.be'),
 (2,'bevdeghi','Bert','Vandeghinste','2008-06-26 19:56:23','bert.vandeghinste@ugent.be'),
 (3,'mmartens','Marianne','Martens','2008-09-09 16:10:37','Marianne.Martens@UGent.be'),
 (4,'dmathys','Dirk','Mathys','2008-09-09 16:10:47','Dirk.Mathys@UGent.be');



-- 
-- Dumping data for table `student`
-- 

INSERT INTO `student` (`userId`, `taal`, `homeId`, `kamer`, `telefoon`) VALUES 
(1, 'nl', 1, '91.01.230.012', 14715),
(2, 'nl', 1, '91.01.240.030', 14765);

-- 
-- Dumping data for table `velden`
--

INSERT INTO `velden` VALUES  (1,'Lamp boven lavabo','Lamp above the sink',1,1,0),
 (2,'Grote lichten','Striplighting',1,1,0),
 (3,'Lamp boven bed','Lamp above the bed',1,1,0),
 (4,'Schakelaar boven lavabo','Switch of lamp above the sink',1,1,0),
 (5,'Schakelaar grote lichten','Switch of striplighting',1,1,0),
 (6,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,1,0),
 (7,'Stopcontacten','Sockets',1,1,0),
 (8,'Telefoon','Phone',1,1,0),
 (9,'Sifon lavabo lekt','Drain sink drips',2,1,0),
 (10,'Kraan lavabo lekt','Tap sink leaks',2,1,0),
 (11,'Lavabo verstopt','Drain sink is clogged',2,1,0),
 (12,'Radiator sluit niet af','Radiator can not be turned off',2,1,0),
 (13,'Radiator kraan lekt','Radiator tap leaks',2,1,0),
 (14,'geen warmte uit radiator','radiator gives no heating',2,1,0),
 (15,'bedpoot afgebroken','leg of bed is broken',3,1,0),
 (16,'skandiaflex','persian blind',3,1,0),
 (17,'ingangsdeur slot','bedroomdoor lock is broken',3,1,0),
 (18,'ingangsdeur sleept','bedroomdoor drags',3,1,0),
 (19,'scharnier kast','hinge wardrobe',3,1,0),
 (20,'kast sluit niet','wardrobe doesnt close',3,1,0),
 (21,'bovenblad bureel beschadigd','desk has damaged tabletop',3,1,0),
 (22,'schuiven bij bureel','drawers of writingdesk',3,1,0),
 (23,'raamglas gebarsten','windowglass is broken',3,1,0),
 (24,'raam gaat niet open','window does not open',3,1,0),
 (25,'vloerbedekking beschadigd','floorcovering is damaged',3,1,0),
 (26,'plinten los','skirting-board has come off',3,1,0),
 (27,'Elektrisch vuurtje werkt niet','Electric stove doesnt work',4,1,0),
 (28,'Microgolf kapot','Microwaveoven broken',4,1,0),
 (29,'Niet schoongemaakt','Not cleaned well',7,1,0),
 (30,'TV kapot','TV broken',8,1,0),
 (31,'Pingpongtafel kapot','Pingpongtable broken',8,1,0),
 (32,'zetel','armchair',3,1,0),
 (33,'Niet schoongemaakt','Not cleaned well',4,1,0),
 (34,'Niet schoongemaakt','Not cleaned well',5,1,0),
 (35,'Niet schoongemaakt','Not cleaned well',6,1,0),
 (36,'Lamp boven lavabo','Lamp above the sink',1,3,0),
 (37,'Grote lichten','Striplighting',1,3,0),
 (38,'Lamp boven bed','Lamp above the bed',1,3,0),
 (39,'Schakelaar boven lavabo','Switch of lamp above the sink',1,3,0),
 (40,'Schakelaar grote lichten','Switch of striplighting',1,3,0),
 (41,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,3,0),
 (42,'Stopkontacten','Sockets',1,3,0),
 (43,'telefoon','telephone',1,3,0),
 (44,'Lavabo hangt los','Sink is loos',2,3,0),
 (45,'Lavabo sinfon lekt','Sink drain drips',2,3,0),
 (46,'Lavabo kraan lekt','Sink tap leaks',2,3,0),
 (47,'Lavabo verstopt','Sink drain is clogged',2,3,0),
 (48,'Handdoekdrager los','Towelbar loose',2,3,0),
 (49,'Radiator sluit niet af','Radiator can not be truned off',2,3,0),
 (50,'Radiator kraan lekt','Radiator tap leaks',2,3,0),
 (51,'Radiator geen warmte','Radiator no heating',2,3,0),
 (52,'Lattenbodem kapot','Bed frame damaged',3,3,0),
 (53,'Matrashoes vervangen','Replace zipper',3,3,0),
 (54,'Skandiaflex','Persian blind',3,3,0),
 (55,'Ingangsdeur slot','Bedroomdoor lock',3,3,0),
 (56,'Ingangsdeur sleept','Bedroomdoor drags',3,3,0),
 (57,'Kast scharnier','Wardrobe hinge',3,3,0),
 (58,'Kast sluit niet','Wardrobe doesn\'t close',3,3,0),
 (59,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,3,0),
 (60,'Bureel schuiven','Desk drawers',3,3,0),
 (61,'Raam gebarsten','Window is broken',3,3,0),
 (62,'Raam gaat niet open','Window does not open',3,3,0),
 (63,'Vloerbekleding beschadigd','Floorcovering is damaged',3,3,0),
 (64,'Plinten los','Skirting-board has come off',3,3,0),
 (65,'Stoel ontbreekt','Chair is missing',3,3,0),
 (66,'Lamp boven lavabo','Lamp above the sink',1,4,0),
 (67,'Grote lichten','Striplighting',1,4,0),
 (68,'Lamp boven bed','Lamp above the bed',1,4,0),
 (69,'Schakelaar boven lavabo','Switch of lamp above the sink',1,4,0),
 (70,'Schakelaar grote lichten','Switch of striplighting',1,4,0),
 (71,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,4,0),
 (72,'Stopkontacten','Sockets',1,4,0),
 (73,'telefoon','telephone',1,4,0),
 (74,'Lavabo hangt los','Sink is loos',2,4,0),
 (75,'Lavabo sinfon lekt','Sink drain drips',2,4,0),
 (76,'Lavabo kraan lekt','Sink tap leaks',2,4,0),
 (77,'Lavabo verstopt','Sink drain is clogged',2,4,0),
 (78,'Handdoekdrager los','Towelbar loose',2,4,0),
 (79,'Radiator sluit niet af','Radiator can not be truned off',2,4,0),
 (80,'Radiator kraan lekt','Radiator tap leaks',2,4,0),
 (81,'Radiator geen warmte','Radiator no heating',2,4,0),
 (82,'Lattenbodem kapot','Bed frame damaged',3,4,0),
 (83,'Matrashoes vervangen','Replace zipper',3,4,0),
 (84,'Skandiaflex','Persian blind',3,4,0),
 (85,'Ingangsdeur slot','Bedroomdoor lock',3,4,0),
 (86,'Ingangsdeur sleept','Bedroomdoor drags',3,4,0),
 (87,'Kast scharnier','Wardrobe hinge',3,4,0),
 (88,'Kast sluit niet','Wardrobe doesn\'t close',3,4,0),
 (89,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,4,0),
 (90,'Bureel schuiven','Desk drawers',3,4,0),
 (91,'Raam gebarsten','Window is broken',3,4,0),
 (92,'Raam gaat niet open','Window does not open',3,4,0),
 (93,'Vloerbekleding beschadigd','Floorcovering is damaged',3,4,0),
 (94,'Plinten los','Skirting-board has come off',3,4,0),
 (95,'Stoel ontbreekt','Chair is missing',3,4,0),
 (96,'Lamp boven lavabo','Lamp above the sink',1,2,0),
 (97,'Grote lichten','Striplighting',1,2,0),
 (98,'Lamp boven bed','Lamp above the bed',1,2,0),
 (99,'Schakelaar boven lavabo','Switch of lamp above the sink',1,2,0),
 (100,'Schakelaar grote lichten','Switch of striplighting',1,2,0),
 (101,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,2,0),
 (102,'Stopcontacten','Sockets',1,2,0),
 (103,'Telefoon','Phone',1,2,0),
 (104,'Sifon lavabo lekt','Drain sink drips',2,2,0),
 (105,'Kraan lavabo lekt','Tap sink leaks',2,2,0),
 (106,'Lavabo verstopt','Drain sink is clogged',2,2,0),
 (107,'Radiator sluit niet af','Radiator can not be turned off',2,2,0),
 (108,'Radiator kraan lekt','Radiator tap leaks',2,2,0),
 (109,'geen warmte uit radiator','radiator gives no heating',2,2,0),
 (110,'bedpoot afgebroken','leg of bed is broken',3,2,0),
 (111,'skandiaflex','persian blind',3,2,0),
 (112,'ingangsdeur slot','bedroomdoor lock is broken',3,2,0),
 (113,'ingangsdeur sleept','bedroomdoor drags',3,2,0),
 (114,'scharnier kast','hinge wardrobe',3,2,0),
 (115,'kast sluit niet','wardrobe doesnt close',3,2,0),
 (116,'bovenblad bureel beschadigd','desk has damaged tabletop',3,2,0),
 (117,'schuiven bij bureel','drawers of writingdesk',3,2,0),
 (118,'raamglas gebarsten','windowglass is broken',3,2,0),
 (119,'raam gaat niet open','window does not open',3,2,0),
 (120,'vloerbedekking beschadigd','floorcovering is damaged',3,2,0),
 (121,'plinten los','skirting-board has come off',3,2,0),
 (122,'Elektrisch vuurtje werkt niet','Electric stove doesnt work',4,2,0),
 (123,'Microgolf kapot','Microwaveoven broken',4,2,0),
 (124,'zetel','armchair',3,2,0),
 (125,'tv distributie','cable TV',1,2,0),
 (126,'licht toiletkastje','light bathroom cupboard',1,2,0),
 (127,'deur toiletkastje','door bathroom cupboard',2,2,0),
 (128,'spiegel toiletkastje','mirror bathroon cupboard',2,2,0),
 (129,'Deur','Door',9,5,0),
 (130,'Deurslot','Doorlock',9,5,0),
 (131,'Deurkruk','Doorknob',9,5,0),
 (132,'Muren','Walls',9,5,0),
 (133,'Plafond','Ceiling',9,5,0),
 (134,'Vloerbekleding','Floor',9,5,0),
 (135,'Deur','Door',10,5,0),
 (136,'Lavabo','Sink',10,5,0),
 (137,'Douche','Shower',10,5,0),
 (138,'Kastje onder lavabo','Cupboard under sink',10,5,0),
 (139,'Sproeier douche','Showerhead',10,5,0),
 (140,'Toilet','Toilet',10,5,0),
 (141,'Handdoekhouder','Towelbar',10,5,0),
 (142,'Papierrolhouder','Toilet paper dispenser',10,5,0),
 (143,'Zeephouder douche','Soapholder shower',10,5,0),
 (144,'muren','walls',10,5,0),
 (145,'kleerhanger',' cloth hanger',10,5,0),
 (146,'vloer','floor',10,5,0),
 (147,'spiegel','mirror',10,5,0),
 (148,'plafond','ceiling',10,5,0),
 (149,'bureautafel + laden','desk + drawers',3,5,0),
 (150,'bed + lattenbodem','bed',3,5,0),
 (151,'stoelen','chairs',3,5,0),
 (152,'matras','Mattress',3,5,0),
 (153,'Eettafel','Diningtable',3,5,0),
 (154,'Kleerkast','Wardrobe',3,5,0),
 (155,'Zetel','Sofa',3,5,0),
 (156,'Ingebouwde boekenkast','shelf',3,5,0),
 (157,'ijskast','fridge',11,5,0),
 (158,'verlichting ijskast','fridge light',11,5,0),
 (159,'vuilnisbakje','Bin',11,5,0),
 (160,'kookvuur','stove',11,5,0),
 (161,'knoppen kookplaten','knobs cooking plates',11,5,0),
 (162,'aanrecht','countertop',11,5,0),
 (163,'verlichting dampkap','lighting extractor hood',11,5,0),
 (164,'lade voor bestek','cutlery drawer',11,5,0),
 (165,'kast naast kleerkast','cupboard next to wardrobe',11,5,0),
 (166,'kast boven dampkap','cupboard above extractor hood',11,5,0),
 (167,'kast naast dampkap','cupboard next to extractor hood',11,5,0),
 (168,'hall','hall',12,5,0),
 (169,'badkamer','bathroom',12,5,0),
 (170,'leerruimte','livingroom',12,5,0),
 (171,'boven aanrecht','above countertop',12,5,0),
 (172,'boven bed','above bed',12,5,0),
 (173,'boven aanrecht','above countertop',13,5,0),
 (174,'boven bed','above bed',13,5,0),
 (175,'boven tafel','above table',13,5,0),
 (176,'in hall','in hall',13,5,0),
 (177,'zekeringkas','fusebox',1,5,0),
 (178,'internet-aansluitingsdoos','ethernet socket',1,5,0),
 (179,'televisie-distributie','cable TV',1,5,0),
 (180,'telefoon','phone',1,5,0),
 (181,'boven bureaublad','above desk',14,5,0),
 (182,'boven bed','above bed',14,5,0),
 (183,'in boekenkast','in shelf',14,5,0),
 (184,'in kookhoek','in kitchen',14,5,0),
 (185,'in badkamer','in bathroom',14,5,0),
 (186,'bij tafel','next to table',14,5,0),
 (187,'gordijnen','curtains',15,5,0),
 (188,'skandiaflex','persian blind',15,5,0),
 (189,'radiator','heating',15,5,0),
 (190,'vloeren leefruimte','floor livingroom',15,5,0),
 (191,'muren leefruimte','walls livingroom',15,5,0),
 (192,'plafond leefruimte','ceiling livingroom',15,5,0),
 (193,'raam','window',15,5,0);


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
INSERT INTO `personeel` VALUES  (1,0,0),
 (3,0,0),
 (4,0,1);

-- 
-- Dumping data for table `relatie_herstelformulier_velden`
-- 

INSERT INTO `relatie_herstelformulier_velden` (`herstelformulierId`, `veldId`, `referentienummer`) VALUES 
(1, 2, '0'),
(1, 6, '0'),
(2, 8, '0'),
(3, 4, '0'),
(2, 4, '0'),
(1, 15, '0'),
(1, 7, '0'),
(4, 1, '0');


--
-- Dumping data for table `relatie_personeel_home`
--
INSERT INTO `relatie_personeel_home` VALUES  (1,2),
 (1,1),
 (2,1),
 (3,1),
 (4,1),
 (5,1),
 (6,1),
 (1,3),
 (2,3),
 (3,3),
 (4,3),
 (5,3),
 (6,3),
 (1,4),
 (2,4),
 (5,4);
