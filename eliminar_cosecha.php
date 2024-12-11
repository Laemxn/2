<?php
session_start();
require 'config/db.php';

// Verificar si el ID de la cosecha está presente en la URL
if (isset($_GET['id'])) {
    $cosecha_id = $_GET['id'];

    // Verificar si el usuario está logueado
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];

        // Eliminar la cosecha
        $stmt = $pdo->prepare("DELETE FROM cosechas WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$cosecha_id, $usuario_id]);

        // Redirigir de vuelta a la página de gestión de cosechas
        header("Location: gestion_cosechas.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir
    header("Location: gestion_cosechas.php");
    exit();
}
?>
