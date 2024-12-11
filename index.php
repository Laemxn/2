<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para una apariencia tipo macOS */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/index.jpg'); /* Ruta de la imagen de fondo */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Fija la imagen de fondo */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333;
        }
        .container {
            text-align: center;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo semitransparente para la caja */
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: #007aff; /* Color inspirado en macOS */
        }
        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 2rem;
        }
        .btn-primary, .btn-outline-primary {
            width: 200px;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007aff;
            border-color: #007aff;
        }
        .btn-primary:hover {
            background-color: #005bb5;
            border-color: #005bb5;
        }
        .btn-outline-primary {
            color: #007aff;
            border-color: #007aff;
        }
        .btn-outline-primary:hover {
            color: #005bb5;
            border-color: #005bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a Mi Viñedo Digital</h1>
        <p>Gestione y optimice su viñedo de una forma fácil y elegante.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
            <a href="register.php" class="btn btn-outline-primary">Registrarse</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
