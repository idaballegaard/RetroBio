<?php
session_start();

require_once __DIR__.'/router.php';
get('/RetroBio', "views/index.php");
get('/RetroBio/login', 'views/login.php');
post('/RetroBio/login', function() {
    require_once __DIR__ . "/controllers/UserController.php";
    $controller = new UserController();
    $controller->login($_POST["username"], $_POST["password"]);
});

any('/404','views/404.php');