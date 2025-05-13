<?php
$host = "localhost";
$user = "root";
$pass = "";  // SIN contraseña
$db = "farmacia";  // Asegúrate de que el nombre sea correcto

$conn = new mysqli("localhost:3307", "root", "", "farmacia");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "";
}
?>