<?php
session_start();

$usersFile = 'users.json';

// Hent eksisterende brugere
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Hent data fra formularen
$username_or_email = trim($_POST['username']);
$password = $_POST['password'];

$found = false;

// Tjek brugeren
foreach ($users as $user) {
    if (($user['username'] === $username_or_email || $user['email'] === $username_or_email) 
        && password_verify($password, $user['password'])) {
        $found = true;
        $_SESSION['username'] = $user['username'];
        break;
    }
}

if ($found) {
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid username/email or password!";
    header("Location: login.php");
    exit();
}
?>
