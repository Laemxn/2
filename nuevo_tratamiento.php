<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php'; // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $tipo = $_POST['tipo'];
    $fecha_aplicacion = $_POST['fecha_aplicacion'];
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_SESSION['usuario_id'];

    // Validación básica
    if (!empty($tipo) && !empty($fecha_aplicacion)) {
        // Insertar el tratamiento en la base de datos
        $stmt = $pdo->prepare("INSERT INTO tratamientos (tipo, fecha_aplicacion, descripcion, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$tipo, $fecha_aplicacion, $descripcion, $usuario_id]);

        // Redirigir a la página de gestión de tratamientos
        header("Location: gestion_tratamientos.php");
        exit();
    } else {
        $error = "Por favor, completa todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Tratamiento - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Añadir Nuevo Tratamiento</h2>

        <!-- Mostrar mensaje de error si hay algún problema -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="nuevo_tratamiento.php" method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Tratamiento</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3">
                <label for="fecha_aplicacion" class="form-label">Fecha de Aplicación</label>
                <input type="date" class="form-control" id="fecha_aplicacion" name="fecha_aplicacion" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Tratamiento</button>
            <a href="gestion_tratamientos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
