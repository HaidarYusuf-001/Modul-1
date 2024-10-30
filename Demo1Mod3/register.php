<?php

function loadUsers() {
    return include 'users.php';
}

function saveUser($newUser) {
    $users = loadUsers();
    $users[] = $newUser;
    file_put_contents('users.php', '<?php return ' . var_export($users, true) . ';');
}

function register($username, $password) {
    $users = loadUsers();

    // Cek apakah username sudah ada
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "Username sudah digunakan!";
            return;
        }
    }

    // Hash password baru dan simpan pengguna
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    saveUser(['username' => $username, 'password' => $hashedPassword]);
    echo "Registrasi berhasil! <a href='index.php'>Kembali ke login</a>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    register($_POST['username'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register Pengguna Baru</h1>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
