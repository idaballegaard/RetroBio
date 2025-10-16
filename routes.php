<?php
session_start();
$basePath = '/RetroBio';
require_once __DIR__.'/router.php';
require_once __DIR__.'/helpers.php';

get("$basePath", function() {
    require_once __DIR__ . "/controllers/HomeController.php";
    $controller = new HomeController();
    $controller->frontpage()->presentView();
});
get("$basePath/login", "views/login.php");
post("$basePath/login", function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->authenticate($_POST["username"], $_POST["password"])->presentView();
});
get("$basePath/logout", function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->logout();
});
get("$basePath/test", function() {
    require_once __DIR__ . "/controllers/TestController.php";
    $testController = new TestController();
    $testController->showFrontpage()->presentView();
});

any('/404','views/404.php');