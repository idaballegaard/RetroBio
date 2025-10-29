DROP DATABASE IF EXISTS RetroBioDB;
CREATE DATABASE RetroBioDB;
USE RetroBioDB;

CREATE TABLE Company (
    companyID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar (255) NOT NULL
);

CREATE TABLE Genre (
    genreID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar (255) NOT NULL
);

CREATE TABLE CastMember (
    castMemberID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName varchar (255) NOT NULL,
    lastName varchar (255) NOT NULL
);

CREATE TABLE Movie (
    movieID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar (255) NOT NULL,
    `description` varchar (1000) NOT NULL,
    releaseYear int NOT NULL,
    `length` int NOT NULL,
    `language` varchar (100) NOT NULL,
    ageLimit int NOT NULL,
    ranking float NULL,
    directorID int NOT NULL,
    companyID int NOT NULL
);

CREATE TABLE MovieGenre (
    movieID int NOT NULL,
    genreID int NOT NULL,
    CONSTRAINT PK_MovieGenre PRIMARY KEY (movieID, genreID),
    FOREIGN KEY (movieID) REFERENCES Movie(movieID),
    FOREIGN KEY (genreID) REFERENCES Genre(genreID)
);

CREATE TABLE MovieActor (
    movieID int NOT NULL,
    castMemberID int NOT NULL,
    CONSTRAINT PK_MovieActors PRIMARY KEY (movieID, castMemberID),
    FOREIGN KEY (movieID) REFERENCES Movie(movieID),
    FOREIGN KEY (castMemberID) REFERENCES CastMembers(castMemberID)
);

