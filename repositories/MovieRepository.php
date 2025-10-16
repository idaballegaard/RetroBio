<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Movie.php";
require_once __DIR__ . "/../models/CastMember.php";

class MovieRepository extends BaseRepository {
    
    // @return Movie[]
    public function getAllMovies(): array {
        $movies = [];

        $db = $this->connectDatabase();
        if (!$db) {
            return $movies;
        }

        try {
            $stmt = $db->query("SELECT * FROM Movie m JOIN CastMember cm ON m.directorID = cm.castMemberID");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $movie = new Movie();
                $movie->setMovieID($row['movieID']);
                $movie->setTitle($row['titel']);
                $movie->setDescription($row['description']);
                $movie->setLenght($row['length']);
                $movie->setLanguage($row['language']);
                $movie->setGenre($row['genre']);
                $movie->setAgeLimit($row['ageLimit']);
                $movie->setRanking($row['ranking']);
                $movie->setReleaseYear($row['releaseYear']);
                $movie->getDirector()->setFirstName($row['firstName']);
                $movie->getDirector()->setLastName($row['lastName']);
                
                $actorStmt = $db->prepare("SELECT * FROM CastMember cm JOIN MovieActor ma ON cm.castMemberID = ma.castMemberID WHERE ma.movieID = :movieID");
                $actorStmt->bindParam(':movieID', $row['movieID'], PDO::PARAM_INT);
                $actorRows = $actorStmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($actorRows as $actorRow) {
                    $actor = new CastMember();
                    $actor->setCastMemberID($actorRow['castMemberID']);
                    $actor->setFirstName($actorRow['firstName']);
                    $actor->setLastName($actorRow['lastName']);
                    $movie->addActor($actor);
                }

                $movies[] = $movie;
            }
        } catch (PDOException $e) {
            // In production you might log this instead.
            echo $e->getMessage();
        }

        return $movies;
    }
}