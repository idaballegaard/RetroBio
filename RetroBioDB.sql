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
    FOREIGN KEY (castMemberID) REFERENCES CastMember(castMemberID)
);

CREATE TABLE Showing (
    showingID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date` date NOT NULL,
    startTime time NOT NULL,
    `type` varchar (100) NULL,
    price decimal(5,2) NOT NULL,
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
    FOREIGN KEY (orderID) REFERENCES `Order`(orderID),
    FOREIGN KEY (seatID) REFERENCES Seat(seatID)
);

CREATE TABLE News (
    newsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar (100) NOT NULL,
    `description` varchar (1000) NOT NULL,
    releaseDate DATE NOT NULL
);

CREATE TABLE About (
    `key` VARCHAR(30) NOT NULL PRIMARY KEY,
    `value` VARCHAR(1500) NOT NULL
);




-- REALISTIC TEST DATA
USE RetroBioDB;


-- COMPANIES
INSERT INTO Company (`name`) VALUES
('Miramax Films'),
('Fox 2000 Pictures'),
('Working Title Films'),
('Amblin Entertainment'),
('Hawk Films'),
('Michael White Productions'),
('American Film Institute (AFI)'),
('Edge City Productions'),
('Shamley Productions');


-- GENRES
INSERT INTO Genre (`name`) VALUES
('Adventure'),
('Comedy'),
('Crime'),
('Drama'),
('Horror'),
('Musical'),
('Sci-Fi'),
('Family'),
('Cartoon');


-- CASTMEMBER
INSERT INTO CastMember (`name`) VALUES
('John Travolta'),
('Samuel L. Jackson'),
('Uma Thurman'),
('Bruce Willis'),
('David Fincher'),
('Edward Norton'),
('Brad Pitt'),
('Helena Bonham Carter'),
('Meat Loaf'),
('Joel Coen'),
('Jeff Bridges'),
('John Goodman'),
('Julianne Moore'),
('Steve Buscemi'),
('Richard Kelly'),
('Jena Malone'),
('Drew Barrymore'),
('Stanley Kubrick'),
('Malcolm McDowell'),
('Patrick Magee'),
('Adrienne Corri'),
('Michael Bates'),
('Jim Sharman'),
('Tim Curry'),
('Susan Sarandon'),
('Barry Bostwick'),
('David Lynch'),
('Jack Nance'),
('Charlotte Stewart'),
('Allen Joseph'),
('Alex Cox'),
('Emilio Estevez'),
('Harry Dean Stanton'),
('Tracey Walter'),
('Olivia Barash'),
('Bruce Robinson'),
('Richard E. Grant'),
('Paul McGann'),
('Richard Griffiths'),
('Rob Reiner'),
('Christopher Guest'),
('Michael McKean'),
('Harry Shearer'),
('D. Duck'),
('S. McDuck'),
('Richard Donner'),
('Alfred Hitchcock'),
('Robert Zemeckis'),
('Sean Astin'),
('Josh Brolin'),
('Jeff Cohen'),
('Kerri Green'),
('Martha Plimpton'),
('Ke Huy Quan'),
('Richard O´Brien'),
('Anthony Perkins'),
('Janet Leigh'),
('Vera Miles'),
('John Gavin'),
('Michael Fox'),
('Christopher L1oyd'),
('Lea Thompson'),
('Crispin Glover'),
('Quentin Tarantino'),
('Samuel Jackson');


-- MOVIES
INSERT INTO Movie (title, `description`, releaseYear, `length`, `language`, ageLimit, ranking, directorID, companyID) VALUES
('Pulp Fiction', 'A bold and stylish crime tale where several stories of hitmen, gangsters, and ordinary people collide in surprising ways. Sharp dialogue, dark humor, and unforgettable characters drive the film forward. Every scene carries tension, coolness, and sudden twists that keep you watching.', 1995, 155, 'English', 15, 4.45, 284, 3),
('Fight Club', 'An exhausted office worker meets the mysterious and rebellious Tyler Durden, and together they form an underground fight club. What begins as escape from routine soon grows into a dangerous movement. A gripping film about identity, freedom, and how far we’ll go to feel alive.', 1999, 139, 'English', 15, 4.4, 6, 4),
('The Big Lebowski', '“The Dude” just wants a quiet life of bowling and relaxation, but a case of mistaken identity pulls him into a bizarre kidnapping plot. Surrounded by eccentric characters and absurd misunderstandings, he tries to hold onto his calm. A hilariously offbeat cult favorite with endless charm.', 1998, 117, 'English', 15, 4.05, 11, 5),
('The Goonies', 'When a group of friends finds a legendary pirate map, they set off on a daring treasure hunt to save their homes. The journey leads them through underground tunnels, traps, excitement, and unforgettable friendships. A beloved adventure full of heart and imagination.', 1985, 114, 'English', 10, 4, 140, 6),
('A Clockwork Orange123456', 'In a dystopian future, the violent young Alex is arrested and subjected to a radical psychological reform program. The film examines freedom and morality in a society determined to control behavior. Visually striking, controversial, and unforgettable.', 1971, 136, 'English', 15, 4.15, 21, 7),
('The Rocky Horror Picture Show', 'A young couple seeks help after their car breaks down and unknowingly steps into a mansion of outrageous and theatrical inhabitants. Soon, music, dancing, and chaos take over in spectacular fashion. A wild, joyful, audience-participation cult celebration.', 1975, 100, 'English', 12, 3.7, 26, 8),
('Eraserhead', 'A man living in an eerie industrial world struggles with fear, parenthood, and surreal visions. The line between dream and reality dissolves as strange sounds and haunting images fill the screen. A hypnotic and unsettling cinematic experience that lingers long after.', 1977, 89, 'English', 15, 3.7, 31, 9),
('Repo Man', 'A young punk becomes a repo agent and is drawn into the chase for a mysterious car rumored to contain something dangerous—possibly otherworldly. Along the way, government agents, conspiracies, and subculture collide. A quirky, punk-powered sci-fi cult classic.', 1984, 92, 'English', 12, 3.45, 35, 10),
('Psycho', 'A woman on the run checks into a quiet motel run by the shy Norman Bates, whose secretive life hides a deeply disturbing truth. Suspense builds slowly and precisely, leading to a legendary twist. A groundbreaking thriller that changed horror forever.', 1960, 109, 'English', 15, 3.85, 141, 11),
('Back to the Future', 'Teenager Marty McFly is accidentally sent back to the 1950s, where he disrupts his parents’ first meeting. Now he must fix the past to secure his own future — with the help of the eccentric Doc Brown. A funny, adventurous, and warm time-travel favorite.', 1985, 116, 'English', 10, 3.95, 142, 6);


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


-- HALL
INSERT INTO Hall (`name`, `number`) VALUES
('Main Hall', 1),
('Classic Lounge', 2),
('Cult Cellar', 3);


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


-- ORDERS

-- ORDER SEATS
INSERT INTO OrderSeat (orderID, seatID) VALUES
(10, 263),
(10, 269),
(10, 275),
(11, 277),
(11, 283),
(12, 24),
(12, 34),
(12, 44),
(12, 54),
(12, 64),
(12, 74),
(13, 256),
(13, 262),
(13, 268),
(13, 274),
(14, 37),
(14, 47),
(14, 57),
(14, 67),
(15, 264),
(15, 270),
(16, 147),
(16, 155);


-- POSTAL CODES

-- USERS


-- NEWS
INSERT INTO News (title, `description`, releaseDate) VALUES
('Classic Horror Night', 'October 31st is all about chills and thrills! We’ll be showing classics like Psycho and The Shining in a dark and spooky (or unspooky?) atmosphere. Come in costume and enter the competition for this year’s Horror Award – only for the bravest!', '2025-10-21'),
('Retro Sci-Fi Week', 'In week 47, we’re celebrating the sci-fi genre with classics like Blade Runner and Back to the Future. Enjoy retro trailer screenings, quizzes, and themed decorations in the lobby. A week full of nostalgia, space adventures, and neon vibes!', '2025-11-07'),
('New Posters Decorate the Cinema Walls', 'The cinema has gotten a fresh look with new movie posters on the walls! Check out both classics like Casablanca and upcoming hits like Galactic Frontier. Stop by the lobby, share your favorite poster on social media, and enter the raffle to win free tickets!', '2025-11-19'),
('Big Movie Quiz at the Cinema', 'On Friday, December 12th, we invite you to a movie quiz in the café area! Compete in everything from Oscar winners to Danish classics. Form a team, test your film knowledge, and win free tickets, popcorn, and exclusive posters. Sign up on our website.', '2025-12-01'),
('Cult Film Marathon', 'On December 27th, we’re screening five iconic cult films – from The Rocky Horror Picture Show to Pulp Fiction. Expect costumes, quotes, and laughter all night long. Come in costume and get a free soda – experience cult classics the way they’re meant to be seen!', '2025-12-17');


-- ABOUT
INSERT INTO About (`key`, `value`) VALUES
('address', 'RetroBio Cinema, Retro Street 42, 8000 Aarhus'),
('description', 'At RetroBio, we invite you to step into a world where film history is celebrated, cherished, and brought back to life. Our cinema blends vintage charm with modern comfort, creating a space where every screening feels like a special event. We’re passionate about honoring the art of cinema and sharing unforgettable moments with fellow movie lovers.\r\n\r\nOur mission is to rekindle the magic of classic theaters—where the glow of the projector, the anticipation before the opening scene, and the shared silence of the audience create something truly timeless. We curate a unique selection of films, from iconic masterpieces to hidden gems that deserve to be experienced on the big screen once more.\r\n\r\nRetroBio exists for one reason: love of film. Every detail in our theater is thoughtfully designed to evoke nostalgia and wonder. We hope that, when you take your seat, you’ll feel transported to an era when going to the movies wasn’t just entertainment—it was an experience.'),
('email', 'idaballegaard@msn.com'),
('openingHours', '09:00 - 23:00'),
('phone', '+45 42 21 68 03'),
('subtitle', 'Where Classics Shine Again'),
('title', 'RetroBio');



-- OLD
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

-- MOVIES OLD
INSERT INTO Movie (titel, `description`, `length`, `language`, director, genre, actors, ageLimit, ranking) VALUES
('Pulp Fiction','A bold and stylish crime tale where several stories of hitmen, gangsters, and ordinary people collide in surprising ways. Sharp dialogue, dark humor, and unforgettable characters drive the film forward. Every scene carries tension, coolness, and sudden twists that keep you watching.',154,'English','Quentin Tarantino','Crime','John Travolta, Uma Thurman, Samuel L. Jackson',18,8.9),
('Fight Club','En kontormedarbejder og en sæbefabrikant starter en undergrundsklub',139,'English','David Fincher','Drama','Brad Pitt, Edward Norton',18,8.8),
('The Big Lebowski','Jeff "The Dude" Lebowski involveres i en kidnapningssag',117,'English','Coen Brothers','Comedy','Jeff Bridges, John Goodman',15,8.1),
('The Goonies','En gruppe børn finder et skattekort og går på eventyr',114,'English','Richard Donner','Adventure','Sean Astin, Josh Brolin',12,7.8),
('A Clockwork Orange','In a dystopian future, the violent young Alex is arrested and subjected to a radical psychological reform program. The film examines freedom and morality in a society determined to control behavior. Visually striking, controversial, and unforgettable.',136,'English','Stanley Kubrick','Crime','',12,7.8),
('Back to the Future','Teenager Marty McFly is accidentally sent back to the 1950s, where he disrupts his parents’ first meeting. Now he must fix the past to secure his own future — with the help of the eccentric Doc Brown. A funny, adventurous, and warm time-travel favorite.',116,'English','Robert Zemeckis','Sci-Fi','Michael J. Fox, Christopher Lloyd',10,3.95,),
('Ghostbusters','Tre videnskabsmænd starter et spøgelsesfirma',105,'English','Ivan Reitman','Comedy','Bill Murray, Dan Aykroyd',12,7.8),
('Blade Runner','Blade runner skal terminere replicants der stjal et rumskib',117,'English','Ridley Scott','Sci-Fi','Harrison Ford',15,8.1),
('Inglourious Basterds','En gruppe jødiske soldater planlægger at myrde nazistiske ledere',153,'English','Quentin Tarantino','War','Brad Pitt, Christoph Waltz',18,8.3),
('The Shining','En mand bliver sindssyg mens han passer et isoleret hotel om vinteren',146,'English','Stanley Kubrick','Horror','Jack Nicholson',18,8.4),
('E.T. the Extra-Terrestrial','En dreng hjælper en rumvæsen med at komme hjem',115,'English','Steven Spielberg','Family','Henry Thomas, Drew Barrymore',7,7.9),
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

-- --- CONTAINS ---
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

-- Company
INSERT INTO Company (name) VALUES
('Miramax Films'),
('Fox 2000 Pictures'),
('Working Title Films'),
('Amblin Entertainment'),
('Hawk Films'),
('Michael White Productions'),
('American Film Institute (AFI)'),
('Edge City Productions'),
('Shamley Productions'),
('Amblin Entertainment');

-- VIEWS
-- Movie details view
CREATE OR REPLACE VIEW MovieDetail AS
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
SELECT s.showingID, m.title AS movieTitle, s.date AS showingDate, s.startTime AS showingTime,
       h.name AS hallName, h.number AS hallNumber, s.price AS showingPrice
FROM Showing s
JOIN Movie m ON s.movieID = m.movieID
JOIN Hall h ON s.hallID = h.hallID
GROUP BY s.showingID, m.title, s.date, s.startTime, h.name, h.number, s.price;