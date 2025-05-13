<?php
include 'conexion.php';

// Obtener productos
$productos = $conn->query("SELECT id, nombre FROM productos ORDER BY nombre ASC");

// Obtener proveedores
$proveedores = $conn->query("SELECT id, nombre FROM proveedores ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="styles.css"> <!-- Usa el estilo que ya tienes -->
</head>
<body>
    <h2>Registrar Entrada de Productos</h2>
    <form action="procesar_entrada.php" method="POST">
        <label for="producto_id">Producto:</label>
        <select name="producto_id" required>
            <option value="">Seleccione un producto</option>
            <?php while ($row = $productos->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="proveedor_id">Proveedor:</label>
        <select name="proveedor_id" required>
            <option value="">Seleccione un proveedor</option>
            <?php while ($row = $proveedores->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" min="1" required>

        <button type="submit">Registrar Entrada</button>
    </form>
</body>
</html>

