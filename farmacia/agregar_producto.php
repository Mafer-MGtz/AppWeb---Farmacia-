<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO productos (nombre, stock, precio) VALUES ('$nombre', '$stock', '$precio')";
    if ($conn->query($sql) === TRUE) {
        header("Location: inventario.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>
        <form method="POST">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" required>

            <label>Stock:</label>
            <textarea name="descripcion" required></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" required>

            <button type="submit">Guardar</button>
            <a href="inventario.php" class="btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>




