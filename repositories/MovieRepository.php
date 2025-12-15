<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Movie.php";
require_once __DIR__ . "/../models/MovieDetails.php";
require_once __DIR__ . "/../models/Genre.php";
require_once __DIR__ . "/../models/CastMember.php";
require_once __DIR__ . "/../models/Company.php";

class MovieRepository extends BaseRepository
{

  // Henter alle film
  /** @return MovieDetails[] */
  public function getAllMovies(): array
  {
    $movies = [];
    $db = $this->connectDatabase();
    if (!$db) return $movies;

    try {
      $stmt = $db->query("
                SELECT movieID, 
                    title,
                    description,
                    releaseYear,
                    length,
                    language,
                    ageLimit,
                    ranking,
                    director,
                    directorID,
                    company,
                    genres,
                    genreIDs,
                    actors,
                    actorIDs
                FROM moviedetail 
                ORDER BY title ASC
            ");
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($rows as $row) {
        $movies[] = $this->mapMovieDetailsRowToMovie($row);
      }
    } catch (PDOException $e) {
      echo "Fejl ved hentning af film: " . $e->getMessage();
    }

    return $movies;
  }

  // Henter én film baseret på ID
  public function getMovieById(int $movieID): ?Movie
  {
    $db = $this->connectDatabase();
    if (!$db) return null;

    try {
      $stmt = $db->prepare("SELECT * FROM moviedetail WHERE movieID = :movieID");
      $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$row) return null;

      return $this->mapMovieDetailsRowToMovie($row);
    } catch (PDOException $e) {
      echo "Fejl ved hentning af film med ID $movieID: " . $e->getMessage();
      return null;
    }
  }

  // Henter flere film baseret på en liste af ID'er
  /** @param int[] $movieIDs */
  /** @return Movie[] */
  public function getMoviesByIds(array $movieIDs): array
  {
    if (empty($movieIDs)) {
      return [];
    }

    $db = $this->connectDatabase();
    if (!$db) return [];

    // Build placeholders for prepared statement
    $placeholders = implode(',', array_fill(0, count($movieIDs), '?'));

    try {
      $stmt = $db->prepare(
        "SELECT * FROM moviedetail WHERE movieID IN ($placeholders)"
      );

      foreach ($movieIDs as $index => $movieID) {
        $stmt->bindValue($index + 1, $movieID, PDO::PARAM_INT);
      }

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $movies = [];
      foreach ($rows as $row) {
        $movies[$row['movieID']] = $this->mapMovieDetailsRowToMovie($row);
      }

      return $movies;
    } catch (PDOException $e) {
      echo "Fejl ved hentning af film: " . $e->getMessage();
      return [];
    }
  }

  public function getMoviesByShowingId(array $showingIDs): array
  {
    $db = $this->connectDatabase();
    if (!$db) return [];

    $placeholders = implode(',', array_fill(0, count($showingIDs), '?'));

    $stmt = $db->prepare("SELECT * FROM moviedetail m JOIN Showing s ON m.movieID = s.movieID WHERE s.showingID IN ($placeholders)");
    foreach ($showingIDs as $index => $showingID) {
      $stmt->bindValue($index + 1, $showingID, PDO::PARAM_INT);
    }
    $stmt->execute();

    $movies = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $movies[$row["showingID"]] = $this->mapMovieDetailsRowToMovie($row);
    }
    return $movies;
  }

  private function mapMovieDetailsRowToMovie(array $row): Movie
  {
    $movie = new Movie();
    $movie->setMovieID((int)$row['movieID']);
    $movie->setTitle($row['title'] ?? '');
    $movie->setDescription($row['description'] ?? '');
    $movie->setReleaseYear((int)($row['releaseYear'] ?? 0));
    $movie->setLength((int)($row['length'] ?? 0));
    $movie->setLanguage($row['language'] ?? '');
    $movie->setAgeLimit((int)($row['ageLimit'] ?? 0));
    $movie->setRanking($row['ranking'] ?? '');

    // Instruktør
    $movie->setDirector(new CastMember());
    $movie->getDirector()->setCastMemberID($row['directorID']);
    $movie->getDirector()->setName($row['director']);

    // Firma
    $company = new Company(0, $row['company'] ?? '');
    $movie->setCompany($company);

    // Genrer
    $genres = array_filter(array_map('trim', explode(',', $row['genres'] ?? '')));
    $genreIds = array_filter(array_map('trim', explode(',', $row['genreIDs'] ?? '')));
    foreach ($genres as $index => $g) {
      $genre = new Genre();
      $genre->setGenreID($genreIds[$index]);
      $genre->setName($g);
      $movie->addGenre($genre);
    }

    // Skuespillere
    $actors = array_filter(array_map('trim', explode(',', $row['actors'] ?? '')));
    $actorIds = array_filter(array_map('trim', explode(',', $row['actorIDs'] ?? '')));
    foreach ($actors as $index => $a) {
      $actor = new CastMember();
      $actor->setCastMemberID($actorIds[$index]);
      $actor->setName($a);
      $movie->addActor($actor);
    }

    return $movie;
  }

  public function saveMovie(Movie $movie): void
  {
    UserRepository::dieIfNotAdmin();

    $db = $this->connectDatabase();
    if (!$db) return;

    try {
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

      if ($stmt->rowCount() === 0) {
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
        $movie->setMovieID($movieID);
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

      // Delete existing movie actors
      $deleteActorsStmt = $db->prepare("DELETE FROM MovieActor WHERE movieID = :movieID");
      $deleteActorsStmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
      $deleteActorsStmt->execute();

      // Insert new movie actors
      $insertActorStmt = $db->prepare("INSERT INTO MovieActor (movieID, castMemberID) VALUES (:movieID, :castMemberID)");
      foreach ($movie->getActors() as $actor) {
        $actorId = $actor->getCastMemberID();
        $insertActorStmt->bindValue(':movieID', $movieID, PDO::PARAM_INT);
        $insertActorStmt->bindValue(':castMemberID', $actorId, PDO::PARAM_INT);
        $insertActorStmt->execute();
      }

      $db->commit();
    } catch (PDOException $e) {
      $db->rollBack();
      echo $e->getMessage();
    }
  }

  public function saveGenres($genres): array
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

  /** @param string[] $castMembers */
  /** @return CastMember[] */
  public function saveCastMembers($castMembers): array
  {
    UserRepository::dieIfNotAdmin();

    $db = $this->connectDatabase();
    if (!$db) return [];

    $savedCastMembers = [];
    try {
      // iterate cast members and get their ids - insert if not exist
      foreach ($castMembers as $fullName) {
        $stmt = $db->prepare("SELECT castMemberID FROM CastMember WHERE name = :name");
        $stmt->bindParam(':name', $fullName, PDO::PARAM_STR);
        $stmt->execute();

        $castMemberID = $stmt->fetchColumn();
        // If not exists, insert new cast member
        if (!$castMemberID) {
          $insertStmt = $db->prepare("INSERT INTO CastMember (name) VALUES (:name)");
          $insertStmt->bindParam(':name', $fullName, PDO::PARAM_STR);
          $insertStmt->execute();
          $castMemberID = $db->lastInsertId();
        }

        $castMember = new CastMember();
        if ($castMemberID != 0) {
          $castMember->setCastMemberID($castMemberID);
        }
        $castMember->setName($fullName);
        $savedCastMembers[] = $castMember;
      }
      return $savedCastMembers;
    } catch (PDOException $e) {
      echo "Database error: " . $e->getMessage();
      return [];
    }
  }

  public function deleteMovie(int $movieID): void
  {
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