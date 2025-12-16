<?php
require_once __DIR__ . "/BaseRepository.php";
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
        $db = $this->connectDatabase();
        $postalCodeID = $this->getPostalCodeID($postalCode, $city);

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

  private function getPostalCodeID(string $postalCode, string $city): ?int {
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

    public function getUserByID(int $userID): User | null {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("SELECT * FROM `User` u JOIN PostalCode p ON u.postalCodeID = p.postalCodeID WHERE u.userID = :userID");
        $stmt->bindValue(':userID', $userID);
        return $this->readUserFromDatabase($stmt);
    }

    public function getUsersByID(array $userIDs): array {
        $db = $this->connectDatabase();

        if(empty($userIDs)) {
          return [];
        }

        $placeholders = implode(',', array_fill(0, count($userIDs), '?'));
        $stmt = $db->prepare("SELECT * FROM `User` u JOIN PostalCode p ON u.postalCodeID = p.postalCodeID WHERE u.userID IN ($placeholders)");
        foreach ($userIDs as $index => $userID) {
            $stmt->bindValue($index + 1, $userID, PDO::PARAM_INT);
        }
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $users[$row['userID']] = $this->readUserFromDatabase($stmt);
        }
        return $users;
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

  public function updateProfile(User $user): void {
    // Implementation for updating user details in the database
    $db = $this->connectDatabase();
    $stmt = $db->prepare("
        UPDATE `User` SET
            firstName = :firstName,
            lastName = :lastName,
            email = :email,
            phone = :phone,
            country = :country,
            postalCodeID = :postalCodeID,
            street = :street,
            streetNumber = :streetNumber
        WHERE userID = :userID
    ");

    // Bind values and execute the statement
    $stmt->bindValue(':firstName', $user->getFirstName());
    $stmt->bindValue(':lastName', $user->getLastName());
    $stmt->bindValue(':email', $user->getEmail());
    $stmt->bindValue(':phone', $user->getPhone());
    $stmt->bindValue(':street', $user->getStreet());
    $stmt->bindValue(':streetNumber', $user->getStreetNumber());
    $stmt->bindValue(':postalCodeID', $this->getPostalCodeID($user->getPostalCode(), $user->getCity()));
    $stmt->bindValue(':country', $user->getCountry());
    $stmt->bindValue(':userID', $user->getUserID());

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
    }
  }
}