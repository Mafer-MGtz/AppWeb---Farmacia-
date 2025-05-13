<?php
include 'conexion.php'; // Conectar a la base de datos

$sql = "SELECT * FROM proveedores";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="styles.css"> <!-- Agrega estilos si es necesario -->
</head>
<body>
    <h2>Lista de Proveedores</h2>
    <a href="agregar_proveedor.php">Agregar Proveedor</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['contacto']; ?></td>
                <td><?php echo $row['telefono']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td>
                    <a href="editar_proveedor.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="eliminar_proveedor.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este proveedor?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