CREATE TABLE Showing (
    showingID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date` date NOT NULL,
    startTime time NOT NULL,
    `type` varchar (100) NULL,
    price float NOT NULL,
    movieID int NOT NULL,
    hallID int NOT NULL,
    FOREIGN KEY (movieID) REFERENCES Movie(movieID)
);

CREATE TABLE Hall (  
    hallID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar (255) NOT NULL,
    `number` int NOT NULL
);

ALTER TABLE Showing
ADD FOREIGN KEY (hallID) REFERENCES Hall(hallID); 

CREATE TABLE Seat (
    seatID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `number` int NOT NULL,
    rowNumber int NOT NULL,
    hallID int NOT NULL,
    FOREIGN KEY (hallID) REFERENCES Hall(hallID)
);

CREATE TABLE `Order` (
    orderID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    price float NOT NULL,
    `date` date NOT NULL,
    `status` varchar (100) NOT NULL,
    numberOfTickets int NOT NULL,
    userID int NOT NULL,
    showingID int NOT NULL,
    FOREIGN KEY (showingID) REFERENCES Showing(showingID)
);

CREATE TABLE PostalCode (
    postalCodeID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    postalCode varchar (20) NOT NULL,
    city varchar (100) NOT NULL
);

CREATE TABLE `User` (
    userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName varchar (255) NOT NULL,
    lastName varchar (255) NOT NULL,
    userName varchar (100) NOT NULL,
    hashedPassword varchar (60) NOT NULL,
    email varchar (255) NOT NULL,
    phone varchar (20) NOT NULL,
    country varchar (100) NOT NULL,
    street varchar (255) NOT NULL,
    streetNumber varchar (20) NOT NULL,
    postalCodeID int NOT NULL,
    FOREIGN KEY (postalCodeID) REFERENCES PostalCode(postalCodeID)
);

ALTER TABLE `Order`
ADD FOREIGN KEY (userID) REFERENCES User(userID);

CREATE TABLE OrderSeat (
    orderID int NOT NULL,
    seatID int NOT NULL,
    CONSTRAINT PK_OrderSeat PRIMARY KEY (orderID, seatID),
    FOREIGN KEY (orderID) REFERENCES `Order`(orderID),
    FOREIGN KEY (seatID) REFERENCES Seat(seatID)
);

CREATE TABLE News (
    newsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar (100) NOT NULL,
    `description` varchar (1000) NOT NULL,
    releaseDate DATE NOT NULL
)




-- Realistic testdata
USE RetroBioDB;

-- POSTAL CODES
INSERT INTO PostalCode (postalCode, city) VALUES
('SW1A 1AA', 'London'),
('BS1 4ST', 'Bristol'),
('M1 1AE', 'Manchester'),
('B1 1AA', 'Birmingham'),
('EH1 1YZ', 'Edinburgh'),
('L1 8JQ', 'Liverpool'),
('75001', 'Paris'),
('1000', 'Brussels'),
('1012', 'Amsterdam'),
('101', 'Reykjavik');

-- BRUGERE (50)
INSERT INTO User (firstName,lastName,email,phone,country,street,streetNumber,postalCodeID,username) VALUES
('Alice','Thompson','alice.t@example.com','+447700900111','United Kingdom','Baker Street','221B',1,'athompson'),
('George','Miller','george.m@example.com','+447700900222','United Kingdom','King Street','12',2,'gmiller'),
('Hannah','Wilson','hannah.w@example.com','+447700900333','United Kingdom','Oxford Road','77',3,'hwilson'),
('Oliver','Brown','oliver.b@example.com','+447700900444','United Kingdom','Victoria Square','5A',4,'obrown'),
('Sophie','Davies','sophie.d@example.com','United Kingdom','Princes Street','102',5,'sdavies'),
('Jack','Roberts','jack.r@example.com','United Kingdom','Hope Street','34',6,'jroberts'),
('Emma','Johnson','emma.j@example.com','United Kingdom','High Street','22',1,'ejohnson'),
('Liam','Smith','liam.s@example.com','United Kingdom','Queen Street','5',2,'lsmith'),
('Isla','Taylor','isla.t@example.com','United Kingdom','Kingston Road','13',3,'itaylor'),
('Noah','Evans','noah.e@example.com','United Kingdom','George Street','9',4,'nevans'),
('Chloe','Walker','chloe.w@example.com','United Kingdom','Main Road','21',1,'cwalker'),
('Lucas','Harris','lucas.h@example.com','United Kingdom','Church Lane','8',2,'lharris'),
('Mia','Lewis','mia.l@example.com','United Kingdom','High Street','18',3,'mlewis'),
('Ethan','Young','ethan.y@example.com','United Kingdom','Victoria Road','6',4,'eyoung'),
('Olivia','Scott','olivia.s@example.com','United Kingdom','King Street','14',5,'oscott'),
('Henry','King','henry.k@example.com','United Kingdom','Queen Street','11',6,'hking'),
('Sophia','Green','sophia.g@example.com','United Kingdom','Oxford Road','7',1,'sgreen'),
('William','Baker','william.b@example.com','United Kingdom','Hope Street','10',2,'wbaker'),
('Amelia','Adams','amelia.a@example.com','United Kingdom','Church Lane','5',3,'aadams'),
('James','Nelson','james.n@example.com','United Kingdom','Main Street','12',4,'jnelson'),
('Isabella','Mitchell','isabella.m@example.com','United Kingdom','Kingston Road','2',5,'imitchell'),
('Alexander','Carter','alexander.c@example.com','United Kingdom','George Street','3',6,'acarter'),
('Emily','Collins','emily.c@example.com','United Kingdom','Victoria Square','7',1,'ecollins'),
('Daniel','Stewart','daniel.s@example.com','United Kingdom','Baker Street','9',2,'dstewart'),
('Ella','Simmons','ella.s@example.com','United Kingdom','Queen Street','4',3,'esimmons'),
('Matthew','Parker','matthew.p@example.com','United Kingdom','High Street','16',4,'mparker'),
('Charlotte','Foster','charlotte.f@example.com','United Kingdom','Church Lane','12',5,'cfoster'),
('Sebastian','Ward','sebastian.w@example.com','United Kingdom','Oxford Road','15',6,'sward'),
('Ava','Reed','ava.r@example.com','United Kingdom','Hope Street','8',1,'areed'),
('Benjamin','Cook','benjamin.c@example.com','United Kingdom','King Street','6',2,'bcook'),
('Lily','Morgan','lily.m@example.com','United Kingdom','Victoria Road','3',3,'lmorgan'),
('Daniel','Bell','daniel.b@example.com','United Kingdom','George Street','14',4,'dbell'),
('Grace','Murphy','grace.m@example.com','United Kingdom','Queen Street','2',5,'gmurphy'),
('Joseph','Bailey','joseph.b@example.com','United Kingdom','High Street','19',6,'jbailey'),
('Hannah','Richardson','hannah.r@example.com','United Kingdom','Church Lane','11',1,'hrichardson'),
('Ryan','Wood','ryan.w@example.com','United Kingdom','Oxford Road','9',2,'rwood'),
('Zoe','Hughes','zoe.h@example.com','United Kingdom','Hope Street','6',3,'zohughes'),
('Samuel','Edwards','samuel.e@example.com','United Kingdom','Main Street','8',4,'sedwards'),
('Megan','Turner','megan.t@example.com','United Kingdom','King Street','13',5,'mturner'),
('Nathan','Watson','nathan.w@example.com','United Kingdom','Victoria Road','5',6,'nwatson'),
('Jessica','Gray','jessica.g@example.com','France','Paris','Rue de Rivoli','10',7,'jgray'),
('Leo','James','leo.j@example.com','Belgium','Brussels','Rue Royale','22',8,'ljames'),
('Ella','Harrison','ella.h@example.com','Holland','Amsterdam','Keizersgracht','15',9,'eharrison'),
('Oscar','Reynolds','oscar.r@example.com','Iceland','Reykjavik','Laugavegur','3',10,'oreynolds'),
('Sofia','Cole','sofia.c@example.com','United Kingdom','Hope Street','15',5,'scole'),
('Jacob','Ward','jacob.w@example.com','United Kingdom','Oxford Road','18',6,'jward'),
('Luna','Morgan','luna.m@example.com','United Kingdom','Baker Street','14',1,'lmorgan2'),
('Charlie','Bennett','charlie.b@example.com','United Kingdom','Queen Street','10',2,'cbennett'),
('Harper','Cook','harper.c@example.com','United Kingdom','Victoria Road','8',3,'hcook'),
('Eli','Brooks','eli.b@example.com','United Kingdom','Main Street','6',4,'ebrooks'),
('Chloe','Gray','chloe.g@example.com','United Kingdom','High Street','21',5,'chgray'),
('Max','Hughes','max.h@example.com','United Kingdom','Oxford Road','11',6,'mhughes');

-- HALLS
INSERT INTO Hall (hallName, hallNumber) VALUES
('Main Hall', 1),
('Classic Lounge', 2),
('Cult Cellar', 3);

-- SEATS
-- Main Hall 10x10
INSERT INTO Seat (rowNumber, seatNumber, hallID)
SELECT r,s,1 FROM 
(SELECT 1 r UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) rows,
(SELECT 1 s UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) seats;

-- Classic Lounge 8x8
INSERT INTO Seat (rowNumber, seatNumber, hallID)
SELECT r,s,2 FROM 
(SELECT 1 r UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) rows,
(SELECT 1 s UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) seats;

-- Cult Cellar 6x6
INSERT INTO Seat (rowNumber, seatNumber, hallID)
SELECT r,s,3 FROM 
(SELECT 1 r UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6) rows,
(SELECT 1 s UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6) seats;

-- MOVIES
INSERT INTO Movie (titel, `description`, `length`, `language`, director, genre, actors, ageLimit, ranking) VALUES
('Back to the Future','Teenager rejser tilbage i tiden i en DeLorean',116,'English','Robert Zemeckis','Sci-Fi','Michael J. Fox, Christopher Lloyd',7,8.5),
('The Breakfast Club','Fem high school elever mødes i detention',97,'English','John Hughes','Drama','Emilio Estevez, Molly Ringwald',15,8.1),
('Pulp Fiction','Livene for to mob hitmen og flere personer krydser hinanden',154,'English','Quentin Tarantino','Crime','John Travolta, Uma Thurman, Samuel L. Jackson',18,8.9),
('The Thing','Et forskerhold i Antarktis jages af en formskiftende alien',109,'English','John Carpenter','Horror','Kurt Russell',18,8.2),
('Ghostbusters','Tre videnskabsmænd starter et spøgelsesfirma',105,'English','Ivan Reitman','Comedy','Bill Murray, Dan Aykroyd',12,7.8),
('Blade Runner','Blade runner skal terminere replicants der stjal et rumskib',117,'English','Ridley Scott','Sci-Fi','Harrison Ford',15,8.1),
('Fight Club','En kontormedarbejder og en sæbefabrikant starter en undergrundsklub',139,'English','David Fincher','Drama','Brad Pitt, Edward Norton',18,8.8),
('The Big Lebowski','Jeff "The Dude" Lebowski involveres i en kidnapningssag',117,'English','Coen Brothers','Comedy','Jeff Bridges, John Goodman',15,8.1),
('Inglourious Basterds','En gruppe jødiske soldater planlægger at myrde nazistiske ledere',153,'English','Quentin Tarantino','War','Brad Pitt, Christoph Waltz',18,8.3),
('The Shining','En mand bliver sindssyg mens han passer et isoleret hotel om vinteren',146,'English','Stanley Kubrick','Horror','Jack Nicholson',18,8.4),
('E.T. the Extra-Terrestrial','En dreng hjælper en rumvæsen med at komme hjem',115,'English','Steven Spielberg','Family','Henry Thomas, Drew Barrymore',7,7.9),
('The Goonies','En gruppe børn finder et skattekort og går på eventyr',114,'English','Richard Donner','Adventure','Sean Astin, Josh Brolin',12,7.8),
('Die Hard','En politimand kæmper mod terrorister i en skyskraber',132,'English','John McTiernan','Action','Bruce Willis',15,8.2),
('The Princess Bride','En ung kvinde og hendes elskede går på eventyr for at redde hende',98,'English','Rob Reiner','Fantasy','Cary Elwes, Robin Wright',12,8.1),
('Aliens','En gruppe marinesoldater konfronterer en hær af aliens på en fjern planet',137,'English','James Cameron','Sci-Fi','Sigourney Weaver',15,8.4),
('The Terminator','En cyborg sendes tilbage i tiden for at dræbe en kvinde hvis søn vil lede modstanden mod maskinerne',107,'English','James Cameron','Sci-Fi','Arnold Schwarzenegger',15,8.0),
('The Evil Dead','En gruppe venner frigør en ond ånd i en hytte i skoven',85,'English','Sam Raimi','Horror','Bruce Campbell',18,7.5),
('The Dark Crystal','En ung Gelfling går på en quest for at redde sin verden fra ondskab',93,'English','Jim Henson','Fantasy','Jim Henson, Frank Oz',7,7.2),
('Labyrinth','En pige navigerer gennem et magisk labyrint for at redde sin bror fra Jareth',101,'English','Jim Henson','Fantasy','Jennifer Connelly, David Bowie',12,7.4),
('Stand by Me','Fire drenge går på en eventyr for at finde en drengs lig',89,'English','Rob Reiner','Drama','Wil Wheaton, River Phoenix',15,8.1),
('The NeverEnding Story','En dreng læser en magisk bog der trækker ham ind i en fantasiverden',102,'English','Wolfgang Petersen','Fantasy','Noah Hathaway, Barret Oliver',7,7.4),
('Top Gun','En ung pilot træner ved den prestigefyldte Top Gun skole',110,'English','Tony Scott','Action','Tom Cruise, Kelly McGillis',15,6.9),
('A Nightmare on Elm Street','Teenagere bliver myrdet i deres drømme af Freddy Krueger',91,'English','Wes Craven','Horror','Robert Englund',18,7.5),
('The Sandlot','En gruppe drenge tilbringer sommeren med baseball og eventyr',101,'English','David Mickey Evans','Family','Tom Guiry, Mike Vitar',7,7.8),
('The Blues Brothers','To brødre genforenes for at redde det børnehjem de voksede op på',133,'English','John Landis','Musical','John Belushi, Dan Aykroyd',12,7.9),
('The Fifth Element','En taxachauffør hjælper en mystisk kvinde med at redde verden',126,'English','Luc Besson','Sci-Fi','Bruce Willis, Milla Jovovich',15,7.7),
('The Crow','En mand genopstår fra de døde for at hævne sin og sin forlovedes mord',102,'English','Alex Proyas','Action','Brandon Lee',18,7.6);

-- --- VISNINGER ---
INSERT INTO Showing(`type`,startTime,`date`,showingPrice,hallID,movieID) VALUES
('Babybio','11:00:00','2025-11-17',7,3,1),
('2D','19:00:00','2025-11-17',9,2,1),
('3D','21:00:00','2025-11-17',12,1,2),
('2D','19:00:00','2025-11-18',9,2,2),
('3D','21:00:00','2025-11-18',12,3,1),
('2D','19:00:00','2025-11-19',9,2,3),
('3D','21:00:00','2025-11-19',12,3,4),
('Babybio','11:00:00','2025-11-20',7,1,3),
('2D','19:00:00','2025-11-20',9,2,4),
('3D','21:00:00','2025-11-20',12,3,3),
('2D','19:00:00','2025-11-21',9,2,5),
('3D','21:00:00','2025-11-21',12,3,6),
('2D','19:00:00','2025-11-22',9,2,6),
('3D','21:00:00','2025-11-22',12,3,5),
('2D','19:00:00','2025-11-23',9,2,7),
('3D','21:00:00','2025-11-23',12,3,8),
('Babybio','11:00:00','2025-11-24',7,1,7),
('2D','19:00:00','2025-11-24',9,2,8),
('3D','21:00:00','2025-11-24',12,3,7),
('2D','19:00:00','2025-11-25',9,2,9),
('3D','21:00:00','2025-11-25',12,3,10);
('2D','19:00:00','2025-11-26',9,2,10),
('3D','21:00:00','2025-11-26',12,1,9),
('Babybio','11:00:00','2025-11-27',7,1,11),
('2D','19:00:00','2025-11-27',9,2,11),
('3D','21:00:00','2025-11-27',12,3,12),
('2D','19:00:00','2025-11-28',9,2,12),
('3D','21:00:00','2025-11-28',12,3,11),
('2D','19:00:00','2025-11-29',9,2,13),
('3D','21:00:00','2025-11-29',12,3,14),
('2D','19:00:00','2025-11-30',9,2,14),
('3D','21:00:00','2025-11-30',12,3,13),
('Babybio','11:00:00','2025-12-01',7,1,15),
('2D','19:00:00','2025-12-01',9,2,15),
('3D','21:00:00','2025-12-01',12,3,16),
('2D','19:00:00','2025-12-02',9,2,16),
('3D','21:00:00','2025-12-02',12,3,15),
('2D','19:00:00','2025-12-03',9,2,17),
('3D','21:00:00','2025-12-03',12,3,18),
('Babybio','11:00:00','2025-12-04',7,1,18),
('2D','19:00:00','2025-12-04',9,2,18),
('3D','21:00:00','2025-12-04',12,3,17),
('2D','19:00:00','2025-12-05',9,2,19),
('3D','21:00:00','2025-12-05',12,3,20),
('2D','19:00:00','2025-12-06',9,2,20),
('3D','21:00:00','2025-12-06',12,3,19),
('2D','19:00:00','2025-12-07',9,2,21),
('3D','21:00:00','2025-12-07',12,3,22),
('Babybio','11:00:00','2025-12-08',7,1,22),
('2D','19:00:00','2025-12-08',9,2,22),
('3D','21:00:00','2025-12-08',12,3,21),
('2D','19:00:00','2025-12-09',9,2,23),
('3D','21:00:00','2025-12-09',12,3,24),
('2D','19:00:00','2025-12-10',9,2,24),
('3D','21:00:00','2025-12-10',12,3,23),
('Babybio','11:00:00','2025-12-11',7,1,25),
('2D','19:00:00','2025-12-11',9,2,25),
('3D','21:00:00','2025-12-11',12,3,26),
('2D','19:00:00','2025-12-12',9,2,26),
('3D','21:00:00','2025-12-12',12,3,25),
('2D','19:00:00','2025-12-13',9,2,27),
('3D','21:00:00','2025-12-13',12,3,28),
('2D','19:00:00','2025-12-14',9,2,28),
('3D','21:00:00','2025-12-14',12,3,27);

-- --- BILLETTER ---
-- Vi laver 1-4 sæder pr. ticket, tilfældige brugere
-- Eksempelvis 120 billetter spredt over alle visninger

INSERT INTO Ticket(purchasePrice,dateOfPurchase,purchaseStatus,numberOfTickets,userID,showingID,seatID) VALUES
(14,'2025-11-10','Paid',2,1,1,1),
(9,'2025-11-11','Paid',1,2,2,10),
(36,'2025-11-12','Paid',3,3,3,20),
(7,'2025-11-13','Paid',1,4,4,5),
(18,'2025-11-14','Paid',2,5,5,12),
(28,'2025-11-15','Paid',2,6,6,15),
(12,'2025-11-16','Paid',1,7,7,8),
(21,'2025-11-17','Paid',3,8,8,22),
(7,'2025-11-18','Paid',1,9,9,3),
(24,'2025-11-19','Paid',2,10,10,30);

-- Tilføj flere billetter på samme mønster til hele måneden
-- Hver billet bruger 1-4 sæder og en tilfældig brugerID 1-50

-- --- CONTAINS ---
-- Kobling af billetter til sæder
INSERT INTO Contains(ticketID,seatID) VALUES
(1,1),(1,2),
(2,10),
(3,20),(3,21),(3,22),
(4,5),
(5,12),(5,13),
(6,15),(6,16),
(7,8),
(8,22),(8,23),(8,24),
(9,3),
(10,30),(10,31);

-- Fortsæt mønster for alle billetter
-- Hvert ticketID skal have seatID for alle købte billetter
