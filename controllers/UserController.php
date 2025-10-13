<?php
require_once __DIR__ . "/BaseController.php";
class UserController extends BaseController {

    public function login($username, $password) {
        $db = $this->connectDatabase();
        $stmt = $db->prepare("SELECT * FROM `User` WHERE email = :email");
        $stmt->bindValue(':email', $username);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['hashedPassword'])) {
                $_SESSION['user_id'] = $row['ID'];
                $_SESSION['username'] = $row['email'];
                header("Location: /RetroBio");
                exit();
            } else {
                header("Location: login.php?error=1");
                exit();
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}