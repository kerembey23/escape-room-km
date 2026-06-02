<?php
session_start();
require_once 'dbcon.php';

$teamName = isset($_SESSION['team_name']) ? $_SESSION['team_name'] : "Onbekend Team";
$finalTime = "00:00";

if (isset($_SESSION['team_id'])) {
    $stmt = $conn->prepare("SELECT final_time FROM teams WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['team_id']]);
    $finalTime = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prison Break - Escape Succesful!</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="end-bg">
    <div class="header-banner">
        <span class="logo">⛓️ PRISON BREAK <small>ESCAPE ROOM</small></span>
        <span class="team-top">TEAM: <?php echo htmlspecialchars($teamName); ?></span>
    </div>

    <div class="end-container win-theme">
        <h1 class="main-title text-orange">GEFELICITEERD!<br>JULLIE ZIJN ONTSNAPT!</h1>
        <div class="lock-icon">🔓</div>
        <p class="sub-text">Jullie hebben alle puzzels opgelost en zijn succesvol ontsnapt uit de gevangenis!</p>
        
        <div class="stats-box">
            <div class="stat-item">
                <span class="icon">⏱️</span>
                <div>
                    <small>TOTALE TIJD</small>
                    <strong><?php echo htmlspecialchars($finalTime); ?></strong>
                </div>
            </div>
            <div class="stat-item">
                <span class="icon">👥</span>
                <div>
                    <small>TEAM</small>
                    <strong><?php echo htmlspecialchars($teamName); ?></strong>
                </div>
            </div>
            <div class="scoreboard-notice">
                🏆 JULLIE STAAN NU OP HET SCOREBOARD!
            </div>
        </div>

        <a href="index.php" class="btn btn-orange">🏠 TERUG NAAR HOME</a>
        <a href="create_team.php" class="btn btn-outline">🔄 OPNIEUW SPELEN</a>
    </div>
</body>
</html>