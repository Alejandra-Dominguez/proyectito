<?php
$host = "localhost";
$db = "base"; 
$usuario = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$db", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
