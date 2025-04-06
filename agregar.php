<?php
 require 'db.php';

 /*En caso de errores en el formulario*/
 $errores = [];

 /**Verificacion por metodo post*/
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $valor = $_POST['valor'] ?? '';

    /**Validaciones  */
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($tipo)) $errores[] = "El tipo de gasto es obligatorio.";
    if (!is_numeric($valor) || $valor <= 0) $errores[] = "El valor debe ser un número positivo.";

    /**Si no hay errores, inserta los datos en bd */
    if (empty($errores)) {
        $stmt = $pdo->prepare("INSERT INTO gastos (nombre, tipo, valor) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $tipo, $valor]);
        header("Location: index.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Gasto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Registrar Gasto</h1>
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $e) echo "<li>$e</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <div class="mb-3">
            <label>Nombre de la persona</label>
            <input type="text" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label>Tipo de gasto</label>
            <select name="tipo" class="form-control">
                <option value="">Selecciona uno</option>
                <option value="Alimentación">Alimentación</option>
                <option value="Transporte">Transporte</option>
                <option value="Salud">Salud</option>
                <option value="Entretenimiento">Entretenimiento</option>
                <option value="Impuestos">Impuestos</option>
                <option value="Viajes">Viajes</option>
                <option value="Educación">Educación</option>
                <option value="Otros">Otros</option>
            </select>
        </div>