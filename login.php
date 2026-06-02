<?php
session_start();
require_once 'dbcon.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($userName) && !empty($password)) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $userName]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Controleren of gebruiker bestaat en wachtwoord klopt
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];

                // Doorsturen op basis van de Rol
                if ($user['is_admin'] == 1) {
                    header("Location: admin.php");
                } else {
                    header("Location: create_team.php");
                }
                exit();
            } else {
                $errorMessage = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>

    <form action="login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>