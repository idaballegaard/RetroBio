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
    `name` varchar (255) NOT NULL
);

CREATE TABLE Movie (
    movieID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar (255) NOT NULL,
    `description` varchar (1000) NOT NULL,
    releaseYear int NOT NULL,
    `length` int NOT NULL,
    `language` varchar (100) NOT NULL,
    ageLimit int NOT NULL,
    ranking decimal(3,2) NULL,
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
    FOREIGN KEY (movieID) REFERENCES Movie(movieID) ON DELETE CASCADE,
    FOREIGN KEY (castMemberID) REFERENCES CastMember(castMemberID) ON DELETE CASCADE
);

CREATE TABLE Showing (
    showingID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date` date NOT NULL,
    startTime time NOT NULL,
    `type` varchar (100) NULL,
    price decimal(5,2) NOT NULL,
    movieID int NOT NULL,
    hallID int NOT NULL,
    FOREIGN KEY (movieID) REFERENCES Movie(movieID) ON DELETE CASCADE
);
CREATE INDEX idx_showing_date ON Showing (`date`);

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
    price decimal(6,2) NOT NULL,
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
    username varchar (100) NOT NULL,
    hashedPassword varchar (60) NOT NULL,
    email varchar (255) NOT NULL,
    phone varchar (20) NOT NULL,
    country varchar (100) NOT NULL,
    street varchar (255) NOT NULL,
    streetNumber varchar (20) NOT NULL,
    postalCodeID int NOT NULL,
    isAdmin BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (postalCodeID) REFERENCES PostalCode(postalCodeID)
);

ALTER TABLE `Order`
ADD FOREIGN KEY (userID) REFERENCES User(userID);

CREATE TABLE OrderSeat (
    orderID int NOT NULL,
    seatID int NOT NULL,
    CONSTRAINT PK_OrderSeat PRIMARY KEY (orderID, seatID),
    FOREIGN KEY (orderID) REFERENCES `Order`(orderID) ON DELETE CASCADE,
    FOREIGN KEY (seatID) REFERENCES Seat(seatID)
);

CREATE TABLE News (
    newsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar (100) NOT NULL,
    `description` varchar (1000) NOT NULL,
    releaseDate DATE NOT NULL
);
CREATE INDEX idx_releaseDate ON News (releaseDate DESC);

CREATE TABLE About (
    `key` VARCHAR(30) NOT NULL PRIMARY KEY,
    `value` VARCHAR(1500) NOT NULL
);

-- REALISTIC TEST DATA

-- COMPANIES
INSERT INTO Company(companyID, `name`) VALUES
(3, 'Miramax Films'),
(4, 'Fox 2000 Pictures'),
(5, 'Working Title Films'),
(6, 'Amblin Entertainment'),
(7, 'Hawk Films'),
(8, 'Michael White Productions'),
(9, 'American Film Institute (AFI)'),
(10, 'Edge City Productions'),
(11, 'Shamley Productions');


-- GENRES
INSERT INTO Genre (genreID, `name`) VALUES
(1, 'Adventure'),
(2, 'Comedy'),
(3, 'Crime'),
(4, 'Drama'),
(5, 'Horror'),
(6, 'Musical'),
(7, 'Sci-Fi'),
(8, 'Family'),
(9, 'Cartoon');


-- CASTMEMBER
INSERT INTO CastMember (castMemberID, `name`) VALUES
(2, 'John Travolta'),
(3, 'Samuel L. Jackson'),
(4, 'Uma Thurman'),
(5, 'Bruce Willis'),
(6, 'David Fincher'),
(7, 'Edward Norton'),
(8, 'Brad Pitt'),
(9, 'Helena Bonham Carter'),
(10, 'Meat Loaf'),
(11, 'Joel Coen'),
(12, 'Jeff Bridges'),
(13, 'John Goodman'),
(14, 'Julianne Moore'),
(15, 'Steve Buscemi'),
(16, 'Richard Kelly'),
(18, 'Jena Malone'),
(19, 'Drew Barrymore'),
(21, 'Stanley Kubrick'),
(22, 'Malcolm McDowell'),
(23, 'Patrick Magee'),
(24, 'Adrienne Corri'),
(25, 'Michael Bates'),
(26, 'Jim Sharman'),
(27, 'Tim Curry'),
(28, 'Susan Sarandon'),
(29, 'Barry Bostwick'),
(31, 'David Lynch'),
(32, 'Jack Nance'),
(33, 'Charlotte Stewart'),
(34, 'Allen Joseph'),
(35, 'Alex Cox'),
(36, 'Emilio Estevez'),
(37, 'Harry Dean Stanton'),
(38, 'Tracey Walter'),
(39, 'Olivia Barash'),
(40, 'Bruce Robinson'),
(41, 'Richard E. Grant'),
(42, 'Paul McGann'),
(43, 'Richard Griffiths'),
(44, 'Rob Reiner'),
(45, 'Christopher Guest'),
(46, 'Michael McKean'),
(47, 'Harry Shearer'),
(140, 'Richard Donner'),
(141, 'Alfred Hitchcock'),
(142, 'Robert Zemeckis'),
(143, 'Sean Astin'),
(144, 'Josh Brolin'),
(145, 'Jeff Cohen'),
(146, 'Kerri Green'),
(147, 'Martha Plimpton'),
(148, 'Ke Huy Quan'),
(150, 'Richard O´Brien'),
(151, 'Anthony Perkins'),
(152, 'Janet Leigh'),
(153, 'Vera Miles'),
(154, 'John Gavin'),
(155, 'Michael Fox'),
(156, 'Christopher L1oyd'),
(157, 'Lea Thompson'),
(158, 'Crispin Glover'),
(284, 'Quentin Tarantino'),
(285, 'Samuel Jackson');


-- MOVIES
INSERT INTO Movie (`movieID`, title, `description`, releaseYear, `length`, `language`, ageLimit, ranking, directorID, companyID) VALUES
(1, 'Pulp Fiction', 'A bold and stylish crime tale where several stories of hitmen, gangsters, and ordinary people collide in surprising ways. Sharp dialogue, dark humor, and unforgettable characters drive the film forward. Every scene carries tension, coolness, and sudden twists that keep you watching.', 1995, 155, 'English', 15, 4.45, 284, 3),
(2, 'Fight Club', 'An exhausted office worker meets the mysterious and rebellious Tyler Durden, and together they form an underground fight club. What begins as escape from routine soon grows into a dangerous movement. A gripping film about identity, freedom, and how far we’ll go to feel alive.', 1999, 139, 'English', 15, 4.4, 6, 4),
(3, 'The Big Lebowski', '“The Dude” just wants a quiet life of bowling and relaxation, but a case of mistaken identity pulls him into a bizarre kidnapping plot. Surrounded by eccentric characters and absurd misunderstandings, he tries to hold onto his calm. A hilariously offbeat cult favorite with endless charm.', 1998, 117, 'English', 15, 4.05, 11, 5),
(4, 'The Goonies', 'When a group of friends finds a legendary pirate map, they set off on a daring treasure hunt to save their homes. The journey leads them through underground tunnels, traps, excitement, and unforgettable friendships. A beloved adventure full of heart and imagination.', 1985, 114, 'English', 10, 4, 140, 6),
(5, 'A Clockwork Orange', 'In a dystopian future, the violent young Alex is arrested and subjected to a radical psychological reform program. The film examines freedom and morality in a society determined to control behavior. Visually striking, controversial, and unforgettable.', 1971, 136, 'English', 15, 4.15, 21, 7),
(6, 'The Rocky Horror Picture Show', 'A young couple seeks help after their car breaks down and unknowingly steps into a mansion of outrageous and theatrical inhabitants. Soon, music, dancing, and chaos take over in spectacular fashion. A wild, joyful, audience-participation cult celebration.', 1975, 100, 'English', 12, 3.7, 26, 8),
(7, 'Eraserhead', 'A man living in an eerie industrial world struggles with fear, parenthood, and surreal visions. The line between dream and reality dissolves as strange sounds and haunting images fill the screen. A hypnotic and unsettling cinematic experience that lingers long after.', 1977, 89, 'English', 15, 3.7, 31, 9),
(8, 'Repo Man', 'A young punk becomes a repo agent and is drawn into the chase for a mysterious car rumored to contain something dangerous—possibly otherworldly. Along the way, government agents, conspiracies, and subculture collide. A quirky, punk-powered sci-fi cult classic.', 1984, 92, 'English', 12, 3.45, 35, 10),
(9, 'Psycho', 'A woman on the run checks into a quiet motel run by the shy Norman Bates, whose secretive life hides a deeply disturbing truth. Suspense builds slowly and precisely, leading to a legendary twist. A groundbreaking thriller that changed horror forever.', 1960, 109, 'English', 15, 3.85, 141, 11),
(10, 'Back to the Future', 'Teenager Marty McFly is accidentally sent back to the 1950s, where he disrupts his parents’ first meeting. Now he must fix the past to secure his own future — with the help of the eccentric Doc Brown. A funny, adventurous, and warm time-travel favorite.', 1985, 116, 'English', 10, 3.95, 142, 6);


-- MOVIE GENRES
INSERT INTO MovieGenre (movieID, genreID) VALUES
(1, 3),
(2, 4),
(3, 4),
(4, 1),
(5, 3),
(6, 6),
(7, 5),
(8, 7),
(9, 5),
(10, 7);


-- MOVIE ACTORS
INSERT INTO MovieActor (movieID, castMemberID) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(4, 143),
(4, 144),
(4, 145),
(4, 146),
(4, 147),
(4, 148),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(6, 10),
(6, 27),
(6, 28),
(6, 29),
(7, 32),
(7, 33),
(7, 34),
(8, 36),
(8, 37),
(8, 38),
(8, 39),
(9, 41),
(9, 42),
(9, 43),
(9, 151),
(10, 44),
(10, 45),
(10, 46),
(10, 47);

-- HALL
INSERT INTO Hall (hallID, `name`, `number`) VALUES
(1, 'Main Hall', 1),
(2, 'Classic Lounge', 2),
(3, 'Cult Cellar', 3);

-- SHOWINGS
INSERT INTO Showing (`date`, startTime, `type`, price, movieID, hallID) VALUES
('2025-10-14', '10:00:00', 'Baby Bio', 60, 1, 3),
('2025-10-16', '10:00:00', 'Baby Bio', 60, 2, 1),
('2025-10-13', '18:00:00', 'Evening', 95, 1, 1),
('2025-10-10', '00:00:00', 'Matinee', 95, 1, 3),
('2025-10-14', '18:00:00', 'Evening', 95, 2, 2),
('2025-10-14', '21:00:00', 'Evening', 95, 1, 1),
('2025-10-15', '18:00:00', 'Evening', 95, 1, 1),
('2025-10-15', '21:00:00', 'Evening', 95, 2, 1),
('2025-10-16', '18:00:00', 'Evening', 95, 2, 3),
('2025-10-16', '21:00:00', 'Evening', 95, 1, 1),
('2025-10-17', '18:00:00', 'Evening', 95, 1, 3),
('2025-10-17', '21:00:00', 'Evening', 95, 2, 3),
('2025-10-18', '18:00:00', 'Evening', 95, 2, 3),
('2025-10-18', '21:00:00', 'Evening', 95, 1, 1),
('2025-10-19', '18:00:00', 'Evening', 95, 1, 3),
('2025-10-19', '21:00:00', 'Evening', 95, 2, 2),
('2025-10-18', '15:00:00', 'Matinee', 80, 1, 1),
('2025-10-19', '15:00:00', 'Matinee', 80, 2, 1),
('2025-10-21', '10:00:00', 'Baby Bio', 60, 3, 1),
('2025-10-23', '10:00:00', 'Baby Bio', 60, 4, 2),
('2025-10-20', '18:00:00', 'Evening', 95, 3, 3),
('2025-10-20', '21:00:00', 'Evening', 95, 4, 1),
('2025-10-21', '18:00:00', 'Evening', 95, 4, 2),
('2025-10-21', '21:00:00', 'Evening', 95, 3, 2),
('2025-10-22', '18:00:00', 'Evening', 95, 3, 3),
('2025-10-22', '21:00:00', 'Evening', 95, 4, 3),
('2025-10-23', '18:00:00', 'Evening', 95, 4, 1),
('2025-10-23', '21:00:00', 'Evening', 95, 3, 2),
('2025-10-24', '18:00:00', 'Evening', 95, 3, 3),
('2025-10-24', '21:00:00', 'Evening', 95, 4, 2),
('2025-10-25', '18:00:00', 'Evening', 95, 4, 3),
('2025-10-25', '21:00:00', 'Evening', 95, 3, 1),
('2025-10-26', '18:00:00', 'Evening', 95, 3, 3),
('2025-10-26', '21:00:00', 'Evening', 95, 4, 2),
('2025-10-25', '15:00:00', 'Matinee', 80, 3, 3),
('2025-10-26', '15:00:00', 'Matinee', 80, 4, 2),
('2025-10-28', '10:00:00', 'Baby Bio', 60, 5, 2),
('2025-10-30', '10:00:00', 'Baby Bio', 60, 6, 3),
('2025-10-27', '18:00:00', 'Evening', 95, 5, 3),
('2025-10-27', '21:00:00', 'Evening', 95, 6, 3),
('2025-10-28', '18:00:00', 'Evening', 95, 6, 1),
('2025-10-28', '21:00:00', 'Evening', 95, 5, 1),
('2025-10-29', '18:00:00', 'Evening', 95, 5, 2),
('2025-10-29', '21:00:00', 'Evening', 95, 6, 1),
('2025-10-30', '18:00:00', 'Evening', 95, 6, 2),
('2025-10-30', '21:00:00', 'Evening', 95, 5, 1),
('2025-10-31', '18:00:00', 'Evening', 95, 5, 1),
('2025-10-31', '21:00:00', 'Evening', 95, 6, 1),
('2025-11-01', '18:00:00', 'Evening', 95, 6, 3),
('2025-11-01', '21:00:00', 'Evening', 95, 5, 1),
('2025-11-02', '18:00:00', 'Evening', 95, 5, 1),
('2025-11-02', '21:00:00', 'Evening', 95, 6, 1),
('2025-11-01', '15:00:00', 'Matinee', 80, 5, 3),
('2025-11-02', '15:00:00', 'Matinee', 80, 6, 3),
('2025-11-04', '10:00:00', 'Baby Bio', 60, 7, 2),
('2025-11-06', '10:00:00', 'Baby Bio', 60, 8, 2),
('2025-11-03', '18:00:00', 'Evening', 95, 7, 2),
('2025-11-03', '21:00:00', 'Evening', 95, 8, 2),
('2025-11-04', '18:00:00', 'Evening', 95, 8, 1),
('2025-11-04', '21:00:00', 'Evening', 95, 7, 2),
('2025-11-05', '18:00:00', 'Evening', 95, 7, 2),
('2025-11-05', '21:00:00', 'Evening', 95, 8, 1),
('2025-11-06', '18:00:00', 'Evening', 95, 8, 1),
('2025-11-06', '21:00:00', 'Evening', 95, 7, 2),
('2025-11-07', '18:00:00', 'Evening', 95, 7, 1),
('2025-11-07', '21:00:00', 'Evening', 95, 8, 1),
('2025-11-08', '18:00:00', 'Evening', 95, 8, 2),
('2025-11-08', '21:00:00', 'Evening', 95, 7, 1),
('2025-11-09', '18:00:00', 'Evening', 95, 7, 2),
('2025-11-09', '21:00:00', 'Evening', 95, 8, 3),
('2025-11-08', '15:00:00', 'Matinee', 80, 7, 3),
('2025-11-09', '15:00:00', 'Matinee', 80, 8, 1),
('2025-11-11', '10:00:00', 'Baby Bio', 60, 9, 1),
('2025-11-13', '10:00:00', 'Baby Bio', 60, 10, 2),
('2025-11-10', '18:00:00', 'Evening', 95, 9, 1),
('2025-11-10', '21:00:00', 'Evening', 95, 10, 3),
('2025-11-11', '18:00:00', 'Evening', 95, 10, 3),
('2025-11-11', '21:00:00', 'Evening', 95, 9, 1),
('2025-11-12', '18:00:00', 'Evening', 95, 9, 3),
('2025-11-12', '21:00:00', 'Evening', 95, 10, 3),
('2025-11-13', '18:00:00', 'Evening', 95, 10, 1),
('2025-11-13', '21:00:00', 'Evening', 95, 9, 3),
('2025-11-14', '18:00:00', 'Evening', 95, 9, 3),
('2025-11-14', '21:00:00', 'Evening', 95, 10, 1),
('2025-11-15', '18:00:00', 'Evening', 95, 10, 1),
('2025-11-15', '21:00:00', 'Evening', 95, 9, 1),
('2025-11-16', '18:00:00', 'Evening', 95, 9, 2),
('2025-11-16', '21:00:00', 'Evening', 95, 10, 3),
('2025-11-15', '15:00:00', 'Matinee', 80, 9, 1),
('2025-11-16', '15:00:00', 'Matinee', 80, 10, 1),
('2025-11-18', '10:00:00', 'Baby Bio', 60, 1, 2),
('2025-11-20', '10:00:00', 'Baby Bio', 60, 2, 1),
('2025-11-17', '18:00:00', 'Evening', 95, 1, 2),
('2025-11-17', '21:00:00', 'Evening', 95, 2, 3),
('2025-11-18', '18:00:00', 'Evening', 95, 2, 2),
('2025-11-18', '21:00:00', 'Evening', 95, 1, 3),
('2025-11-19', '18:00:00', 'Evening', 95, 1, 2),
('2025-11-19', '21:00:00', 'Evening', 95, 2, 2),
('2025-11-20', '18:00:00', 'Evening', 95, 2, 3),
('2025-11-20', '21:00:00', 'Evening', 95, 1, 2),
('2025-11-21', '18:00:00', 'Evening', 95, 1, 2),
('2025-11-21', '21:00:00', 'Evening', 95, 2, 3),
('2025-11-22', '18:00:00', 'Evening', 95, 2, 1),
('2025-11-22', '21:00:00', 'Evening', 95, 1, 2),
('2025-11-23', '18:00:00', 'Evening', 95, 1, 3),
('2025-11-23', '21:00:00', 'Evening', 95, 2, 1),
('2025-11-22', '15:00:00', 'Matinee', 80, 1, 1),
('2025-11-23', '15:00:00', 'Matinee', 80, 2, 1),
('2025-11-25', '10:00:00', 'Baby Bio', 60, 3, 3),
('2025-11-27', '10:00:00', 'Baby Bio', 60, 4, 2),
('2025-11-24', '18:00:00', 'Evening', 95, 3, 1),
('2025-11-24', '21:00:00', 'Evening', 95, 4, 3),
('2025-11-25', '18:00:00', 'Evening', 95, 4, 3),
('2025-11-25', '21:00:00', 'Evening', 95, 3, 3),
('2025-11-26', '18:00:00', 'Evening', 95, 3, 2),
('2025-11-26', '21:00:00', 'Evening', 95, 4, 3),
('2025-11-27', '18:00:00', 'Evening', 95, 4, 1),
('2025-11-27', '21:00:00', 'Evening', 95, 3, 3),
('2025-11-28', '18:00:00', 'Evening', 95, 3, 2),
('2025-11-28', '21:00:00', 'Evening', 95, 4, 1),
('2025-11-29', '18:00:00', 'Evening', 95, 4, 1),
('2025-11-29', '21:00:00', 'Evening', 95, 3, 3),
('2025-11-30', '18:00:00', 'Evening', 95, 3, 1),
('2025-11-30', '21:00:00', 'Evening', 95, 4, 2),
('2025-11-29', '15:00:00', 'Matinee', 80, 3, 3),
('2025-11-30', '15:00:00', 'Matinee', 80, 4, 1),
('2025-12-02', '10:00:00', 'Baby Bio', 60, 5, 1),
('2025-12-04', '10:00:00', 'Baby Bio', 60, 6, 2),
('2025-12-01', '18:00:00', 'Evening', 95, 5, 2),
('2025-12-01', '21:00:00', 'Evening', 95, 6, 1),
('2025-12-02', '18:00:00', 'Evening', 95, 6, 2),
('2025-12-02', '21:00:00', 'Evening', 95, 5, 3),
('2025-12-03', '18:00:00', 'Evening', 95, 5, 3),
('2025-12-03', '21:00:00', 'Evening', 95, 6, 1),
('2025-12-04', '18:00:00', 'Evening', 95, 6, 3),
('2025-12-04', '21:00:00', 'Evening', 95, 5, 1),
('2025-12-05', '18:00:00', 'Evening', 95, 5, 3),
('2025-12-05', '21:00:00', 'Evening', 95, 6, 2),
('2025-12-06', '18:00:00', 'Evening', 95, 6, 1),
('2025-12-06', '21:00:00', 'Evening', 95, 5, 2),
('2025-12-07', '18:00:00', 'Evening', 95, 5, 3),
('2025-12-07', '21:00:00', 'Evening', 95, 6, 1),
('2025-12-06', '15:00:00', 'Matinee', 80, 5, 3),
('2025-12-07', '15:00:00', 'Matinee', 80, 6, 3),
('2025-12-09', '10:00:00', 'Baby Bio', 60, 7, 2),
('2025-12-11', '10:00:00', 'Baby Bio', 60, 8, 2),
('2025-12-08', '18:00:00', 'Evening', 95, 7, 2),
('2025-12-08', '21:00:00', 'Evening', 95, 8, 3),
('2025-12-09', '18:00:00', 'Evening', 95, 8, 1),
('2025-12-09', '21:00:00', 'Evening', 95, 7, 3),
('2025-12-10', '18:00:00', 'Evening', 95, 7, 2),
('2025-12-10', '21:00:00', 'Evening', 95, 8, 2),
('2025-12-11', '18:00:00', 'Evening', 95, 8, 1),
('2025-12-11', '21:00:00', 'Evening', 95, 7, 3),
('2025-12-12', '18:00:00', 'Evening', 95, 7, 2),
('2025-12-12', '21:00:00', 'Evening', 95, 8, 1),
('2025-12-13', '18:00:00', 'Evening', 95, 8, 3),
('2025-12-13', '21:00:00', 'Evening', 95, 7, 3),
('2025-12-14', '18:00:00', 'Evening', 95, 7, 1),
('2025-12-14', '21:00:00', 'Evening', 95, 8, 1),
('2025-12-13', '15:00:00', 'Matinee', 80, 7, 2),
('2025-12-14', '15:00:00', 'Matinee', 80, 8, 1),
('2025-12-16', '10:00:00', 'Baby Bio', 60, 9, 1),
('2025-12-18', '10:00:00', 'Baby Bio', 60, 10, 3),
('2025-12-15', '18:00:00', 'Evening', 95, 9, 3),
('2025-12-15', '21:00:00', 'Evening', 95, 10, 1),
('2025-12-16', '18:00:00', 'Evening', 95, 10, 1),
('2025-12-16', '21:00:00', 'Evening', 95, 9, 1),
('2025-12-17', '18:00:00', 'Evening', 95, 9, 3),
('2025-12-17', '21:00:00', 'Evening', 95, 10, 2),
('2025-12-18', '18:00:00', 'Evening', 95, 10, 2),
('2025-12-18', '21:00:00', 'Evening', 95, 9, 3),
('2025-12-19', '18:00:00', 'Evening', 95, 9, 2),
('2025-12-19', '21:00:00', 'Evening', 95, 10, 3),
('2025-12-20', '18:00:00', 'Evening', 95, 10, 3),
('2025-12-20', '21:00:00', 'Evening', 95, 9, 3),
('2025-12-21', '18:00:00', 'Evening', 95, 9, 3),
('2025-12-21', '21:00:00', 'Evening', 95, 10, 3),
('2025-12-20', '15:00:00', 'Matinee', 80, 9, 2),
('2025-12-21', '15:00:00', 'Matinee', 80, 10, 3),
('2025-12-23', '10:00:00', 'Baby Bio', 60, 1, 2),
('2025-12-25', '10:00:00', 'Baby Bio', 60, 2, 1),
('2025-12-22', '18:00:00', 'Evening', 95, 1, 3),
('2025-12-22', '21:00:00', 'Evening', 95, 2, 3),
('2025-12-23', '18:00:00', 'Evening', 95, 2, 2),
('2025-12-23', '21:00:00', 'Evening', 95, 1, 2),
('2025-12-24', '18:00:00', 'Evening', 95, 1, 2),
('2025-12-24', '21:00:00', 'Evening', 95, 2, 1),
('2025-12-25', '18:00:00', 'Evening', 95, 2, 1),
('2025-12-25', '21:00:00', 'Evening', 95, 1, 1),
('2025-12-26', '18:00:00', 'Evening', 95, 1, 2),
('2025-12-26', '21:00:00', 'Evening', 95, 2, 1),
('2025-12-27', '18:00:00', 'Evening', 95, 2, 2),
('2025-12-27', '21:00:00', 'Evening', 95, 1, 2),
('2025-12-28', '18:00:00', 'Evening', 95, 1, 3),
('2025-12-28', '21:00:00', 'Evening', 95, 2, 1),
('2025-12-27', '15:00:00', 'Matinee', 80, 1, 1),
('2025-12-28', '15:00:00', 'Matinee', 80, 2, 3),
('2025-12-30', '10:00:00', 'Baby Bio', 60, 3, 3),
('2026-01-01', '10:00:00', 'Baby Bio', 60, 4, 1),
('2025-12-29', '18:00:00', 'Evening', 95, 3, 2),
('2025-12-29', '21:00:00', 'Evening', 95, 4, 3),
('2025-12-30', '18:00:00', 'Evening', 95, 4, 3),
('2025-12-30', '21:00:00', 'Evening', 95, 3, 2),
('2025-12-31', '18:00:00', 'Evening', 95, 3, 3),
('2025-12-31', '21:00:00', 'Evening', 95, 4, 3),
('2026-01-01', '18:00:00', 'Evening', 95, 4, 2),
('2026-01-01', '21:00:00', 'Evening', 95, 3, 3),
('2026-01-02', '18:00:00', 'Evening', 95, 3, 2),
('2026-01-02', '21:00:00', 'Evening', 95, 4, 3),
('2026-01-03', '18:00:00', 'Evening', 95, 4, 1),
('2026-01-03', '21:00:00', 'Evening', 95, 3, 1),
('2026-01-04', '18:00:00', 'Evening', 95, 3, 1),
('2026-01-04', '21:00:00', 'Evening', 95, 4, 2),
('2026-01-03', '15:00:00', 'Matinee', 80, 3, 3),
('2026-01-04', '15:00:00', 'Matinee', 80, 4, 1),
('2026-01-06', '10:00:00', 'Baby Bio', 60, 5, 1),
('2026-01-08', '10:00:00', 'Baby Bio', 60, 6, 2),
('2026-01-05', '18:00:00', 'Evening', 95, 5, 3),
('2026-01-05', '21:00:00', 'Evening', 95, 6, 2),
('2026-01-06', '18:00:00', 'Evening', 95, 6, 2),
('2026-01-06', '21:00:00', 'Evening', 95, 5, 2),
('2026-01-07', '18:00:00', 'Evening', 95, 5, 2),
('2026-01-07', '21:00:00', 'Evening', 95, 6, 1),
('2026-01-08', '18:00:00', 'Evening', 95, 6, 2),
('2026-01-08', '21:00:00', 'Evening', 95, 5, 2),
('2026-01-09', '18:00:00', 'Evening', 95, 5, 3),
('2026-01-09', '21:00:00', 'Evening', 95, 6, 3),
('2026-01-10', '18:00:00', 'Evening', 95, 6, 2),
('2026-01-10', '21:00:00', 'Evening', 95, 5, 1),
('2026-01-11', '18:00:00', 'Evening', 95, 5, 3),
('2026-01-11', '21:00:00', 'Evening', 95, 6, 1),
('2026-01-10', '15:00:00', 'Matinee', 80, 5, 1),
('2026-01-11', '15:00:00', 'Matinee', 80, 6, 2),
('2026-01-13', '10:00:00', 'Baby Bio', 60, 7, 1),
('2026-01-15', '10:00:00', 'Baby Bio', 60, 8, 1),
('2026-01-12', '18:00:00', 'Evening', 95, 7, 1),
('2026-01-12', '21:00:00', 'Evening', 95, 8, 3),
('2026-01-13', '18:00:00', 'Evening', 95, 8, 2),
('2026-01-13', '21:00:00', 'Evening', 95, 7, 1),
('2026-01-14', '18:00:00', 'Evening', 95, 7, 3),
('2026-01-14', '21:00:00', 'Evening', 95, 8, 1),
('2026-01-15', '18:00:00', 'Evening', 95, 8, 2),
('2026-01-15', '21:00:00', 'Evening', 95, 7, 1),
('2026-01-16', '18:00:00', 'Evening', 95, 7, 2),
('2026-01-16', '21:00:00', 'Evening', 95, 8, 3),
('2026-01-17', '18:00:00', 'Evening', 95, 8, 3),
('2026-01-17', '21:00:00', 'Evening', 95, 7, 2),
('2026-01-18', '18:00:00', 'Evening', 95, 7, 3),
('2026-01-18', '21:00:00', 'Evening', 95, 8, 2),
('2026-01-17', '15:00:00', 'Matinee', 80, 7, 2),
('2026-01-18', '15:00:00', 'Matinee', 80, 8, 3),
('2026-01-20', '10:00:00', 'Baby Bio', 60, 9, 3),
('2026-01-22', '10:00:00', 'Baby Bio', 60, 10, 1),
('2026-01-19', '18:00:00', 'Evening', 95, 9, 2),
('2026-01-19', '21:00:00', 'Evening', 95, 10, 3),
('2026-01-20', '18:00:00', 'Evening', 95, 10, 3),
('2026-01-20', '21:00:00', 'Evening', 95, 9, 2),
('2026-01-21', '18:00:00', 'Evening', 95, 9, 3),
('2026-01-21', '21:00:00', 'Evening', 95, 10, 2),
('2026-01-22', '18:00:00', 'Evening', 95, 10, 3),
('2026-01-22', '21:00:00', 'Evening', 95, 9, 1),
('2026-01-23', '18:00:00', 'Evening', 95, 9, 1),
('2026-01-23', '21:00:00', 'Evening', 95, 10, 2),
('2026-01-24', '18:00:00', 'Evening', 95, 10, 3),
('2026-01-24', '21:00:00', 'Evening', 95, 9, 1),
('2026-01-25', '18:00:00', 'Evening', 95, 9, 2),
('2026-01-25', '21:00:00', 'Evening', 95, 10, 3),
('2026-01-24', '15:00:00', 'Matinee', 80, 9, 2),
('2026-01-25', '15:00:00', 'Matinee', 80, 10, 3),
('2026-01-27', '10:00:00', 'Baby Bio', 60, 1, 1),
('2026-01-29', '10:00:00', 'Baby Bio', 60, 2, 2),
('2026-01-26', '18:00:00', 'Evening', 95, 1, 3),
('2026-01-26', '21:00:00', 'Evening', 95, 2, 3),
('2026-01-27', '18:00:00', 'Evening', 95, 2, 1),
('2026-01-27', '21:00:00', 'Evening', 95, 1, 1),
('2026-01-28', '18:00:00', 'Evening', 95, 1, 3),
('2026-01-28', '21:00:00', 'Evening', 95, 2, 2),
('2026-01-29', '18:00:00', 'Evening', 95, 2, 2),
('2026-01-29', '21:00:00', 'Evening', 95, 1, 2),
('2026-01-30', '18:00:00', 'Evening', 95, 1, 2),
('2026-01-30', '21:00:00', 'Evening', 95, 2, 3),
('2026-01-31', '18:00:00', 'Evening', 95, 2, 2),
('2026-01-31', '21:00:00', 'Evening', 95, 1, 1),
('2026-01-31', '15:00:00', 'Matinee', 80, 1, 3),
('2025-10-13', '00:00:00', 'Evening', 950, 1, 1);


-- SEATS
INSERT INTO Seat (`number`, rowNumber, hallID) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(2, 1, 1),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1),
(2, 8, 1),
(2, 9, 1),
(2, 10, 1),
(3, 1, 1),
(3, 2, 1),
(3, 3, 1),
(3, 4, 1),
(3, 5, 1),
(3, 6, 1),
(3, 7, 1),
(3, 8, 1),
(3, 9, 1),
(3, 10, 1),
(4, 1, 1),
(4, 2, 1),
(4, 3, 1),
(4, 4, 1),
(4, 5, 1),
(4, 6, 1),
(4, 7, 1),
(4, 8, 1),
(4, 9, 1),
(4, 10, 1),
(5, 1, 1),
(5, 2, 1),
(5, 3, 1),
(5, 4, 1),
(5, 5, 1),
(5, 6, 1),
(5, 7, 1),
(5, 8, 1),
(5, 9, 1),
(5, 10, 1),
(6, 1, 1),
(6, 2, 1),
(6, 3, 1),
(6, 4, 1),
(6, 5, 1),
(6, 6, 1),
(6, 7, 1),
(6, 8, 1),
(6, 9, 1),
(6, 10, 1),
(7, 1, 1),
(7, 2, 1),
(7, 3, 1),
(7, 4, 1),
(7, 5, 1),
(7, 6, 1),
(7, 7, 1),
(7, 8, 1),
(7, 9, 1),
(7, 10, 1),
(8, 1, 1),
(8, 2, 1),
(8, 3, 1),
(8, 4, 1),
(8, 5, 1),
(8, 6, 1),
(8, 7, 1),
(8, 8, 1),
(8, 9, 1),
(8, 10, 1),
(9, 1, 1),
(9, 2, 1),
(9, 3, 1),
(9, 4, 1),
(9, 5, 1),
(9, 6, 1),
(9, 7, 1),
(9, 8, 1),
(9, 9, 1),
(9, 10, 1),
(10, 1, 1),
(10, 2, 1),
(10, 3, 1),
(10, 4, 1),
(10, 5, 1),
(10, 6, 1),
(10, 7, 1),
(10, 8, 1),
(10, 9, 1),
(10, 10, 1),
(1, 1, 2),
(1, 2, 2),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2),
(1, 6, 2),
(1, 7, 2),
(1, 8, 2),
(2, 1, 2),
(2, 2, 2),
(2, 3, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(2, 7, 2),
(2, 8, 2),
(3, 1, 2),
(3, 2, 2),
(3, 3, 2),
(3, 4, 2),
(3, 5, 2),
(3, 6, 2),
(3, 7, 2),
(3, 8, 2),
(4, 1, 2),
(4, 2, 2),
(4, 3, 2),
(4, 4, 2),
(4, 5, 2),
(4, 6, 2),
(4, 7, 2),
(4, 8, 2),
(5, 1, 2),
(5, 2, 2),
(5, 3, 2),
(5, 4, 2),
(5, 5, 2),
(5, 6, 2),
(5, 7, 2),
(5, 8, 2),
(6, 1, 2),
(6, 2, 2),
(6, 3, 2),
(6, 4, 2),
(6, 5, 2),
(6, 6, 2),
(6, 7, 2),
(6, 8, 2),
(7, 1, 2),
(7, 2, 2),
(7, 3, 2),
(7, 4, 2),
(7, 5, 2),
(7, 6, 2),
(7, 7, 2),
(7, 8, 2),
(8, 1, 2),
(8, 2, 2),
(8, 3, 2),
(8, 4, 2),
(8, 5, 2),
(8, 6, 2),
(8, 7, 2),
(8, 8, 2),
(1, 1, 3),
(1, 2, 3),
(1, 3, 3),
(1, 4, 3),
(1, 5, 3),
(1, 6, 3),
(2, 1, 3),
(2, 2, 3),
(2, 3, 3),
(2, 4, 3),
(2, 5, 3),
(2, 6, 3),
(3, 1, 3),
(3, 2, 3),
(3, 3, 3),
(3, 4, 3),
(3, 5, 3),
(3, 6, 3),
(4, 1, 3),
(4, 2, 3),
(4, 3, 3),
(4, 4, 3),
(4, 5, 3),
(4, 6, 3),
(5, 1, 3),
(5, 2, 3),
(5, 3, 3),
(5, 4, 3),
(5, 5, 3),
(5, 6, 3),
(6, 1, 3),
(6, 2, 3),
(6, 3, 3),
(6, 4, 3),
(6, 5, 3),
(6, 6, 3);

-- POSTAL CODES
INSERT INTO PostalCode (postalCodeID, postalCode, city) VALUES
(1, '6700', 'Esbjerg'),
(2, '6705', 'Esbjerg Ø'),
(3, '6710', 'Esbjerg V'),
(4, '6715', 'Esbjerg N'),
(5, '6800', 'Varde');

-- USERS
INSERT INTO `User` (userID, firstName, lastName, username, hashedPassword, email, phone, country, street, streetNumber, postalCodeID, isAdmin) VALUES
(1, 'admin', 'admin', 'admin', '$2y$12$OC81y33pfN8ytPF7EQYuJesoLTRBRDOAVyi2NNzeb8y4ATNJJv92.', 'kontakt@easv.dk', '12345678', 'Denmark', 'Spangsbjerg Kirkevej', '103', 1, 1);

-- ORDERS
INSERT INTO `Order` (orderID, price, `date`, `status`, numberOfTickets, userID, showingID) VALUES
(1, 120.00, '2025-12-16', 'completed', 2, 1, 1),
(2, 285.00, '2025-12-16', 'completed', 3, 1, 3);

-- ORDER SEATS
INSERT INTO `OrderSeat` (orderId, seatId) VALUES
(1, (SELECT seatId FROM Seat WHERE hallID = 3 ORDER BY rowNumber, `number` LIMIT 1 OFFSET 0)),
(1, (SELECT seatId FROM Seat WHERE hallID = 3 ORDER BY rowNumber, `number` LIMIT 1 OFFSET 1)),
(2, (SELECT seatId FROM Seat WHERE hallID = 1 ORDER BY rowNumber, `number` LIMIT 1 OFFSET 0)),
(2, (SELECT seatId FROM Seat WHERE hallID = 1 ORDER BY rowNumber, `number` LIMIT 1 OFFSET 1)),
(2, (SELECT seatId FROM Seat WHERE hallID = 1 ORDER BY rowNumber, `number` LIMIT 1 OFFSET 2));

-- NEWS
INSERT INTO News (newsID, title, `description`, releaseDate) VALUES
(1, 'Classic Horror Night', 'October 31st is all about chills and thrills! We’ll be showing classics like Psycho and The Shining in a dark and spooky (or unspooky?) atmosphere. Come in costume and enter the competition for this year’s Horror Award – only for the bravest!', '2025-10-21'),
(2, 'Retro Sci-Fi Week', 'In week 47, we’re celebrating the sci-fi genre with classics like Blade Runner and Back to the Future. Enjoy retro trailer screenings, quizzes, and themed decorations in the lobby. A week full of nostalgia, space adventures, and neon vibes!', '2025-11-07'),
(3, 'New Posters Decorate the Cinema Walls', 'The cinema has gotten a fresh look with new movie posters on the walls! Check out both classics like Casablanca and upcoming hits like Galactic Frontier. Stop by the lobby, share your favorite poster on social media, and enter the raffle to win free tickets!', '2025-11-19'),
(4, 'Big Movie Quiz at the Cinema', 'On Friday, December 12th, we invite you to a movie quiz in the café area! Compete in everything from Oscar winners to Danish classics. Form a team, test your film knowledge, and win free tickets, popcorn, and exclusive posters. Sign up on our website.', '2025-12-01'),
(5, 'Cult Film Marathon', 'On December 27th, we’re screening five iconic cult films – from The Rocky Horror Picture Show to Pulp Fiction. Expect costumes, quotes, and laughter all night long. Come in costume and get a free soda – experience cult classics the way they’re meant to be seen!', '2025-12-17');


-- ABOUT
INSERT INTO About (`key`, `value`) VALUES
('address', 'RetroBio Cinema, Retro Street 42, 8000 Aarhus'),
('description', 'At RetroBio, we invite you to step into a world where film history is celebrated, cherished, and brought back to life. Our cinema blends vintage charm with modern comfort, creating a space where every screening feels like a special event. We’re passionate about honoring the art of cinema and sharing unforgettable moments with fellow movie lovers.\r\n\r\nOur mission is to rekindle the magic of classic theaters—where the glow of the projector, the anticipation before the opening scene, and the shared silence of the audience create something truly timeless. We curate a unique selection of films, from iconic masterpieces to hidden gems that deserve to be experienced on the big screen once more.\r\n\r\nRetroBio exists for one reason: love of film. Every detail in our theater is thoughtfully designed to evoke nostalgia and wonder. We hope that, when you take your seat, you’ll feel transported to an era when going to the movies wasn’t just entertainment—it was an experience.'),
('email', 'idaballegaard@msn.com'),
('openingHours', '09:00 - 23:00'),
('phone', '+45 42 21 68 03'),
('subtitle', 'Where Classics Shine Again'),
('title', 'RetroBio');

-- VIEWS
-- Movie details view
CREATE OR REPLACE VIEW moviedetail AS
SELECT 
    m.movieID, 
    m.title, 
    m.description, 
    m.releaseYear, 
    m.length, 
    m.language, 
    m.ageLimit, 
    m.ranking,
    m.directorID,
    d.name AS director,
    c.name AS company,
    GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
    GROUP_CONCAT(DISTINCT g.genreID ORDER BY g.name SEPARATOR ', ') AS genreIDs,
    GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors,
    GROUP_CONCAT(DISTINCT a.castMemberID ORDER BY a.name SEPARATOR ', ') AS actorIDs
FROM Movie m
JOIN CastMember d ON m.directorID = d.castMemberID
JOIN Company c ON m.companyID = c.companyID
LEFT JOIN MovieGenre mg ON m.movieID = mg.movieID
LEFT JOIN Genre g ON mg.genreID = g.genreID
LEFT JOIN MovieActor ma ON m.movieID = ma.movieID
LEFT JOIN CastMember a ON ma.castMemberID = a.castMemberID
GROUP BY 
    m.movieID, m.title, m.description, m.releaseYear, m.length, m.language, 
    m.ageLimit, m.ranking, d.name, c.name;


-- Showing details view
CREATE OR REPLACE VIEW ShowingDetails AS
SELECT s.*, h.name, h.number
FROM Showing s
         JOIN Hall h ON s.hallID = h.hallID
GROUP BY s.showingID, s.date, s.startTime, h.name, h.number, s.price;

-- Trigger to prevent deletion of completed orders within the last year
DROP TRIGGER IF EXISTS orders_before_delete;
DELIMITER //
CREATE TRIGGER orders_before_delete
    BEFORE DELETE ON `Order`
    FOR EACH ROW
BEGIN
    IF OLD.status = 'completed' AND OLD.`date` >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete completed orders within the last year.';
    END IF;
END//

DELIMITER ;

-- Trigger to delete pending orders older than 24 hours after new inserts in the order table
DROP TRIGGER IF EXISTS cleanup_pending_orders;
DELIMITER //
CREATE TRIGGER cleanup_pending_orders
    AFTER INSERT ON `OrderSeat`
    FOR EACH ROW
BEGIN
    DELETE FROM `Order`
        WHERE status = 'pending' AND `date` < DATE_SUB(NOW(), INTERVAL 24 HOUR);
END//


DELIMITER ;