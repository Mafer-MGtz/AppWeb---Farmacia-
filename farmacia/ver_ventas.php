<?php
session_start();
include("conexion.php");

// Verificar si el usuario es empleado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'empleado') {
    header("Location: login.php");
    exit();
}

// Obtener todas las ventas registradas
$sql = "SELECT s.id, p.nombre AS producto, s.cantidad, s.fecha, u.nombre AS usuario
        FROM salidas s
        INNER JOIN productos p ON s.producto_id = p.id
        INNER JOIN usuarios u ON s.usuario_id = u.id
        ORDER BY s.fecha DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Registradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Historial de Ventas</h2>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Venta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Empleado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $fila["id"]; ?></td>
                        <td><?php echo $fila["producto"]; ?></td>
                        <td><?php echo $fila["cantidad"]; ?></td>
                        <td><?php echo $fila["fecha"]; ?></td>
                        <td><?php echo $fila["usuario"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="empleado.php" class="btn btn-primary">Regresar</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
