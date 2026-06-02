<?php
session_start();
require_once 'dbcon.php';

// Controleren of de gebruiker is ingelogd (gebouwd door Student B)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamName = trim($_POST['team_name']);
    $teamMembers = trim($_POST['team_members']);

    if (!empty($teamName) && !empty($teamMembers)) {
        try {
            $query = "INSERT INTO teams (team_name, team_members) VALUES (:team_name, :team_members)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'team_name' => $teamName,
                'team_members' => $teamMembers
            ]);

            // Sla de teamnaam op in de sessie zoals gevraagd!
            $_SESSION['team_name'] = $teamName;
            $_SESSION['team_id'] = $conn->lastInsertId();

            // Start het spel en ga naar kamer 1
            header("Location: room.php?room=1");
            exit();
        } catch (PDOException $e) {
            $errorMessage = "Error creating team: " . $e->getMessage();
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
    <title>Create Team</title>
</head>
<body>
    <h2>Create Your Escape Team</h2>
    <?php if(!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>

    <form action="create_team.php" method="POST">
        <label>Team Name:</label>
        <input type="text" name="team_name" required><br><br>
        
        <label>Names of Team Members (comma separated):</label><br>
        <textarea name="team_members" rows="4" cols="30" placeholder="John, Jane, Bob" required></textarea><br><br>
        
        <button type="submit">Start Escape Room</button>
    </form>
</body>
</html>