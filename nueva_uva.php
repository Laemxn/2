<?php
session_start();
include 'partials/navbar.php'; // Incluir la barra de navegación

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $fecha_plantacion = $_POST['fecha_plantacion'];
    $cuidados = $_POST['cuidados'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar los datos de la nueva uva
    $stmt = $pdo->prepare("INSERT INTO uvas (nombre, fecha_plantacion, cuidados, usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $fecha_plantacion, $cuidados, $usuario_id]);

    // Redirigir a la página de gestión de uvas
    header("Location: gestion_uvas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nueva Uva - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Añadir Nueva Uva</h2>
        <form action="nueva_uva.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Uva</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="fecha_plantacion" class="form-label">Fecha de Plantación</label>
                <input type="date" class="form-control" id="fecha_plantacion" name="fecha_plantacion" required>
            </div>
            <div class="mb-3">
                <label for="cuidados" class="form-label">Cuidados</label>
                <textarea class="form-control" id="cuidados" name="cuidados" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Uva</button>
        </form>
    </div>
</body>
</html>
