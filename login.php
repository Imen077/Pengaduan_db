<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Cek apakah pengguna ada di file
    $users = file('users.txt');
    foreach ($users as $user) {
        list($fileUser, $filePass) = explode('|', trim($user));
        if ($fileUser == $username && $filePass == $password) {
            $_SESSION['username'] = $username;
            header('Location: submit.php');
            exit;
        }
    }
    echo "<h1>Login gagal! Username atau password salah.</h1>";
} else {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Form Login</h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
<?php
}
?>