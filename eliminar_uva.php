<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $uva_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Eliminar el tipo de uva si pertenece al usuario autenticado
    $stmt = $pdo->prepare("DELETE FROM uvas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$uva_id, $usuario_id]);

    // Redirigir de vuelta a la página de gestión de uvas después de eliminar
    header("Location: gestion_uvas.php");
    exit();
} else {
    // Redirigir si no se proporciona un ID válido
    header("Location: gestion_uvas.php");
    exit();
}
