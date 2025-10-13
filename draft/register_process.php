<?php
session_start();

// Simuleret database (her kan du erstatte med MySQL senere)
$usersFile = 'users.json';

// Hent eksisterende brugere
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Hent data fra formularen
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Tjek om passwords matcher
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match!";
    header("Location: register.php");
    exit();
}

// Tjek om brugernavn eller email allerede findes
foreach ($users as $user) {
    if ($user['username'] === $username || $user['email'] === $email) {
        $_SESSION['error'] = "Username or email already taken!";
        header("Location: register.php");
        exit();
    }
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Tilføj bruger
$users[] = [
    'username' => $username,
    'email' => $email,
    'password' => $hashed_password
];

// Gem tilbage i JSON
file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

// Log brugeren ind
$_SESSION['username'] = $username;

header("Location: index.php");
exit();
?>
