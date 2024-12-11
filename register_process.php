<?php
// Inicia una sesión
session_start();

// Conexión a la base de datos
require 'config/db.php'; // Asegúrate de que este archivo exista y esté configurado correctamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Validar que todos los campos estén llenos
    if (empty($nombre) || empty($correo) || empty($password)) {
        echo "<script>alert('Por favor, completa todos los campos.'); window.location.href = 'register.php';</script>";
        exit();
    }

    // Verificar si el correo ya está registrado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    if ($stmt->fetch()) {
        echo "<script>alert('El correo ya está registrado.'); window.location.href = 'register.php';</script>";
        exit();
    }

    // Insertar el nuevo usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $correo, $password]); // Si deseas usar contraseñas cifradas, reemplaza $password por $hashedPassword

    echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = 'login.php';</script>";
    exit();
}
?>
