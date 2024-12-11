<?php
session_start();

// Establecer conexión con la base de datos directamente, sin require_once
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

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $cosecha_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM cosechas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$cosecha_id, $_SESSION['usuario_id']]);
    $cosecha = $stmt->fetch();

    if (!$cosecha) {
        die("Cosecha no encontrada.");
    }
} else {
    die("ID no proporcionado.");
}

// Obtener todas las parcelas disponibles para el select
$stmt = $pdo->prepare("SELECT * FROM parcelas WHERE usuario_id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$parcelas = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $parcela_id = $_POST['parcela_id'];

    // Comprobar si la parcela existe en la base de datos antes de actualizar
    $stmt = $pdo->prepare("SELECT * FROM parcelas WHERE id = ?");
    $stmt->execute([$parcela_id]);
    $parcela = $stmt->fetch();

    if (!$parcela) {
        die("La parcela seleccionada no existe.");
    }

    // Actualizar la cosecha
    $stmt = $pdo->prepare("UPDATE cosechas SET fecha = ?, cantidad = ?, parcela_id = ? WHERE id = ?");
    $stmt->execute([$fecha, $cantidad, $parcela_id, $cosecha_id]);

    // Redirigir a la página de gestión de cosechas después de la actualización
    header("Location: gestion_cosechas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cosecha - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar incluido sin el archivo 'navbar.php' -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Viñedo Digital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2>Editar Cosecha</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= htmlspecialchars($cosecha['fecha']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad (kg)</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($cosecha['cantidad']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="parcela_id" class="form-label">Parcela</label>
                <select class="form-control" id="parcela_id" name="parcela_id" required>
                    <?php foreach ($parcelas as $parcela): ?>
                        <option value="<?= $parcela['id'] ?>" <?= $cosecha['parcela_id'] == $parcela['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($parcela['nombre']) ?> <!-- Suponiendo que 'nombre' es el campo de la parcela -->
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Cosecha</button>
        </form>
        <a href="gestion_cosechas.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
