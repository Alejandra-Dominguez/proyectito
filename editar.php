<?php
 require 'db.php';
 /*Validaciones usando el ID*/ 
 $id = $_GET['id'] ?? null;
 if (!$id) die("ID inválido");

$stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = ?");
$stmt->execute([$id]);
$gasto = $stmt->fetch();

if (!$gasto) die("Gasto no encontrado");

 ?>