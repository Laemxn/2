<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Mi Viñedo Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para el formulario */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/login.jpg'); /* Ruta de la imagen de fondo */
            background-size: cover;
            background-position: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con opacidad */
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); /* Sombra suave */
            text-align: center;
        }

        .login-container h2 {
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: #333; /* Color de texto */
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
            background-color: #f7f7f7; /* Fondo gris suave */
            border: 1px solid #ddd; /* Borde gris claro */
            color: #333; /* Color de texto */
        }

        .form-control:focus {
            border-color: #5eafc3; /* Color de borde al hacer focus */
            box-shadow: 0 0 8px rgba(94, 175, 195, 0.5); /* Sombra suave al hacer focus */
        }

        .btn-primary {
            background-color: #5eafc3; /* Color verde suave */
            border-color: #5eafc3;
            border-radius: 8px;
            height: 45px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #479a8a; /* Color al pasar el mouse */
            border-color: #479a8a;
        }

        .form-text {
            color: #888;
            font-size: 0.9rem;
        }

        /* Estilos para enlaces */
        .form-text a {
            color: #5eafc3;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="login_process.php" method="POST">
        <div class="mb-3">
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        <small class="form-text mt-3">¿Olvidaste tu contraseña? <a href="#">Recuperar</a></small>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
