<?php
session_start();

// Beveiliging: als je niet bent ingelogd, mag je de regels niet lezen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prison Break - Rules</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-bg">
    <div class="welcome-container" style="max-width: 600px;">
        <h2>📋 SPELREGELS & INSTRUCTIES</h2>
        <p class="intro-text">Lees dit goed door voordat je de bewakers probeert te slim af te zijn!</p>

        <div style="text-align: left; background: #141414; border: 1px solid #282828; padding: 20px; border-radius: 8px; margin-bottom: 25px; font-family: sans-serif; font-size: 0.95rem; line-height: 1.6; color: #ccc;">
            <p><strong>1. Het Doel:</strong> Je zit opgesloten in een zwaar beveiligde gevangenis. Je moet door 3 kamers heen zien te breken: De Cel, Het Kantoor en De Ontsnappingstunnel.</p>
            <p><strong>2. De Tijd:</strong> Je krijgt exact <strong>30 minuten (30:00)</strong> de tijd om te ontsnappen. Zodra je begint loopt de timer. Is de tijd om? Dan word je gepakt (Game Over).</p>
            <p><strong>3. De Puzzels:</strong> Elke kamer bevat een aantal vragen. Je kunt pas naar de volgende kamer als álle antwoorden in je huidige kamer goed zijn.</p>
            <p><strong>4. Hints:</strong> Zit je vast? Bij elke vraag staat een kleine hint. Gebruik deze goed met je team!</p>
            <p><strong>5. Teamwork:</strong> Op de volgende pagina maak je een team aan. Werk goed samen om de snelste tijd op het scorebord neer te zetten!</p>
        </div>

        <a href="create_team.php" class="btn btn-orange">IK SNAP HET, START HET SPEL!</a>
    </div>
</body>
</html>