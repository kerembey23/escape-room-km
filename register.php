<?php
session_start();
// Zorg dat dbcon.php in dezelfde map staat!
require_once 'dbcon.php';

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($userName) && !empty($password)) {
        try {
            // 1. Controleren of de gebruikersnaam al bestaat
            $checkQuery = "SELECT id FROM users WHERE username = :username";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->execute(['username' => $userName]);

            if ($checkStmt->rowCount() > 0) {
                $errorMessage = "This username is already taken. Try another one!";
            } else {
                // 2. Wachtwoord veilig hashen volgens de moderne PHP-standaard
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // 3. Gebruiker opslaan in de 'users' tabel (is_admin is standaard 0 voor spelers)
                $insertQuery = "INSERT INTO users (username, password, is_admin) VALUES (:username, :password, 0)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->execute([
                    'username' => $userName,
                    'password' => $hashedPassword
                ]);

                $successMessage = "Account created successfully! You can now log in.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Database error: " . $e->getMessage();
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
    <title>Prison Break - Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-bg">
    <div class="welcome-container">
        <h2>📝 CREATE ACCOUNT</h2>
        <p class="intro-text">Sign up to start your escape adventure.</p>

        <!-- Toon een rode foutmelding als er iets misgaat -->
        <?php if (!empty($errorMessage)): ?>
            <p style="color: #d9381e; font-weight: bold; margin-bottom: 20px;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <!-- Toon een groene melding als het registreren is gelukt -->
        <?php if (!empty($successMessage)): ?>
            <p style="color: #00ff00; font-weight: bold; margin-bottom: 20px;"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div style="text-align: left; margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Username:</label>
                <input type="text" name="username" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: #fff; box-sizing: border-box; border-radius: 4px;">
            </div>

            <div style="text-align: left; margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px;">Password:</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: #fff; box-sizing: border-box; border-radius: 4px;">
            </div>

            <button type="submit" class="btn btn-orange">REGISTER</button>
        </form>

        <p style="margin-top: 20px; font-family: sans-serif; font-size: 0.9rem;">
            Already have an account? <a href="login.php" style="color: #ff6600; text-decoration: none; font-weight: bold;">Login here</a>.
        </p>
    </div>
</body>
</html>