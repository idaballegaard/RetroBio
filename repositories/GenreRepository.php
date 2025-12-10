<?php
require_once __DIR__ . "/BaseRepository.php";

class GenreRepository extends BaseRepository {
    
    // @return string[]
    public function getGenresByMovieId(int $movieID): array {
        $db = $this->connectDatabase();
        if (!$db) return [];

        try {
            $stmt = $db->prepare("SELECT g.name 
                                  FROM MovieGenre mg
                                  JOIN Genre g ON mg.genreID = g.genreID
                                  WHERE mg.movieID = :movieID");
            $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
            $stmt->execute();

            $result = [];
            foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $genreName) {
                $result[] = $genreName;
            }
            return $result;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return [];
        }
    }

    /** @param string[] $genres */
    /** @return Genre[] */
    public function saveGenres($genres) : array
    {
      UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return [];

        $savedGenres = [];
        try {
            // iterate genres and get their ids - insert if not exist
            foreach ($genres as $genreName) {
                // Check if genre exists
                $stmt = $db->prepare("SELECT genreID FROM Genre WHERE name = :name");
                $stmt->bindParam(':name', $genreName, PDO::PARAM_STR);
                $stmt->execute();
                $genreID = $stmt->fetchColumn();

                // If not exists, insert new genre
                if (!$genreID) {
                    $insertStmt = $db->prepare("INSERT INTO Genre (name) VALUES (:name)");
                    $insertStmt->bindParam(':name', $genreName, PDO::PARAM_STR);
                    $insertStmt->execute();
                    $genreID = $db->lastInsertId();
                }
                $genre = new Genre();
                $genre->setGenreID((int)$genreID);
                $genre->setName($genreName);
                $savedGenres[] = $genre;
            }
            return $savedGenres;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return [];
        }
    }
}