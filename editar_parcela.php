<?php
session_start();

// Establecer conexión con la base de datos directamente, sin require
$host = 'localhost';  // Cambia esto si es necesario
$dbname = 'mi_viñedo';  // Cambia esto por el nombre de tu base de datos
$username = 'root';  // Cambia esto por tu usuario de base de datos
$password = '';  // Cambia esto por tu contraseña de base de datos

// Crear una conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

include 'partials/navbar.php';  // Mantener la inclusión del navbar

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar que el ID de la parcela es válido
$parcela_id = $_GET['id'] ?? null;
if (!$parcela_id) {
    header("Location: gestion_parcelas.php");
    exit();
}

// Obtener los detalles de la parcela
$stmt = $pdo->prepare("SELECT * FROM parcelas WHERE id = ? AND usuario_id = ?");
$stmt->execute([$parcela_id, $usuario_id]);
$parcela = $stmt->fetch();

if (!$parcela) {
    // Si no se encuentra la parcela o no pertenece al usuario
    header("Location: gestion_parcelas.php");
    exit();
}

// Procesar la edición del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $tamano = $_POST['tamano'];
    $tipo_suelo = $_POST['tipo_suelo'];

    // Actualizar la parcela en la base de datos
    $stmt = $pdo->prepare("UPDATE parcelas SET nombre = ?, tamano = ?, tipo_suelo = ? WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$nombre, $tamano, $tipo_suelo, $parcela_id, $usuario_id]);

    // Redirigir con mensaje de éxito
    header("Location: gestion_parcelas.php?status=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Parcela - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2>Editar Parcela</h2>
    
    <!-- Mostrar mensaje de estado si existe -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">
            La parcela se ha actualizado con éxito.
        </div>
    <?php endif; ?>

    <form action="editar_parcela.php?id=<?= $parcela['id'] ?>" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Parcela</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($parcela['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="tamano" class="form-label">Tamaño (ha)</label>
            <input type="number" id="tamano" name="tamano" class="form-control" value="<?= htmlspecialchars($parcela['tamano']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="tipo_suelo" class="form-label">Tipo de Suelo</label>
            <input type="text" id="tipo_suelo" name="tipo_suelo" class="form-control" value="<?= htmlspecialchars($parcela['tipo_suelo']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
