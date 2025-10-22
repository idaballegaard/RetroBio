<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Showing.php";

class ShowingRepository extends BaseRepository {

    // @return Showing[]
    public function getShowingsThisWeek() : array {
        $pdo = $this->connectDatabase();
        $stmt = $pdo->query("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number,
                                    cm.firstName, cm.lastName,
                                    m.title, m.description, m.length, m.language, m.directorID, m.genre, m.ageLimit, m.ranking, m.releaseYear 
                            FROM Showing s
                            LEFT JOIN Movie m ON s.movieID = m.movieID
                            LEFT JOIN CastMember cm ON m.directorID = cm.castMemberID
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            WHERE s.date >= CURDATE() AND s.date < DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                            ORDER BY s.date, s.startTime ASC
        ");
        $stmt->execute();
        echo $stmt->rowCount() . " showings found.\n";

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

            $showing->getMovie()->setGenre($row['genre']);
            $showing->getMovie()->setAgeLimit($row['ageLimit']);
            $showing->getMovie()->setRanking($row['ranking']);
            $showing->getMovie()->setReleaseYear($row['releaseYear']);
            $showings[] = $showing;
        }
        return $showings;
    }

}