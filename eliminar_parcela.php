<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $parcela_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Eliminar todas las cosechas asociadas a esta parcela
    $stmt = $pdo->prepare("DELETE FROM cosechas WHERE parcela_id = ? AND usuario_id = ?");
    $stmt->execute([$parcela_id, $usuario_id]);

    // Luego, eliminar la parcela
    $stmt = $pdo->prepare("DELETE FROM parcelas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$parcela_id, $usuario_id]);

    // Redirigir de vuelta a la página de gestión de parcelas
    header("Location: gestion_parcelas.php");
    exit();
} else {
    header("Location: gestion_parcelas.php");
    exit();
}
