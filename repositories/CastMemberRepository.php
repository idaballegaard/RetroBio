<?php
require_once __DIR__ . "/../models/CastMember.php";

class CastMemberRepository extends BaseRepository {

    /** @param string[] $castMembers */
    /** @return CastMember[] */
    public function saveCastMembers($castMembers) : array {
        UserRepository::dieIfNotAdmin();

        $db = $this->connectDatabase();
        if (!$db) return [];

        $savedCastMembers = [];
        try {
            // iterate cast members and get their ids - insert if not exist
            foreach ($castMembers as $fullName) {
                $names = explode(" ", trim($fullName), 2);
                $firstName = $names[0];
                $lastName = $names[1] ?? "";

                // Update cast member if exists, else insert new
                $stmt = $db->prepare("UPDATE CastMember 
                                      SET firstName = :firstName, lastName = :lastName 
                                      WHERE firstName = :firstName AND lastName = :lastName");
                $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() === 0) {
                    $insertStmt = $db->prepare("INSERT INTO CastMember (firstName, lastName) 
                                                VALUES (:firstName, :lastName)");
                    $insertStmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
                    $insertStmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
                    $insertStmt->execute();
                    $castMemberID = $db->lastInsertId();
                }

                $castMember = new CastMember();
                $castMember->setCastMemberID(isset($castMemberID) ? (int)$castMemberID : 0);
                $castMember->setFirstName($firstName);
                $castMember->setLastName($lastName);
                $savedCastMembers[] = $castMember;
            }
            return $savedCastMembers;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return [];
        }
    }

}