<?php
require_once __DIR__."/../models/Hall.php";
require_once __DIR__."/BaseRepository.php";
class HallRepository extends BaseRepository {

    /** @return Hall[] */
    public function getAllHalls(): array {
        $db = $this->connectDatabase();
        if (!$db) return [];

        $halls = [];
        $stmt = $db->prepare("SELECT * FROM Hall");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $hall = new Hall();
            $hall->setHallID((int)$row['hallID']);
            $hall->setName($row['name']);
            $hall->setNumber((int)$row['number']);
            $halls[] = $hall;
        }

        return $halls;
    }

    public function getHallById(int $hallID): ?Hall {
        $db = $this->connectDatabase();
        if (!$db) return null;

        $stmt = $db->prepare("SELECT * FROM Hall WHERE hallID = :hallID");
        $stmt->bindParam(':hallID', $hallID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $hall = new Hall();
            $hall->setHallID((int)$row['hallID']);
            $hall->setName($row['name']);
            $hall->setNumber((int)$row['number']);
            return $hall;
        }

        return null;
    }
}