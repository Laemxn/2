<?php
session_start();
include 'partials/navbar.php'; // Incluimos la barra de navegación

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $tamano = $_POST['tamano'];
    $tipo_suelo = $_POST['tipo_suelo'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar los datos de la nueva parcela
    $stmt = $pdo->prepare("INSERT INTO parcelas (nombre, tamano, tipo_suelo, usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $tamano, $tipo_suelo, $usuario_id]);

    // Redirigir a la página de gestión de parcelas
    header("Location: gestion_parcelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nueva Parcela - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Añadir Nueva Parcela</h2>
        <form action="nueva_parcela.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Parcela</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="tamano" class="form-label">Tamaño (hectáreas)</label>
                <input type="number" step="0.01" class="form-control" id="tamano" name="tamano" required>
            </div>
            <div class="mb-3">
                <label for="tipo_suelo" class="form-label">Tipo de Suelo</label>
                <input type="text" class="form-control" id="tipo_suelo" name="tipo_suelo" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Parcela</button>
        </form>
    </div>
</body>
</html>
