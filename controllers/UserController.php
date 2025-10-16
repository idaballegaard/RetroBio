<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../viewmodels/BasicViewModel.php";
require_once __DIR__ . "/../repositories/UserRepository.php";
class UserController extends BaseController {

    public function authenticate(string $emailOrUsername, string $password) : BasicViewModel {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmailOrUsername($emailOrUsername);
        if ($user && password_verify($password, $user->getHashedPassword()  )) {
            $_SESSION['user_id'] = $user->getUserID();
            $_SESSION['username'] = $user->getUsername();
            return new BasicViewModel(__DIR__ . "/../views/login.php");
        } else {
            return new BasicViewModel(__DIR__ . "/../views/login.php", "Invalid username or password.");
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}