<?php
session_start();
include 'partials/navbar.php'; // Incluimos la barra de navegación

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $parcela_id = $_POST['parcela_id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar que todos los campos necesarios estén completos
    if (!empty($fecha) && !empty($cantidad) && !empty($parcela_id)) {
        // Insertar la nueva cosecha en la base de datos
        $stmt = $pdo->prepare("INSERT INTO cosechas (fecha, cantidad, parcela_id, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fecha, $cantidad, $parcela_id, $usuario_id]);

        // Redirigir de vuelta a la página de gestión de cosechas
        header("Location: gestion_cosechas.php");
        exit();
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nueva Cosecha - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Añadir Nueva Cosecha</h2>

        <!-- Mostrar mensaje de error si falta algún campo -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="nueva_cosecha.php" method="POST">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de la Cosecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad (kg)</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="mb-3">
                <label for="parcela_id" class="form-label">Parcela</label>
                <select class="form-control" id="parcela_id" name="parcela_id" required>
                    <?php
                    // Obtener la lista de parcelas del usuario actual para seleccionar
                    $stmt = $pdo->prepare("SELECT id, nombre FROM parcelas WHERE usuario_id = ?");
                    $stmt->execute([$_SESSION['usuario_id']]);
                    $parcelas = $stmt->fetchAll();
                    foreach ($parcelas as $parcela) {
                        echo "<option value='{$parcela['id']}'>{$parcela['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cosecha</button>
        </form>
    </div>
</body>
</html>
