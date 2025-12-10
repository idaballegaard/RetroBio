<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/About.php";

class AboutRepository extends BaseRepository {

    public function getAboutInfo(): ?About {
        $db = $this->connectDatabase();
        if (!$db) return null;

        try {
            $stmt = $db->prepare("SELECT * FROM About LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $about = new About();
                $about->setAboutID((int)$row['aboutID']);
                $about->setTitle($row['title']);
                $about->setSubtitle($row['subtitle']);
                $about->setDescription($row['description']);
                $about->setAddress($row['address']);
                $about->setEmail($row['email']);
                $about->setPhone($row['phone']);
                return $about;
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

        return null;
    }

}