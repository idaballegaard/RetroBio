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
}