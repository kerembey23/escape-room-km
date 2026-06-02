<?php
session_start();
require_once 'dbcon.php';

// Alleen opslaan als er een actieve teamsessie is
if (isset($_SESSION['team_id']) && isset($_POST['final_time'])) {
    $teamId = $_SESSION['team_id'];
    $finalTime = $_POST['final_time'];

    try {
        $query = "UPDATE teams SET final_time = :final_time WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            'final_time' => $finalTime,
            'id' => $teamId
        ]);
        echo "Success";
    } catch (PDOException $e) {
        echo "Error saving time: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>