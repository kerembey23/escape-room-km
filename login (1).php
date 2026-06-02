<?php
session_start();
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['username'];

        header("Location: index.php");
        exit();

    } else {
        $message = "Verkeerde gebruikersnaam of wachtwoord.";
    }
}
?>

<h2>Login</h2>

<form method="POST">
    Gebruikersnaam:<br>
    <input type="text" name="username" required><br><br>

    Wachtwoord:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p><?php echo $message; ?></p>

<p>Nog geen account? <a href="register.php">Registreren</a></p>