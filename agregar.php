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