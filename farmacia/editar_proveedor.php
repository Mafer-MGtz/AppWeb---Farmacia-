<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM proveedores WHERE id = $id");
    $proveedor = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE proveedores SET nombre='$nombre', contacto='$contacto', telefono='$telefono', direccion='$direccion' WHERE id=$id";
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
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Proveedor</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $proveedor['id'] ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= $proveedor['nombre'] ?>" required>

            <label>Contacto:</label>
            <input type="text" name="contacto" value="<?= $proveedor['contacto'] ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?= $proveedor['telefono'] ?>" required>

            <label>Dirección:</label>
            <textarea name="direccion" required><?= $proveedor['direccion'] ?></textarea>

            <button type="submit" class="btn btn-edit">Actualizar</button>
            <a href="lista_proveedores.php" class="btn btn-delete">Cancelar</a>
        </form>
    </div>
</body>
</html>
