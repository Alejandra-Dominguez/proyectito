<?php
session_start();
require 'db.php';

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = ?");
    $stmt->execute([$id]);
    $gastoEliminado = $stmt->fetch();

    if ($gastoEliminado) {
       
        $stmt = $pdo->prepare("DELETE FROM gastos WHERE id = ?");
        $stmt->execute([$id]);

        
        header("Location: index.php?borrado=1&id_eliminado=" . urlencode($id));
        exit;
    }
}

header("Location: index.php");
exit;
?>
