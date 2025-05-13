<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "farmacia", 3307);


// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener el historial de ventas
$sql = "SELECT s.id, s.fecha, s.cantidad, 
               p.nombre AS producto, 
               u.nombre AS empleado, 
               (s.cantidad * p.precio) AS total
        FROM salidas s
        JOIN productos p ON s.producto_id = p.id
        JOIN usuarios u ON s.usuario_id = u.id
        ORDER BY s.fecha DESC";;

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS personalizado -->
</head>
<body>

    <!-- Barra de Navegación -->
    <div class="navbar">
        <!-- Logo -->
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
    </div>

    <div class="container mt-5 pt-5">
        <div class="p-4 bg-white shadow rounded">
            
            <!-- Encabezado con icono -->
            <h2 class="mb-4 text-center">
                <i class="bi bi-journal-check"></i> Historial de Ventas
            </h2>

            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Empleado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo htmlspecialchars($fila['producto']); ?></td>
                            <td><?php echo $fila['cantidad']; ?></td>
                            <td>$<?php echo number_format($fila['total'], 2); ?></td>
                            <td><?php echo $fila['fecha']; ?></td>
                            <td><?php echo htmlspecialchars($fila['empleado']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Botón de regresar con icono -->
            <div class="text-center">
                <a href="empleado.php" class="btn btn-primary mt-3">
                    <i class="bi bi-arrow-left"></i> Regresar
                </a>
            </div>

        </div>
    </div>

    <style>
        /* Fondo general */
        body {
            background-color: #f8f9fa;
        }

        /* Barra de Navegación */
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
            height: 60px; /* Ajusta el tamaño del logo */
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
            color: #d4e3fc;
        }

        /* Contenedor principal */
        .container-fluid {
            max-width: 90%;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Tabla con bordes redondeados */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        /* Resaltar filas al pasar el mouse */
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Botón personalizado */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>

</body>
</html>

<?php
// Cerrar conexión
$conexion->close();
?>

