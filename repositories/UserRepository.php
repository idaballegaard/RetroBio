<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/PostalCodeRepository.php";
require_once __DIR__ . "/../models/User.php";
class UserRepository extends BaseRepository {

    public function getUserByEmailOrUsername(string $emailOrUsername) : User | null {
      $db = $this->connectDatabase();
      $stmt = $db->prepare("SELECT * FROM `User` u JOIN PostalCode p ON u.postalCodeID = p.postalCodeID WHERE email = :emailOrUsername OR username = :emailOrUsername");
      $stmt->bindValue(':emailOrUsername', $emailOrUsername);
      return $this->readUserFromDatabase($stmt);
    }
    public function createUser(
        string $firstName,
        string $lastName,
        string $username,
        string $email,
        string $phone,
        string $country,
        string $city,
        string $postalCode,
        string $street,
        string $streetNumber,
        string $hashedPassword
    ): ?User {
        $postalCodeRepository = new PostalCodeRepository();
        $db = $this->connectDatabase();

        $postalCodeID = $postalCodeRepository->getPostalCodeID($postalCode, $city);

        $stmt = $db->prepare("
            INSERT INTO `User` (
                firstName, lastName, username, email, phone,
                country, postalCodeID, street, streetNumber, hashedPassword
            ) VALUES (
                :firstName, :lastName, :username, :email, :phone,
                :country, :postalCodeID, :street, :streetNumber, :hashedPassword
            )
        ");

        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':country', $country);
        $stmt->bindValue(':postalCodeID', $postalCodeID);
        $stmt->bindValue(':street', $street);
        $stmt->bindValue(':streetNumber', $streetNumber);
        $stmt->bindValue(':hashedPassword', $hashedPassword);

        try {
            $stmt->execute();
            return $this->getUserByEmailOrUsername($email);
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return null;
        }
    }

    public function getUserByID(int $userID): User | null {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("SELECT * FROM `User` u JOIN PostalCode p ON u.postalCodeID = p.postalCodeID WHERE u.userID = :userID");
        $stmt->bindValue(':userID', $userID);
        return $this->readUserFromDatabase($stmt);
    }

    public static function isAdmin() {
        $userRepository = new UserRepository();
        if(!isset($_SESSION["user_id"])) {
            return false;
        }
        $user = $userRepository->getUserByID($_SESSION["user_id"]);
        return $user->getIsAdmin();
    }

    public static function dieIfNotAdmin() {
        if(!UserRepository::isAdmin()) {
            die("You are not authorized to access this resource.");
        }
    }

  /**
   * @param bool|PDOStatement $stmt
   * @return User|null
   */
  private function readUserFromDatabase(bool|PDOStatement $stmt): ?User
  {
    try {
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row) {
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
        $user->setIsAdmin($row['isAdmin']);
        return $user;
      } else {
        return null;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      return null;
    }
  }
}