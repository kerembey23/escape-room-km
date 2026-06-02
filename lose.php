<?php
session_start();
$teamName = isset($_SESSION['team_name']) ? $_SESSION['team_name'] : "Onbekend Team";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prison Break - Game Over</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="end-bg">
    <div class="header-banner">
        <span class="logo">⛓️ PRISON BREAK <small>ESCAPE ROOM</small></span>
        <span class="team-top">TEAM: <?php echo htmlspecialchars($teamName); ?></span>
    </div>

    <div class="end-container lose-theme">
        <h1 class="main-title text-red">HET IS MISLUKT!<br>DE TIJD IS OM...</h1>
        <div class="lock-icon">🔒</div>
        <p class="sub-text">Helaas is de tijd afgelopen voordat jullie konden ontsnappen uit de gevangenis.</p>
        
        <div class="stats-box">
            <div class="stat-item">
                <span class="icon">⏱️</span>
                <div>
                    <small>TOTALE TIJD</small>
                    <strong>30:00</strong>
                </div>
            </div>
            <div class="stat-item">
                <span class="icon">👥</span>
                <div>
                    <small>TEAM</small>
                    <strong><?php echo htmlspecialchars($teamName); ?></strong>
                </div>
            </div>
            <div class="scoreboard-notice hint-notice">
                💡 TIP: PROBEER SAMEN TE WERKEN EN DENK AAN ALLE HINTS!
            </div>
        </div>

        <a href="index.php" class="btn btn-orange">🏠 TERUG NAAR HOME</a>
        <a href="create_team.php" class="btn btn-outline">🔄 OPNIEUW SPELEN</a>
    </div>
</body>
</html>