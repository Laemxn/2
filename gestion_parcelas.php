<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conexión con la base de datos (asegúrate de que el archivo `db.php` esté correctamente incluido antes en otro archivo)
$pdo = new PDO('mysql:host=localhost;dbname=nombre_bd', 'usuario_bd', 'contraseña_bd');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta para obtener las parcelas del usuario
$stmt = $pdo->prepare("SELECT * FROM parcelas WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$parcelas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Parcelas - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo de fondo de pantalla */
        body {
            background-image: url('images/parcelas.jpg'); /* Ruta de la imagen */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Fija la imagen de fondo */
            margin: 0;
            padding: 0;
            height: 100vh; /* Asegura que el fondo cubra toda la altura */
        }

        /* Estilo adicional para el contenedor */
        .container {
            background-color: rgba(255, 255, 255, 0.85); /* Fondo blanco con algo de opacidad para legibilidad */
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    
    <div class="container my-5">
        <h2>Gestionar Parcelas</h2>
        <a href="nueva_parcela.php" class="btn btn-success mb-3">Añadir Nueva Parcela</a>

        <!-- Tabla que muestra las parcelas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tamaño (ha)</th>
                    <th>Tipo de Suelo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcelas as $parcela): ?>
                    <tr>
                        <td><?= htmlspecialchars($parcela['nombre']) ?></td>
                        <td><?= htmlspecialchars($parcela['tamano']) ?></td>
                        <td><?= htmlspecialchars($parcela['tipo_suelo']) ?></td>
                        <td>
                            <a href="editar_parcela.php?id=<?= $parcela['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_parcela.php?id=<?= $parcela['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta parcela?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
