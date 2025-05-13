<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empleado') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 100px; /* Ajuste para la navbar */
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: #007bff;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar img {
            height: 80px;
            margin-left: 20px;
        }

        .navbar a {
            color: white;
            margin-right: 20px;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .navbar a:hover {
            color: #d4e3fc;
        }

        .container h2 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-weight: 600;
        }

        .btn {
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</nav>

<!-- Contenido -->
<div class="container mt-5">
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?> </h2>
    <p class="text-muted text-center">Aquí puedes gestionar tus actividades como empleado.</p>

    <!-- Opciones para empleados -->
    <div class="row mt-4 justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Ver Inventario</h5>
                    <p class="card-text">Consulta los productos disponibles.</p>
                    <a href="ver_inventario.php" class="btn btn-primary">Ver Inventario</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Registrar Venta</h5>
                    <p class="card-text">Registra la venta de productos.</p>
                    <a href="registrar_venta.php" class="btn btn-success">Registrar Venta</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Historial de Ventas</h5>
                    <p class="card-text">Consulta las ventas realizadas.</p>
                    <a href="historial_ventas.php" class="btn btn-warning">Ver Historial</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
