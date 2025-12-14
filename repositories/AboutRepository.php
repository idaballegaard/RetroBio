<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/About.php";

class AboutRepository extends BaseRepository {

    public function getAboutInfo(): array {
        $db = $this->connectDatabase();
        if (!$db) return [];

        try {
            $stmt = $db->prepare("SELECT * FROM About");
            $stmt->execute();

            $about = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $about[$row["key"]] = $row["value"];
            }
            return $about;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

        return [];
    }

    public function saveAboutInfo(array $aboutData): void {
        $db = $this->connectDatabase();
        if (!$db) return;

        try {
            foreach ($aboutData as $key => $value) {
                $stmt = $db->prepare("UPDATE About SET `value` = :value WHERE `key` = :key");
                $stmt->bindParam(':key', $key);
                $stmt->bindParam(':value', $value);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

}