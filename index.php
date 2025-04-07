<?php
    require_once 'db.php';
    /*Busca en la base de datos*/
    $busqueda = $_GET['busqueda'] ?? '';
    $param = "%$busqueda%";
    
    $stmt = $pdo->prepare("SELECT * FROM gastos 
    WHERE nombre LIKE ? OR tipo LIKE ? OR valor LIKE ? OR fecha LIKE ? 
    ORDER BY fecha DESC");
    $stmt->execute([$param, $param, $param, $param]); 

    $gastos = $stmt->fetchAll();

    $total = array_sum(array_column($gastos, 'valor'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Gastos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Gastos Familiares</h1>
    <form class="mb-3" method="get">
        <div class="input-group">  
            <span class="input-group-text"> 
            <i class="bi bi-search"></i>
            </span>
            <input type="text" name="busqueda" class="form-control" placeholder="Busca por nombre, tipo, valor o fecha" value="<?= htmlspecialchars($busqueda) ?>">
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
            <th class="text-center">Fecha</th>
            <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gastos as $g): ?>

                <tr>
                    <td><?= htmlspecialchars($g['nombre']) ?></td>
                    <td><?= htmlspecialchars($g['tipo']) ?></td>
                    <td>L<?= number_format($g['valor'], 2) ?></td>
                    <td><?= htmlspecialchars($g['fecha']) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $g['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?= $g['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este gasto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
 
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th colspan="2">L<?= number_format($total, 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      title: "¡Registro exitoso!",
      text: "El gasto se ha guardado correctamente.",
      icon: "success",
      confirmButtonText: "Aceptar"
    });
    if (window.history.replaceState) {
      const url = new URL(window.location);
      url.searchParams.delete('success');
      window.history.replaceState({}, document.title, url.pathname + url.search);
    }
  </script>
<?php elseif (isset($_GET['editado']) && $_GET['editado'] == 1): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      title: "¡Edición exitosa!",
      text: "El gasto ha sido actualizado correctamente.",
      icon: "success",
      confirmButtonText: "Aceptar"
    });
    if (window.history.replaceState) {
      const url = new URL(window.location);
      url.searchParams.delete('editado');
      window.history.replaceState({}, document.title, url.pathname + url.search);
    }
  </script>
<?php endif; ?>
</body>
</html>

