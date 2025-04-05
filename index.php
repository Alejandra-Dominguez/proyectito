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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Gastos Familiares</h1>
    <form class="mb-3" method="get">
        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre o tipo" value="<?= htmlspecialchars($busqueda) ?>">
    </form>
    <a href="agregar.php" class="btn btn-success mb-3">Agregar nuevo gasto</a>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Gasto registrado exitosamente.</div>
    <?php endif; ?>

