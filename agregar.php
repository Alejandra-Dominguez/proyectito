<?php
 require 'db.php';

 /*En caso de errores en el formulario*/
 $errores = [];

 /**Verificacion por metodo post*/
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $fecha = $_POST['fecha'] ?? '';

    /**Validaciones  */
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($tipo)) $errores[] = "El tipo de gasto es obligatorio.";
    if (!is_numeric($valor) || $valor <= 0) $errores[] = "El valor debe ser un número positivo.";

    /**Si no hay errores, inserta los datos en bd */
    if (empty($errores)) {
        $stmt = $pdo->prepare("INSERT INTO gastos (nombre, tipo, valor, fecha) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $tipo, $valor, $fecha]);
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos y efecto -->
    <style>
        .card-hover {
            transition: all 0.3s ease-in-out;
        }

        .card-hover:hover {
            transform: scale(1.02);
            box-shadow: 0 0.8rem 2rem rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
        }
    </style>

</head>
<body class="bg-light py-5">
    
<div class="container">
        <h1 class="text-center mb-4">Registrar Gasto</h1>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $e) echo "<li>$e</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card card-hover shadow rounded-4 border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <form method="post">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre de la persona</label>
                        <input type="text" name="nombre" class="form-control form-control-lg rounded-3">
                    </div>

                    <!-- Tipo -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo de gasto</label>
                        <select name="tipo" class="form-select form-select-lg rounded-3">
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
                    <form method="post">
                    
                        <div class="mb-3">
                            <label>Valor</label>
                            <input type="number" name="valor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-lg px-4">Registrar</button>
                            <a href="index.php" class="btn btn-outline-secondary btn-lg px-4">Volver</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</body>
</html>  
    