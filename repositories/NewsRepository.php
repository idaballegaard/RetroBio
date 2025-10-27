<?php
require_once __DIR__ . "/BaseRepository.php";
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
}