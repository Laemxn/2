<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require 'conexion.php'; // Asegúrate de que este archivo contenga la conexión a la base de datos
include 'partials/navbar.php';

$usuario_id = $_SESSION['usuario_id'];

// Consultar los datos del usuario (nombre, correo, etc.)
$usuarioQuery = "SELECT nombre, correo, password FROM usuarios WHERE id = ?";
$usuarioStmt = $conn->prepare($usuarioQuery);
$usuarioStmt->bind_param("i", $usuario_id);
$usuarioStmt->execute();
$usuario = $usuarioStmt->get_result()->fetch_assoc(); // Obtener los datos del usuario

// Consultas para obtener los datos de cosechas, parcelas, uvas y tratamientos
$cosechasQuery = "SELECT GROUP_CONCAT(fecha ORDER BY fecha ASC) AS cosechas_fechas FROM cosechas WHERE usuario_id = ?";
$parcelasQuery = "SELECT GROUP_CONCAT(nombre ORDER BY nombre ASC) AS parcelas_nombres FROM parcelas WHERE usuario_id = ?";
$uvasQuery = "SELECT GROUP_CONCAT(nombre ORDER BY nombre ASC) AS uvas_nombres FROM uvas WHERE usuario_id = ?";
$tratamientosQuery = "SELECT GROUP_CONCAT(tipo ORDER BY tipo ASC) AS tratamientos_tipos FROM tratamientos WHERE usuario_id = ?";

// Ejecutar las consultas
$cosechasStmt = $conn->prepare($cosechasQuery);
$cosechasStmt->bind_param("i", $usuario_id);
$cosechasStmt->execute();
$cosechasResult = $cosechasStmt->get_result()->fetch_assoc();

$parcelasStmt = $conn->prepare($parcelasQuery);
$parcelasStmt->bind_param("i", $usuario_id);
$parcelasStmt->execute();
$parcelasResult = $parcelasStmt->get_result()->fetch_assoc();

$uvasStmt = $conn->prepare($uvasQuery);
$uvasStmt->bind_param("i", $usuario_id);
$uvasStmt->execute();
$uvasResult = $uvasStmt->get_result()->fetch_assoc();

$tratamientosStmt = $conn->prepare($tratamientosQuery);
$tratamientosStmt->bind_param("i", $usuario_id);
$tratamientosStmt->execute();
$tratamientosResult = $tratamientosStmt->get_result()->fetch_assoc();

// Si el formulario fue enviado, actualizamos o eliminamos el perfil del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $nueva_contrasena = $_POST['nueva_contrasena'];

        // Validar los datos
        if (!empty($nombre) && !empty($correo)) {
            // Actualizar nombre y correo
            $updateQuery = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ssi", $nombre, $correo, $usuario_id);
            $updateStmt->execute();
        }

        // Si la nueva contraseña no está vacía, actualizarla sin cifrar
        if (!empty($nueva_contrasena)) {
            $updatePasswordQuery = "UPDATE usuarios SET password = ? WHERE id = ?";
            $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
            $updatePasswordStmt->bind_param("si", $nueva_contrasena, $usuario_id);
            $updatePasswordStmt->execute();
        }

        // Redirigir al perfil después de actualizar
        header("Location: perfil.php");
        exit();
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar el perfil del usuario y sus datos relacionados
        $deleteUsuarioQuery = "DELETE FROM usuarios WHERE id = ?";
        $deleteUsuarioStmt = $conn->prepare($deleteUsuarioQuery);
        $deleteUsuarioStmt->bind_param("i", $usuario_id);
        $deleteUsuarioStmt->execute();

        // Eliminar los datos relacionados (cosechas, parcelas, uvas, tratamientos)
        $deleteCosechasQuery = "DELETE FROM cosechas WHERE usuario_id = ?";
        $deleteCosechasStmt = $conn->prepare($deleteCosechasQuery);
        $deleteCosechasStmt->bind_param("i", $usuario_id);
        $deleteCosechasStmt->execute();

        $deleteParcelasQuery = "DELETE FROM parcelas WHERE usuario_id = ?";
        $deleteParcelasStmt = $conn->prepare($deleteParcelasQuery);
        $deleteParcelasStmt->bind_param("i", $usuario_id);
        $deleteParcelasStmt->execute();

        $deleteUvasQuery = "DELETE FROM uvas WHERE usuario_id = ?";
        $deleteUvasStmt = $conn->prepare($deleteUvasQuery);
        $deleteUvasStmt->bind_param("i", $usuario_id);
        $deleteUvasStmt->execute();

        $deleteTratamientosQuery = "DELETE FROM tratamientos WHERE usuario_id = ?";
        $deleteTratamientosStmt = $conn->prepare($deleteTratamientosQuery);
        $deleteTratamientosStmt->bind_param("i", $usuario_id);
        $deleteTratamientosStmt->execute();

        // Cerrar sesión después de eliminar el perfil
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
        body {
            background-image: url('images/perfil.jpg'); /* Ruta de la imagen */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .profile-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .profile-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #007aff;
        }
        .summary-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            background-color: #f9f9f9;
            margin-bottom: 2rem;
        }
        .summary-card h3 {
            font-size: 1.5rem;
            margin: 0.5rem 0;
        }
        .summary-card p {
            font-size: 1rem;
            color: #555;
        }
        .form-container {
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1 class="profile-title">Perfil</h1>
        <p>Bienvenido, aquí tienes un resumen de tu actividad:</p>
        
        <!-- Mostrar Cosechas, Parcelas, Uvas y Tratamientos -->
        <div class="summary-card">
            <h3>Cosechas</h3>
            <?php
            if (!empty($cosechasResult['cosechas_fechas'])) {
                echo "<p>" . str_replace(",", "<br>", $cosechasResult['cosechas_fechas']) . "</p>";
            } else {
                echo "<p>No tienes cosechas registradas.</p>";
            }
            ?>
        </div>
        <div class="summary-card">
            <h3>Parcelas</h3>
            <?php
            if (!empty($parcelasResult['parcelas_nombres'])) {
                echo "<p>" . str_replace(",", "<br>", $parcelasResult['parcelas_nombres']) . "</p>";
            } else {
                echo "<p>No tienes parcelas registradas.</p>";
            }
            ?>
        </div>
        <div class="summary-card">
            <h3>Uvas</h3>
            <?php
            if (!empty($uvasResult['uvas_nombres'])) {
                echo "<p>" . str_replace(",", "<br>", $uvasResult['uvas_nombres']) . "</p>";
            } else {
                echo "<p>No tienes uvas registradas.</p>";
            }
            ?>
        </div>
        <div class="summary-card">
            <h3>Tratamientos</h3>
            <?php
            if (!empty($tratamientosResult['tratamientos_tipos'])) {
                echo "<p>" . str_replace(",", "<br>", $tratamientosResult['tratamientos_tipos']) . "</p>";
            } else {
                echo "<p>No tienes tratamientos registrados.</p>";
            }
            ?>
        </div>

        <!-- Formulario para cambiar nombre, correo y contraseña -->
        <div class="form-container">
            <h3>Actualizar Datos</h3>
            <form method="POST" action="perfil.php">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" placeholder="Ingresa la nueva contraseña">
                </div>
                <button type="submit" name="editar" class="btn btn-primary">Actualizar Datos</button>
                <button type="submit" name="eliminar" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu perfil? Esta acción no se puede deshacer.')">Eliminar Perfil</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
