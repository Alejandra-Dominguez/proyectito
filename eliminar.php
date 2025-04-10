<?php
session_start();
require 'db.php';

$codigoGasto = $_GET['codigoGasto'] ?? null;

if ($codigoGasto) {

    $stmt = $pdo->prepare("SELECT * FROM gastos WHERE codigoGasto = ?");
    $stmt->execute([$codigoGasto]);
    $gastoEliminado = $stmt->fetch();

    if ($gastoEliminado) {
       
        $stmt = $pdo->prepare("DELETE FROM gastos WHERE codigoGasto = ?");
        $stmt->execute([$codigoGasto]);


        
        header("Location: index.php?borrado=1&id_eliminado=" . urlencode($codigoGasto));
        exit;
    }
}

header("Location: index.php");
exit;
?>
