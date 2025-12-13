<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/UserRepository.php";
require_once __DIR__ . "/../models/News.php";

class NewsRepository extends BaseRepository {
    public function getLatestNews(int $limit = 5): array {
        $newsList = [];
        $db = $this->connectDatabase();
        if (!$db) return $newsList;

        try {
            $stmt = $db->prepare("SELECT * FROM News ORDER BY releaseDate DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $news = new News();
                $news->setNewsID((int)$row['newsID']);
                $news->setTitle($row['title']);
                $news->setDescription($row['description']);
                $news->setReleaseDate(new DateTime($row['releaseDate']));
                $newsList[] = $news;
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

        return $newsList;
    }

    public function getAllNews() {
        UserRepository::dieIfNotAdmin();

        $newsList = []; 
        $db = $this->connectDatabase();    
        if (!$db) return $newsList;

        try {
            $stmt = $db->prepare("SELECT * FROM News ORDER BY releaseDate DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $news = new News();
                $news->setNewsID((int)$row['newsID']);
                $news->setTitle($row['title']);
                $news->setDescription($row['description']);
                $news->setReleaseDate(new DateTime($row['releaseDate']));
                $newsList[] = $news;
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

        return $newsList;
    }

    public function saveNews(News $news): void {
        UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return;

        try {
            if ($news->getNewsID() > 0) {
                $stmt = $db->prepare("UPDATE News SET title = :title, description = :description, releaseDate = :releaseDate WHERE newsID = :newsID");
                $stmt->bindValue(':newsID', $news->getNewsID(), PDO::PARAM_INT);
            } else {
                $stmt = $db->prepare("INSERT INTO News (title, description, releaseDate) VALUES (:title, :description, :releaseDate)");
            }

            $stmt->bindValue(':title', $news->getTitle(), PDO::PARAM_STR);
            $stmt->bindValue(':description', $news->getDescription(), PDO::PARAM_STR);
            $stmt->bindValue(':releaseDate', $news->getReleaseDate()->format('Y-m-d'), PDO::PARAM_STR);

            $stmt->execute();
            if($news->getNewsID() == 0) {
              $newsID = $db->lastInsertId();
              $news->setNewsID((int)$newsID);
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public function deleteNews(int $newsID): void {
        UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return;

        try {
            $stmt = $db->prepare("DELETE FROM News WHERE newsID = :newsID");
            $stmt->bindValue(':newsID', $newsID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}