<?php
session_start();
include 'partials/navbar.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require 'config/db.php'; // Mantengo el require para la conexión con la base de datos

$usuario_id = $_SESSION['usuario_id'];

// Modificar la consulta para hacer un JOIN con la tabla 'parcelas' y obtener el nombre de la parcela
$stmt = $pdo->prepare("
    SELECT cosechas.id, cosechas.fecha, cosechas.cantidad, parcelas.nombre AS parcela_nombre
    FROM cosechas
    JOIN parcelas ON cosechas.parcela_id = parcelas.id
    WHERE cosechas.usuario_id = ?
");
$stmt->execute([$usuario_id]);
$cosechas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cosechas - Mi Viñedo Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Gestionar Cosechas</h2>
        <a href="nueva_cosecha.php" class="btn btn-success mb-3">Añadir Nueva Cosecha</a>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <?php
                    if ($_GET['msg'] == 'success') {
                        echo 'La cosecha ha sido actualizada con éxito.';
                    } elseif ($_GET['msg'] == 'deleted') {
                        echo 'La cosecha ha sido eliminada con éxito.';
                    }
                ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cantidad (kg)</th>
                    <th>Parcela</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cosechas as $cosecha): ?>
                    <tr>
                        <td><?= htmlspecialchars($cosecha['fecha']) ?></td>
                        <td><?= htmlspecialchars($cosecha['cantidad']) ?></td>
                        <td><?= htmlspecialchars($cosecha['parcela_nombre']) ?></td>
                        <td>
                            <a href="editar_cosecha.php?id=<?= $cosecha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_cosecha.php?id=<?= $cosecha['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta cosecha?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
