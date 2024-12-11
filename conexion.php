<?php
$servername = "localhost"; // Cambia si usas otro servidor
$username = "root";        // Usuario predeterminado de XAMPP
$password = "";            // Contraseña vacía predeterminada
$dbname = "mi_vinedo";     // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

