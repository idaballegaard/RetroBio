<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Showing.php";

class ShowingRepository extends BaseRepository
{
  public function getShowingById($showingID): ?Showing
  {
    // Implementation can be added as needed
    $pdo = $this->connectDatabase();
    $stmt = $pdo->prepare("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number
                            FROM Showing s
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            WHERE s.showingID = :showingID
        ");
    $stmt->bindValue(":showingID", $showingID, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return $this->mapRowToShowing($row);
    }

    return null;
  }

  /** @return Showing[] */
  public function getShowingsThisWeek(): array
  {
    $pdo = $this->connectDatabase();
    $stmt = $pdo->query("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number
                            FROM Showing s
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            WHERE s.date >= CURDATE() AND s.date < DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                            ORDER BY s.date, s.startTime ASC
        ");
    $stmt->execute();

    $showings = [];
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      $showings[] = $this->mapRowToShowing($row);
    }
    return $showings;
  }

  private function mapRowToShowing($row): Showing
  {
    $showing = new Showing();
    $showing->setShowingID($row['showingID']);
    $showing->setType($row['type']);
    $showing->setStartTime($row['startTime']);
    $showing->setDate(new DateTime($row['date']));
    $showing->setPrice($row['price']);
    $showing->setMovieID($row['movieID']);

    $showing->getHall()->setHallID($row['hallID']);
    $showing->getHall()->setName($row['name']);
    $showing->getHall()->setNumber($row['number']);

    return $showing;
  }

  private function getGenresByMovieId($movieID): array
  {
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

  /** @return Showing[] */
  public function getFutureShowingsByMovieId(int $movieID): array
  {
    $pdo = $this->connectDatabase();
    $stmt = $pdo->prepare("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID,
                        h.name, h.number
                    FROM Showing s
                    LEFT JOIN Hall h ON s.hallID = h.hallID
                    WHERE s.movieID = :movieID AND s.date >= CURDATE()
                    ORDER BY s.date, s.startTime ASC");
    $stmt->bindValue(":movieID", $movieID, PDO::PARAM_INT);
    $stmt->execute();

    /** @var Showing[] $showings */
    $showings = [];
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      $showings[] = $this->mapRowToShowing($row);
    }
    return $showings;
  }

  /** @return Showing[] */
  public function getAllShowings(): array
  {
    UserRepository::dieIfNotAdmin();

    $showings = [];
    $pdo = $this->connectDatabase();
    $stmt = $pdo->query("SELECT s.showingID, s.date, s.type, s.startTime, s.hallID, s.price, s.movieID, 
                                    h.name, h.number
                            FROM Showing s
                            LEFT JOIN Hall h ON s.hallID = h.hallID
                            ORDER BY s.date, s.startTime ASC
        ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      /** @var Showing */
      $previous = end($showings);
      if ($previous && $previous->getMovie()->getMovieID() === $row['movieID']) {
        $previous->addReelTime($row['startTime']);
        continue;
      }

      $showings[] = $this->mapRowToShowing($row);
    }
    return $showings;
  }

  public function saveShowing(Showing $showing): void
  {
    UserRepository::dieIfNotAdmin();

    $pdo = $this->connectDatabase();
    if ($showing->getShowingID() > 0) {
      $stmt = $pdo->prepare("UPDATE Showing SET movieID = :movieID, date = :date, startTime = :startTime, type = :type, price = :price, hallID = :hallID WHERE showingID = :showingID");
      $stmt->bindValue(":showingID", $showing->getShowingID(), PDO::PARAM_INT);
    } else {
      $stmt = $pdo->prepare("INSERT INTO Showing (movieID, date, startTime, type, price, hallID) VALUES (:movieID, :date, :startTime, :type, :price, :hallID)");
    }
    $stmt->bindValue(":movieID", $showing->getMovieID(), PDO::PARAM_INT);
    $stmt->bindValue(":date", $showing->getDate()->format("Y-m-d"), PDO::PARAM_STR);
    $stmt->bindValue(":startTime", "00:00", PDO::PARAM_STR);
    $stmt->bindValue(":type", $showing->getType(), PDO::PARAM_STR);
    $stmt->bindValue(":price", $showing->getPrice(), PDO::PARAM_STR);
    $stmt->bindValue(":hallID", $showing->getHall()->getHallID(), PDO::PARAM_INT);
    $stmt->execute();
  }

  public function deleteShowing(int $showingID): void
  {
    UserRepository::dieIfNotAdmin();

    $pdo = $this->connectDatabase();
    $stmt = $pdo->prepare("DELETE FROM Showing WHERE showingID = :showingID");
    $stmt->bindValue(":showingID", $showingID, PDO::PARAM_INT);
    $stmt->execute();
  }
}