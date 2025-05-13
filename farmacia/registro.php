<?php
include("conexion.php"); // Conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['nombre'], $_POST['correo'], $_POST['contraseña'])) {
        die("Error: Datos incompletos.");
    }

    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);
    $rol = isset($_POST['rol']) ? $_POST['rol'] : 'empleado';

    if (empty($nombre) || empty($correo) || empty($contraseña)) {
        die("Error: Todos los campos son obligatorios.");
    }

    $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssss", $nombre, $correo, $contraseña_hash, $rol);

    if ($stmt->execute()) {
        echo "Registro exitoso. Redirigiendo a login...";
        header("Refresh:2; url=login.php");
        exit();
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/fondoazul.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #343A40;
            text-align: center;
        }
        .container {
            max-width: 400px;
            margin-top: 160px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 123, 255, 0.9);
            padding: 20px 0; /* Aumenté el padding para que la barra sea más alta */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img {
            height: 100px; /* Ajusta el tamaño del logo */
            margin-left: 20px;
        }
        .navbar a {
            color: white;
            margin: 0 25px; /* Aumenté el margen para separar más los elementos */
            font-size: 22px; /* Aumenté el tamaño de la fuente */
            font-weight: bold; /* Hice el texto más grueso */
            cursor: pointer;
            text-decoration: none;
            transition: color 0.3s;
        }
        .navbar a:hover {
            color: #d4e3fcr;
        }
    </style>
</head>
<body>

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="login.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center">Registro de Usuario</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select name="rol" class="form-select">
                <option value="empleado" selected>Empleado</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
    <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</div>

<!-- Agregar Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
