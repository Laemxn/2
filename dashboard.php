<?php
// Iniciar sesión y verificar si el usuario está autenticado
session_start();

// Si no existe la variable de sesión 'usuario_id', redirigir a login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/dashboardf.jpg');
            background-size: cover;
            background-position: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .navbar .nav-link {
            color: #333 !important;
        }
        .navbar .navbar-brand {
            color: #007aff;
        }
        .navbar-toggler-icon {
            background-color: #007aff;
        }

        .dashboard-container {
            text-align: center;
            width: 100%;
            max-width: 800px;
            padding: 2rem;
            margin-top: 80px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .dashboard-title {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #333;
        }
        .dashboard-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }
        .dashboard-option {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            background-color: #f8f9fa;
            text-decoration: none;
            color: #333;
            font-size: 1.1rem;
            font-weight: bold;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-option:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.2);
        }
        .dashboard-option i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #007aff;
        }
    </style>
</head>
<body>
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

    <div class="dashboard-container">
        <h1 class="dashboard-title">Bienvenido a Mi Viñedo Digital</h1>
        <div class="dashboard-options">
            <a href="perfil.php" class="dashboard-option">
                <i class="bi bi-person"></i>
                Perfil
            </a>
            <a href="gestion_cosechas.php" class="dashboard-option">
                <i class="bi bi-bar-chart"></i>
                Cosechas
            </a>
            <a href="gestion_parcelas.php" class="dashboard-option">
                <i class="bi bi-tree"></i>
                Parcelas
            </a>
            <a href="gestion_uvas.php" class="dashboard-option">
                <i class="bi bi-cup-straw"></i>
                Uvas
            </a>
            <a href="gestion_tratamientos.php" class="dashboard-option">
                <i class="bi bi-clipboard-check"></i>
                Tratamientos
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
