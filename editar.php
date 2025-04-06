<?php
 require 'db.php';
 /*Validaciones usando el ID*/ 
 $id = $_GET['id'] ?? null;
 if (!$id) die("ID inválido");

$stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = ?");
$stmt->execute([$id]);
$gasto = $stmt->fetch();

if (!$gasto) die("Gasto no encontrado");

/*Confirma la acción del usuario y toma los datos del formulario*/ 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $valor = $_POST['valor'] ?? 0;

    if ($nombre && $tipo && is_numeric($valor) && $valor > 0) {
        $stmt = $pdo->prepare("UPDATE gastos SET nombre = ?, tipo = ?, valor = ? WHERE id = ?");
        /**sustituye los ? por los valores reales */
        $stmt->execute([$nombre, $tipo, $valor, $id]);
        /**redirecciona al usuario a index.php */
        header("Location: index.php?editado=1");
        exit;
    } else {
        echo "Datos inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Gasto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Editar Gasto</h1>
    <form method="post">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($gasto['nombre']) ?>">
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($gasto['tipo']) ?>">
        </div>
        <div class="mb-3">
            <label>Valor</label>
            <input type="number" step="0.01" name="valor" class="form-control" value="<?= $gasto['valor'] ?>">
        </div>
        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>