<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Movie.php";
require_once __DIR__ . "/../models/CastMember.php";

class MovieRepository extends BaseRepository {

    // Helper metoder
    private function mapRowToMovie(array $row): Movie {
        $movie = new Movie();
        $movie->setMovieID((int)$row['movieID']);
        $movie->setTitle($row['title']);
        $movie->setDescription($row['description']);
        $movie->setLength((int)$row['length']);
        $movie->setLanguage($row['language']);
        $movie->setAgeLimit((int)$row['ageLimit']);
        $movie->setRanking($row['ranking']);
        $movie->setReleaseYear((int)$row['releaseYear']);
        $movie->setCompany($row['name']);
        $movie->getDirector()->setFirstName($row['firstName']);
        $movie->getDirector()->setLastName($row['lastName']);

        $this->loadGenre($movie->getMovieID(), $movie);
        return $movie;
    }

    // Hent cast til en film
    private function loadCast(int $movieID, Movie $movie): void {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("
            SELECT cm.* 
            FROM CastMember cm
            JOIN MovieActor ma ON cm.castMemberID = ma.castMemberID
            WHERE ma.movieID = :movieID
        ");
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row){
            $actor = new CastMember();
            $actor->setCastMemberID($row['castMemberID']);
            $actor->setFirstName($row['firstName']);
            $actor->setLastName($row['lastName']);
            $movie->addActor($actor);
        }
    }

    // Hent genre til en film
    private function loadGenre(int $movieID, Movie $movie): void {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("
            SELECT g.* 
            FROM MovieGenre mg
            JOIN Genre g ON g.genreId = mg.genreId
            WHERE mg.movieID = :movieID
        ");
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row){
            $movie->addGenre($row["name"]);
        }
    }

    // Film på forsiden
    public function getAllMovies(): array {
        $movies = [];
        $db = $this->connectDatabase();
        if (!$db) return $movies;

        try {
            $stmt = $db->query("SELECT * FROM Movie m JOIN Company c ON c.companyID = m.companyID JOIN CastMember cm ON m.directorID = cm.castMemberID");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $movie = $this->mapRowToMovie($row);
                $this->loadCast($row['movieID'], $movie);
                $movies[] = $movie;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $movies;
    }

    // Film på movie-details siden
    public function getMovieById(int $movieID): ?Movie {
        $db = $this->connectDatabase();
        if (!$db) return null;

        try {
            $stmt = $db->prepare("
                SELECT * FROM Movie m 
                LEFT JOIN CastMember cm ON m.directorID = cm.castMemberID
                LEFT JOIN Company c ON c.companyID = m.companyID
                WHERE m.movieID = :movieID
            ");
            $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) return null;

            $movie = $this->mapRowToMovie($row);
            $this->loadCast($movieID, $movie);

            return $movie;
        } catch(PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }

    public function getCompanyForMovie(int $movieID): string {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("
            SELECT c.name 
            FROM Company c 
            JOIN Movie m ON m.companyID = c.companyID 
            WHERE m.movieID = :movieID
        ");
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: '';
    }

    public function getGenresForMovie(int $movieID): array {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("
            SELECT g.name 
            FROM Genre g 
            JOIN MovieGenre mg ON g.genreID = mg.genreID 
            WHERE mg.movieID = :movieID
        ");
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getCastForMovie(int $movieID): array {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("
            SELECT CONCAT(cm.firstName,' ',cm.lastName) as fullName
            FROM CastMember cm
            JOIN MovieActor ma ON cm.castMemberID = ma.castMemberID
            WHERE ma.movieID = :movieID
        ");
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getMoviesForAdmin() {
        UserRepository::dieIfNotAdmin();

        $movies = [];
        $db = $this->connectDatabase();
        if (!$db) return $movies;

        try {
            $stmt = $db->query("SELECT * FROM Movie m JOIN Company c ON c.companyID = m.companyID JOIN CastMember cm ON m.directorID = cm.castMemberID");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $movie = $this->mapRowToMovie($row);
                $this->loadCast($row['movieID'], $movie);
                $movies[] = $movie;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $movies;
    }
}