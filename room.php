<?php
session_start();
require_once 'dbcon.php';

// Controleren of er een team is aangemaakt
if (!isset($_SESSION['team_name'])) {
    header("Location: create_team.php");
    exit();
}

// Bepaal in welke kamer de speler zit (standaard kamer 1)
$currentRoom = isset($_GET['room']) ? (int)$_GET['room'] : 1;

// Haal de vragen op voor deze specifieke kamer
$query = "SELECT * FROM questions WHERE room_id = :room_id";
$stmt = $conn->prepare($query);
$stmt->execute(['room_id' => $currentRoom]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room <?php echo $currentRoom; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/timer.js" defer></script>
</head>
<body>
    <header>
        <h3>Active Team: <?php echo htmlspecialchars($_SESSION['team_name']); ?></h3>
        <div id="timerDisplay">Time Left: <span id="timer">15:00</span></div>
    </header>

    <h2>Welcome to Room <?php echo $currentRoom; ?></h2>

    <form action="check_answers.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $currentRoom; ?>">
        
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-block">
                <p><strong>Question <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($q['question']); ?></p>
                <input type="text" name="answers[<?php echo $q['id']; ?>]" required>
                <p><small><em>Hint: <?php echo htmlspecialchars($q['hint']); ?></em></small></p>
            </div>
            <hr>
        <?php endforeach; ?>

        <button type="submit">Submit Answers</button>
    </form>
</body>
</html>