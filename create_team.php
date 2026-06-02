<?php
session_start();
require_once 'dbcon.php';

// Beveiliging: Als de speler niet is ingelogd, sturen we hem terug naar login
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

            $_SESSION['team_name'] = $teamName;
            $_SESSION['team_id'] = $conn->lastInsertId();

            // OMDAT ER NOG GEEN ESCAPE ROOM IS IN SPRINT 1:
            // Sturen we het team voor nu direct door naar het win-scherm om te demonstreren!
            header("Location: win.php");
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
    <title>Prison Break - Create Team</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-bg">
    <div class="welcome-container">
        <h2>👥 CREATE YOUR TEAM</h2>
        <p class="intro-text">Assemble your crew before attempting the prison break.</p>

        <?php if (!empty($errorMessage)): ?>
            <p style="color: #d9381e; font-weight: bold; margin-bottom: 20px;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form action="create_team.php" method="POST">
            <div style="text-align: left; margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Team Name:</label>
                <input type="text" name="team_name" placeholder="e.g., Oranje Leeuwen" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: #fff; box-sizing: border-box; border-radius: 4px;">
            </div>

            <div style="text-align: left; margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px;">Team Members:</label>
                <input type="text" name="team_members" placeholder="e.g., John, Jane, Sam" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: #fff; box-sizing: border-box; border-radius: 4px;">
            </div>

            <button type="submit" class="btn btn-orange">START (DEMO WIN-PAGINA)</button>
        </form>

        <!-- ========================================== -->
        <!-- TIJDELIJK TEST PANEL VOOR DE DOCENT (SPRINT 1) -->
        <!-- ========================================== -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px dashed #ff6600;">
            <p style="color: #ff6600; font-size: 0.85rem; margin-bottom: 10px;">🛠️ SPRINT 1 BEORDELINGSPANEEL (VOOR DOCENT)</p>
            <a href="win.php" class="btn btn-secondary" style="font-size: 0.8rem; padding: 8px; margin-bottom: 5px;">Bekijk Winpagina direct</a>
            <a href="lose.php" class="btn btn-secondary" style="font-size: 0.8rem; padding: 8px; background-color: #3a1111;">Bekijk Verliespagina direct</a>
        </div>
        <!-- ========================================== -->

    </div>
</body>
</html>