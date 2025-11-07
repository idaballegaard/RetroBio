<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Movie.php";
require_once __DIR__ . "/../models/Genre.php";
require_once __DIR__ . "/../models/CastMember.php";
require_once __DIR__ . "/../models/Company.php";

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
        $movie->setCompany(new Company((int)$row['companyID'], $row['name']));
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
            $genre = new Genre();
            $genre->setGenreID((int)$row["genreID"]);
            $genre->setName($row["name"]);
            $movie->addGenre($genre);
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

    public function saveMovie(Movie $movie): void {
        UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return;

        try {
            // Begin transaction
            $db->beginTransaction();
            $stmt = $db->prepare("
                UPDATE Movie 
                SET 
                    title = :title, 
                    description = :description, 
                    length = :length, 
                    language = :language, 
                    ageLimit = :ageLimit, 
                    ranking = :ranking, 
                    releaseYear = :releaseYear,
                    directorID = :directorID,
                    companyID = :companyID
                WHERE movieID = :movieID
            ");
            
            $title = $movie->getTitle();
            $description = $movie->getDescription();
            $length = $movie->getLength();
            $language = $movie->getLanguage();
            $ageLimit = $movie->getAgeLimit();
            $ranking = $movie->getRanking();
            $releaseYear = $movie->getReleaseYear();
            $movieID = $movie->getMovieID();
            $directorID = $movie->getDirector()->getCastMemberID();
            $companyID = $movie->getCompany()->getCompanyID();

            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->bindParam(':language', $language, PDO::PARAM_STR);
            $stmt->bindParam(':ageLimit', $ageLimit, PDO::PARAM_INT);
            $stmt->bindParam(':ranking', $ranking, PDO::PARAM_STR);
            $stmt->bindParam(':releaseYear', $releaseYear, PDO::PARAM_INT);
            $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $stmt->bindParam(':directorID', $directorID, PDO::PARAM_INT);
            $stmt->bindParam(':companyID', $companyID, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() === 0) {
                // insert instead
                $insertStmt = $db->prepare("
                    INSERT INTO Movie (title, description, length, language, ageLimit, ranking, releaseYear, directorID, companyID) 
                    VALUES (:title, :description, :length, :language, :ageLimit, :ranking, :releaseYear, :directorID, :companyID)
                ");
                $insertStmt->bindParam(':title', $title, PDO::PARAM_STR);
                $insertStmt->bindParam(':description', $description, PDO::PARAM_STR);
                $insertStmt->bindParam(':length', $length, PDO::PARAM_INT);
                $insertStmt->bindParam(':language', $language, PDO::PARAM_STR);
                $insertStmt->bindParam(':ageLimit', $ageLimit, PDO::PARAM_INT);
                $insertStmt->bindParam(':ranking', $ranking, PDO::PARAM_STR);
                $insertStmt->bindParam(':releaseYear', $releaseYear, PDO::PARAM_INT);
                $insertStmt->bindParam(':directorID', $directorID, PDO::PARAM_INT);
                $insertStmt->bindParam(':companyID', $companyID, PDO::PARAM_INT);
                $insertStmt->execute();
                $movieID = $db->lastInsertId();
            }

            // Delete existing movie genres
            $deleteStmt = $db->prepare("DELETE FROM MovieGenre WHERE movieID = :movieID");
            $deleteStmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $deleteStmt->execute();

            // Insert new movie genres
            $insertGenreStmt = $db->prepare("INSERT INTO MovieGenre (movieID, genreID) VALUES (:movieID, :genreID)");
            foreach ($movie->getGenres() as $genre) {
                $genreId = $genre->getGenreID();
                $insertGenreStmt->bindValue(':movieID', $movieID, PDO::PARAM_INT);
                $insertGenreStmt->bindValue(':genreID', $genreId, PDO::PARAM_INT);
                $insertGenreStmt->execute();
            }

            // Commit transaction
            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo $e->getMessage();
            // print line number
            echo "Error on line: " . $e->getLine();
        }
    }

    public function deleteMovie(int $movieID): void {
        UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return;

        try {
            $db->beginTransaction();

            $stmt = $db->prepare("DELETE FROM MovieGenre WHERE movieID = :movieID");
            $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $db->prepare("DELETE FROM Movie WHERE movieID = :movieID");
            $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $stmt->execute();
            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            echo $e->getMessage();
        }
    }
}