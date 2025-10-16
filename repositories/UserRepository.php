<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/User.php";
class UserRepository extends BaseRepository {
    public function getUserByEmailOrUsername(string $emailOrUsername) : User | null {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("SELECT * FROM `User` u JOIN PostalCode p ON u.postalCodeID = p.postalCodeID WHERE email = :emailOrUsername OR username = :emailOrUsername");
        $stmt->bindValue(':emailOrUsername', $emailOrUsername);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                $user = new User();
                $user->setUserID($row['userID']);
                $user->setFirstName($row['firstName']);
                $user->setLastName($row['lastName']);
                $user->setUsername($row['username']);
                $user->setEmail($row['email']);
                $user->setHashedPassword($row['hashedPassword']);
                $user->setPhone($row['phone']);
                $user->setCountry($row['country']);
                $user->setStreet($row['street']);
                $user->setStreetNumber($row['streetNumber']);
                $user->setPostalCode($row['postalCode']);
                $user->setCity($row['city']);
                return $user;
            } else {
                return null;
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}