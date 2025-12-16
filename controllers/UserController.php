<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../controllers/HomeController.php";
require_once __DIR__ . "/../viewModels/BasicViewModel.php";
require_once __DIR__ . "/../viewModels/ProfileViewModel.php";
require_once __DIR__ . "/../repositories/UserRepository.php";
require_once __DIR__ . "/../repositories/OrderRepository.php";

class UserController extends BaseController {

    public function authenticate() : BasicViewModel {
        $emailOrUsername = $_REQUEST["username"];
        $password = $_REQUEST["password"];

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmailOrUsername($emailOrUsername);

        if ($user && password_verify($password, $user->getHashedPassword())) {
            $_SESSION['user_id'] = $user->getUserID();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['role'] = $user->getIsAdmin() ? "admin" : "user";

            $homeController = new HomeController();
            return $homeController->frontpage();
        } else {
            return new BasicViewModel(__DIR__ . "/../views/login.php", "Invalid username or password.");
        }
    }

    public function logout() : void {
        session_start();
        session_destroy();
        header("Location: " . generateUrl(""));
    }

    public function register() : BasicViewModel {
        $firstName = $this->retrieveInput("firstName");
        $lastName = $this->retrieveInput("lastName");
        $username = $this->retrieveInput("username");
        $email = $this->retrieveInput("email");
        $phone = $this->retrieveInput("phone");
        $country = $this->retrieveInput("country");
        $city = $this->retrieveInput("city");
        $postalCode = $this->retrieveInput("postalCode");
        $street = $this->retrieveInput("street");
        $streetNumber = $this->retrieveInput("streetNumber");
        $password = $this->retrieveInput("password");
        $confirmPassword = $this->retrieveInput("confirm_password");

        $userRepository = new UserRepository();
        $viewModel = new BasicViewModel(__DIR__ . "/../views/register.php");

        // Valider adgangskoder
        if ($password !== $confirmPassword) {
            $viewModel->setErrorMessage("Passwords do not match.");
            return $viewModel;
        }

        // Tjek om brugernavn eller email allerede findes
        if ($userRepository->getUserByEmailOrUsername($email) || $userRepository->getUserByEmailOrUsername($username)) {
            $viewModel->setErrorMessage("Username or email already exists.");
            return $viewModel;
        }

        // Hash adgangskoden
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Opret brugeren (forventer et User-objekt retur)
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

        // Hvis oprettelse lykkes, log brugeren ind
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
    public function showProfile() : BasicViewModel {
        $userID = $_SESSION["user_id"];

        $userRepository = new UserRepository();
        $orderRepository = new OrderRepository();
        $moviesRepository = new MovieRepository();

        $user = $userRepository->getUserByID($userID);
        $orders = $orderRepository->getOrdersByUserID($userID);

        $showingIds = array_map(function($order) {
            return $order->getShowingId();
        }, $orders);

        // $movies to associative array with movieId as key
        $movies = $moviesRepository->getMoviesByShowingID($showingIds);

        if ($user) {
            $viewModel = new ProfileViewModel(__DIR__ . "/../views/profile.php");
            $viewModel->setUser($user);
            $viewModel->setOrders($orders);
            $viewModel->setMovies($movies);
            return $viewModel;
        } else {
          return new BasicViewModel(__DIR__ . "/../views/404.php", "User not found.");
        }
    }
    public function updateProfile() : BasicViewModel
    {
        $userID = $_SESSION["user_id"];

        $firstName = $this->retrieveInput("firstName");
        $lastName = $this->retrieveInput("lastName");
        $email = $this->retrieveInput("email");
        $phone = $this->retrieveInput("phone");
        $street = $this->retrieveInput("street");
        $streetNumber = $this->retrieveInput("streetNumber");
        $postalCode = $this->retrieveInput("postalCode");
        $city = $this->retrieveInput("city");
        $country = $this->retrieveInput("country");

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByID($userID);

        if ($user) {
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setCountry($country);
            $user->setCity($city);
            $user->setPostalCode($postalCode);
            $user->setStreet($street);
            $user->setStreetNumber($streetNumber);

            $userRepository->updateProfile($user);
            return $this->showProfile();
        } else {
            return new BasicViewModel(__DIR__ . "/../views/404.php", "User not found.");
        }
    }
}