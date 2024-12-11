<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para el formulario */
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

        {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f7; /* Fondo claro */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333;
        }
        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
            text-align: center;
        }
        .register-container h2 {
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: #007aff; /* Color estilo macOS */
        }
        .form-control {
            border-radius: 8px;
            height: 45px;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #007aff; /* Color macOS */
            border-color: #007aff;
            border-radius: 8px;
            height: 45px;
            font-weight: bold;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #005bb5;
            border-color: #005bb5;
        }
        .form-text {
            color: #888;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Crear Cuenta</h2>
    <form action="register_process.php" method="POST">
        <div class="mb-3">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" required>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <small class="form-text mt-3">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></small>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

