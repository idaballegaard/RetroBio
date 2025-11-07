<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/GenreRepository.php";
require_once __DIR__ . "/../models/Showing.php";

class ShowingRepository extends BaseRepository {

    // @return Showing[]
    public function getShowingsThisWeek() : array {
        $genreReository = new GenreRepository();

        $pdo = $this->connectDatabase();
        $stmt = $pdo->query("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number,
                                    cm.firstName, cm.lastName,
                                    m.title, m.description, m.length, m.language, m.directorID, m.ageLimit, m.ranking, m.releaseYear 
                            FROM Showing s
                            LEFT JOIN Movie m ON s.movieID = m.movieID
                            LEFT JOIN CastMember cm ON m.directorID = cm.castMemberID
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            WHERE s.date >= CURDATE() AND s.date < DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                            ORDER BY s.date, s.startTime ASC
        ");
        $stmt->execute();

        $showings = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            /** @var Showing */
            $previous = end($showings);
            if($previous && $previous->getMovie()->getMovieID() === $row['movieID']) {
                $previous->addReelTime($row['startTime']);
                continue;
            }

            $showing = new Showing();
            $showing->setShowingID($row['showingID']);
            $showing->setType($row['type']);
            $showing->addReelTime($row['startTime']);
            $showing->setDate(new DateTime($row['date']));
            $showing->setPrice($row['price']);

            $showing->getHall()->setHallID($row['hallID']);
            $showing->getHall()->setName($row['name']);
            $showing->getHall()->setNumber($row['number']);

            $showing->getMovie()->setMovieID($row['movieID']);
            $showing->getMovie()->setTitle($row['title']);
            $showing->getMovie()->setDescription($row['description']);
            $showing->getMovie()->setLength($row['length']);
            $showing->getMovie()->setLanguage($row['language']);

            $showing->getMovie()->getDirector()->setCastMemberID($row['directorID']);
            $showing->getMovie()->getDirector()->setFirstName($row['firstName']);
            $showing->getMovie()->getDirector()->setLastName($row['lastName']);

            $showing->getMovie()->setGenres($genreReository->getGenresByMovieId($row['movieID']));
            $showing->getMovie()->setAgeLimit($row['ageLimit']);
            $showing->getMovie()->setRanking($row['ranking']);
            $showing->getMovie()->setReleaseYear($row['releaseYear']);
            $showings[] = $showing;
        }
        return $showings;
    }

    public function getAllShowings() {
        UserRepository::dieIfNotAdmin();
        
        $showings = [];
        $pdo = $this->connectDatabase();
        $stmt = $pdo->query("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number,
                                    cm.firstName, cm.lastName,
                                    m.title, m.description, m.length, m.language, m.directorID, m.ageLimit, m.ranking, m.releaseYear 
                            FROM Showing s
                            LEFT JOIN Movie m ON s.movieID = m.movieID
                            LEFT JOIN CastMember cm ON m.directorID = cm.castMemberID
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            ORDER BY s.date, s.startTime ASC
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $genreReository = new GenreRepository();
        foreach($rows as $row) {
            /** @var Showing */
            $previous = end($showings);
            if($previous && $previous->getMovie()->getMovieID() === $row['movieID']) {
                $previous->addReelTime($row['startTime']);
                continue;
            }

            $showing = new Showing();
            $showing->setShowingID($row['showingID']);
            $showing->setType($row['type']);
            $showing->addReelTime($row['startTime']);
            $showing->setDate(new DateTime($row['date']));
            $showing->setPrice($row['price']);

            $showing->getHall()->setHallID($row['hallID']);
            $showing->getHall()->setName($row['name']);
            $showing->getHall()->setNumber($row['number']);

            $showing->getMovie()->setMovieID($row['movieID']);
            $showing->getMovie()->setTitle($row['title']);
            $showing->getMovie()->setDescription($row['description']);
            $showing->getMovie()->setLength($row['length']);
            $showing->getMovie()->setLanguage($row['language']);

            $showing->getMovie()->getDirector()->setCastMemberID($row['directorID']);
            $showing->getMovie()->getDirector()->setFirstName($row['firstName']);
            $showing->getMovie()->getDirector()->setLastName($row['lastName']);

            $showing->getMovie()->setGenres($genreReository->getGenresByMovieId($row['movieID']));
            $showing->getMovie()->setAgeLimit($row['ageLimit']);
            $showing->getMovie()->setRanking($row['ranking']);
            $showing->getMovie()->setReleaseYear($row['releaseYear']);
            $showings[] = $showing;
        }
        return $showings;
    }

    public function saveShowing(Showing $showing): void {
        UserRepository::dieIfNotAdmin();

        $pdo = $this->connectDatabase();
        if($showing->getShowingID() > 0) {
            $stmt = $pdo->prepare("UPDATE Showing SET movieID = :movieID, date = :date, startTime = :startTime, type = :type, price = :price, hallID = :hallID WHERE showingID = :showingID");
            $stmt->bindValue(":showingID", $showing->getShowingID(), PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Showing (movieID, date, startTime, type, price, hallID) VALUES (:movieID, :date, :startTime, :type, :price, :hallID)");
        }
        $stmt->bindValue(":movieID", $showing->getMovie()->getMovieID(), PDO::PARAM_INT);
        $stmt->bindValue(":date", $showing->getDate()->format("Y-m-d"), PDO::PARAM_STR);
        $stmt->bindValue(":startTime", "00:00", PDO::PARAM_STR);
        $stmt->bindValue(":type", $showing->getType(), PDO::PARAM_STR);
        $stmt->bindValue(":price", $showing->getPrice(), PDO::PARAM_STR);
        $stmt->bindValue(":hallID", $showing->getHall()->getHallID(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteShowing(int $showingID): void {
        UserRepository::dieIfNotAdmin();

        $pdo = $this->connectDatabase();
        $stmt = $pdo->prepare("DELETE FROM Showing WHERE showingID = :showingID");
        $stmt->bindValue(":showingID", $showingID, PDO::PARAM_INT);
        $stmt->execute();
    }
}