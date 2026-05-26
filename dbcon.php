<?php
$server = "localhost"; 
$username = "root";
$password = "";
$db = "escape-room-km";

try {
  $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Verbinding mislukt: " . $e->getMessage();
}