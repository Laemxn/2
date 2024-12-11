<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $tratamiento_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Eliminar el tratamiento de la base de datos
    $stmt = $pdo->prepare("DELETE FROM tratamientos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$tratamiento_id, $usuario_id]);

    // Redirigir de vuelta a la página de gestión de tratamientos
    header("Location: gestion_tratamientos.php");
    exit();
} else {
    header("Location: gestion_tratamientos.php");
    exit();
}
?>
