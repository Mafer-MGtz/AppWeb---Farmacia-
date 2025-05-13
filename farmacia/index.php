<?php
session_start();

// Si no hay sesión activa, redirige al login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Farmaplus - Sistema de Gestión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="inventario.php">Inventario</a></li>
                <li class="nav-item"><a class="nav-link" href="lista_proveedores.php">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="agregar_entrada.php">Agregar Entrada</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido -->
<div class="container mt-5 pt-5 text-center">
    <h2 class="fw-bold"> Bienvenido, <?php echo $_SESSION['nombre']; ?> </h2>
    <p class="text-muted">Administra los productos y proveedores de forma eficiente</p>
    <a href="inventario.php" class="btn btn-primary">Ver Inventario</a>
    <a href="lista_proveedores.php" class="btn btn-primary"> Ver Proveedores</a>
    <a href="agregar_entrada.php" class="btn btn-primary"> Agregar Entrada </a>
</div>

<!-- Footer -->
<footer class="footer mt-auto py-3">
    <div class="container text-center">
        <p class="mb-0">© 2025 <strong>Farmaplus</strong> | Sistema de Gestión</p>
    </div>
</footer>

<!-- Estilos CSS -->
<style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        padding-top: 120px;
    }
    
    .login-container {
        flex: 1;
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

    .footer {
        background-color: #0566bb; /* Color oscuro profesional */
        color: #ffffff;
        text-align: center;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.2); /* Sombra elegante en la parte superior */
        width: 100%;
    }

    .footer p {
        font-size: 14px;
        margin-bottom: 0;
    }
</style>

</body>
</html>
