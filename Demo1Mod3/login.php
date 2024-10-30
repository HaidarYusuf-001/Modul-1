<?php
session_start();
$users = require 'users.php'; // Mengambil data pengguna dari users.php

// Memeriksa apakah ada pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangani input dengan aman
    $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $password = isset($_POST['pass_word']) ? $_POST['pass_word'] : '';

    // Validasi pengguna
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            // Set session dan cookie
            $_SESSION['is_logged_in'] = true;
            $_SESSION['username'] = $username;

            // Set cookie untuk username selama 30 hari
            setcookie('saved_username', $username, time() + (86400 * 30), "/"); // 86400 = 1 hari

            // Redirect ke index.php
            header("Location: index.php");
            exit();
        }
    }
    echo "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>
<form action="login.php" method="post">
    <input type="text" name="user_name" placeholder="Username" value="" autocomplete="off">
    <input type="password" name="pass_word" placeholder="Password" value="" autocomplete="off">
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

</body>
</html>
