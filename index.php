<?php
    require 'db.php';
    /*busca en la base de datos*/
    $busqueda = $_GET['busqueda'] ?? '';
    $param = "%busqueda%";
    
    $stmt = $pdo->prepare("SELECT * FROM gastos WHERE nombre LIKE ? or tipo LIKE ? ORDER BY fecha DESC");
    $stmt ->execute([$param, $param]);
    $gastos = $stmt->fetchAll();

    $total = array_sum(array_colum($gastos, 'valor'));

?>

