<?php
require 'db.php';
// Busca en la base de datos
$busqueda = $_GET['busqueda'] ?? '';
$param = "%$busqueda%";

$stmt = $pdo->prepare("SELECT * FROM gastos 
WHERE nombre LIKE ? OR tipoGasto LIKE ? OR valorGasto LIKE ? ORDER BY codigoGasto DESC");
$stmt->execute([$param, $param, $param]); 

$gastos = $stmt->fetchAll();

$total = array_sum(array_column($gastos, 'valorGasto'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Gastos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="container py-4">
    <h1>Gastos Familiares</h1>
    <form class="mb-3" method="get">
        <div class="input-group">  
            <span class="input-group-text"> 
            <i class="bi bi-search"></i>
            </span>
            <input type="text" name="busqueda" class="form-control" placeholder="Busca por nombre, tipo o valor" value="<?= htmlspecialchars($busqueda) ?>">
            <button class="btn btn-success" type="submit">Buscar</button>
        </div>
    </form>

    <a href="agregar.php" class="btn btn-success mb-3">Agregar nuevo gasto</a>
   
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gastos as $g): ?>
                <tr>
                    <td><?= htmlspecialchars($g['nombre']) ?></td>
                    <td><?= htmlspecialchars($g['tipoGasto']) ?></td>
                    <td>L<?= number_format($g['valorGasto'], 2) ?></td>
                    <td>
                        <a href="editar.php?codigoGasto=<?= $g['codigoGasto'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="eliminar.php?codigoGasto=<?= $g['codigoGasto'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
 
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>L<?= number_format($total, 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <!-- Alerta de registro exitoso -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            title: "¡Registro exitoso!",
            text: "El gasto se ha guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar"
        });
    </script>
    <?php elseif (isset($_GET['editado']) && $_GET['editado'] == 1): ?>
    <!-- Alerta de edición exitosa -->
    <script>
        Swal.fire({
            title: "¡Edición exitosa!",
            text: "El gasto ha sido actualizado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar"
        });
    </script>
    <?php elseif (isset($_GET['borrado']) && $_GET['borrado'] == 1): ?>
    <!-- Alerta de eliminación exitosa -->
    <script>
        Swal.fire({
            title: "¡Gasto eliminado!",
            text: "El gasto ha sido eliminado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar"
        });
    </script>
    <?php endif; ?>
</body>
</html>
