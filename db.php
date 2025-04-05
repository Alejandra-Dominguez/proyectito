<?php
$host = 'localhost';
$db   = 'gastos_familiares';
$user = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";


try {
    $pdo = new PDO($dsn, $user);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

