<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../controllers/HomeController.php";
require_once __DIR__ . "/../viewmodels/BasicViewModel.php";
require_once __DIR__ . "/../viewmodels/ProfileViewModel.php";
require_once __DIR__ . "/../repositories/UserRepository.php";

class UserController extends BaseController {

    public function authenticate(string $emailOrUsername, string $password) : BasicViewModel {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmailOrUsername($emailOrUsername);

        if ($user && password_verify($password, $user->getHashedPassword())) {
            $_SESSION['user_id'] = $user->getUserID();
            $_SESSION['username'] = $user->getUsername();

            $homeController = new HomeController();
            return $homeController->frontpage();
        } else {
            return new BasicViewModel(__DIR__ . "/../views/login.php", "Invalid username or password.");
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: " . generateUrl(""));
    }

    public function register(
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
        string $password,
        string $confirmPassword
    ) : BasicViewModel {
        $userRepository = new UserRepository();
        $viewModel = new BasicViewModel(__DIR__ . "/../views/register.php");

        // 1️⃣ Valider adgangskoder
        if ($password !== $confirmPassword) {
            $viewModel->setErrorMessage("Passwords do not match.");
            return $viewModel;
        }

        // 2️⃣ Tjek om brugernavn eller email allerede findes
        if ($userRepository->getUserByEmailOrUsername($email) || $userRepository->getUserByEmailOrUsername($username)) {
            $viewModel->setErrorMessage("Username or email already exists.");
            return $viewModel;
        }

        // 3️⃣ Hash adgangskoden
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // 4️⃣ Opret brugeren (forventer et User-objekt retur)
        $user = $userRepository->createUser(
            $firstName,
            $lastName,
            $username,
            $email,
            $phone,
            $country,
            $city,
            $postalCode,
            $street,
            $streetNumber,
            $hashedPassword
        );

        // 5️⃣ Hvis oprettelse lykkes, log brugeren ind
        if ($user) {
            $_SESSION['user_id'] = $user->getUserID();
            $_SESSION['username'] = $user->getUsername();

            // Redirect til frontpage via BasicViewModel
            header("Location: " . generateUrl(""));
            exit;
        } else {
            $viewModel = new BasicViewModel(__DIR__ . "/../views/register.php");
            $viewModel->setErrorMessage("Registration failed. Please try again.");
            return $viewModel;
        }
    }

    public function showProfile(int $userID) : BasicViewModel {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByID($userID);

        if ($user) {
            $viewModel = new ProfileViewModel(__DIR__ . "/../views/profile.php");
            $viewModel->setUser($user);
            return $viewModel;
        } else {
            $viewModel = new BasicViewModel(__DIR__ . "/../views/404.php", "User not found.");
            return $viewModel;
        }
    }
}