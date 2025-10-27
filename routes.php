<?php
session_start();
require_once __DIR__.'/router.php';
require_once __DIR__.'/helpers.php';

// Frontpage
get(generateUrl("/"), function() {
    echo "HMM";
    require_once __DIR__ . "/controllers/HomeController.php";
    $controller = new HomeController();
    $controller->frontpage()->presentView();
});

// Login
get(generateUrl("login"), "views/login.php");
post(generateUrl("login"), function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->authenticate($_POST["username"], $_POST["password"])->presentView();
});

// Logout
get(generateUrl("logout"), function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->logout();
});

// Movie details
get(generateUrl("movie-details"), function() {
    require_once __DIR__ . "/controllers/MovieController.php";
    $controller = new MovieController();
    $controller->showMovieDetails($_GET['id'] ?? 1)->presentView();
});

// Test
get(generateUrl("test"), function() {
    require_once __DIR__ . "/controllers/TestController.php";
    $testController = new TestController();
    $testController->showFrontpage()->presentView();
});

// Register
get(generateUrl("register"), function() {
    require_once __DIR__ . "/views/register.php";
});

post(generateUrl("register"), function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();

    // Hent alle POST-data
    $firstName = $_POST["firstName"] ?? '';
    $lastName = $_POST["lastName"] ?? '';
    $username = $_POST["username"] ?? '';
    $email = $_POST["email"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $country = $_POST["country"] ?? '';
    $city = $_POST["city"] ?? '';
    $postalCode = $_POST["postalCode"] ?? '';
    $street = $_POST["street"] ?? '';
    $streetNumber = $_POST["streetNumber"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirmPassword = $_POST["confirm_password"] ?? '';

    // Kald controller
    $controller->register(
        $firstName, $lastName, $username, $email, $phone,
        $country, $city, $postalCode, $street, $streetNumber,
        $password, $confirmPassword
    )->presentView();
});

get(generateUrl("profile"), function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->showProfile($_SESSION["user_id"])->presentView();
});

// 404
any(generateUrl('404'),'views/404.php');