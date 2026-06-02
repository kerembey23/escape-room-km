<?php
// config/dbcon.php
$server = "localhost"; 
$username = "root";
$password = "";
$db = "prison_escape"; // Aangepast naar jouw gevangenis database

try {
  // $pdo gebruikt in plaats van $conn zodat het matcht met de rest van je scripts
  $pdo = new PDO("mysql:host=$server;dbname=$db", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Verbinding mislukt: " . $e->getMessage();
}
?>