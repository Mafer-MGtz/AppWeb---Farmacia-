<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO proveedores (nombre, contacto, telefono, direccion) VALUES ('$nombre', '$contacto', '$telefono', '$direccion')";
    if ($conn->query($sql) === TRUE) {
        header("Location: lista_proveedores.php");
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
    <title>Agregar Proveedor</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Proveedor</h1>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Correo:</label>
            <input type="text" name="contacto" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" required>

            <label>Dirección:</label>
            <textarea name="direccion" required></textarea>

            <button type="submit" class="btn btn-add">Guardar</button>
            <a href="lista_proveedores.php" class="btn btn-delete">Cancelar</a>
        </form>
    </div>
</body>
</html>
