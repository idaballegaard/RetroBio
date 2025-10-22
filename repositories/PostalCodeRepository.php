<?php
require_once __DIR__ . "/BaseRepository.php";

class PostalCodeRepository extends BaseRepository {

    public function getPostalCodeID(string $postalCode, string $city): ?int {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("SELECT postalCodeID FROM PostalCode WHERE postalCode = :postalCode AND city = :city");
        $stmt->bindValue(':postalCode', $postalCode);
        $stmt->bindValue(':city', $city);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return (int)$row['postalCodeID'];
            } else {
                // Create postal code and return its ID
                $insertStmt = $db->prepare("INSERT INTO PostalCode (postalCode, city) VALUES (:postalCode, :city)");
                $insertStmt->bindValue(':postalCode', $postalCode);
                $insertStmt->bindValue(':city', $city);
                $insertStmt->execute();
                return (int)$db->lastInsertId();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}