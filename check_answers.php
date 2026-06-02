<?php
session_start();
require_once 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $currentRoom = (int)$_POST['room_id'];
    $userAnswers = $_POST['answers']; // Array van [question_id => user_answer]
    
    $allCorrect = true;

    foreach ($userAnswers as $questionId => $answer) {
        $query = "SELECT answer FROM questions WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute(['id' => $questionId]);
        $correctAnswer = $stmt->fetchColumn();

        // Controleren zonder te letten op hoofdletters
        if (strtolower(trim($answer)) !== strtolower(trim($correctAnswer))) {
            $allCorrect = false;
            break;
        }
    }

    if ($allCorrect) {
        if ($currentRoom < 3) {
            // Ga naar de volgende kamer
            $nextRoom = $currentRoom + 1;
            header("Location: room.php?room=$nextRoom");
        } else {
            // Gefeliciteerd! Kamer 3 is voltooid. Sla op als gewonnen
            // We sturen de speler naar een tussenscherm die de JavaScript 'teamEscaped()' triggert
            $_SESSION['game_status'] = 'won';
            header("Location: finish.php");
        }
    } else {
        // Fout antwoord? Terug sturen met een melding
        header("Location: room.php?room=$currentRoom&error=1");
    }
    exit();
}