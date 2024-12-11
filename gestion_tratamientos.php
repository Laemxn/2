<?php
session_start();
include 'partials/navbar.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos (asegúrate de que la configuración esté correcta en otro archivo)
$pdo = new PDO('mysql:host=localhost;dbname=nombre_bd', 'usuario_bd', 'contraseña_bd');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener los tratamientos del usuario actual
$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT * FROM tratamientos WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$tratamientos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Tratamientos - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fondo de pantalla */
        body {
            background-image: url('images/tratamientos.jpg'); /* Ruta de la imagen */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Fija la imagen de fondo */
            margin: 0;
            padding: 0;
            height: 100vh; /* Asegura que el fondo cubra toda la altura */
        }

        /* Estilo adicional para el contenedor */
        .container {
            background-color: rgba(255, 255, 255, 0.85); /* Fondo blanco con algo de opacidad */
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Gestionar Tratamientos</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Fecha de Aplicación</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tratamientos as $tratamiento): ?>
                    <tr>
                        <td><?= htmlspecialchars($tratamiento['tipo']) ?></td>
                        <td><?= htmlspecialchars($tratamiento['fecha_aplicacion']) ?></td>
                        <td><?= htmlspecialchars($tratamiento['descripcion']) ?></td>
                        <td>
                            <!-- Enlace a editar tratamiento -->
                            <a href="editar_tratamiento.php?id=<?= $tratamiento['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                             <!-- Enlace a eliminar tratamiento -->
                            <a href="eliminar_tratamiento.php?id=<?= $tratamiento['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este tratamiento?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="nuevo_tratamiento.php" class="btn btn-primary">Añadir Tratamiento</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
