<?php
require_once 'dbcon.php';

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($userName) && !empty($password)) {
        // Wachtwoord beveiligen (hash)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Controleren of de gebruikersnaam al bestaat
            $query = "SELECT id FROM users WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $userName]);

            if ($stmt->rowCount() > 0) {
                $errorMessage = "Username already exists.";
            } else {
                // Gebruiker opslaan (standaard is_admin = 0)
                $insertQuery = "INSERT INTO users (username, password, is_admin) VALUES (:username, :password, 0)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->execute([
                    'username' => $userName,
                    'password' => $hashedPassword
                ]);
                $successMessage = "Account created successfully! You can now log in.";
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
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Register Account</h2>
    <?php if(!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
    <?php if(!empty($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    
    <form action="register.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in here</a>.</p>
</body>
</html>