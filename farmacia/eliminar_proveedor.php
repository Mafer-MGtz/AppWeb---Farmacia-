<?php
include 'conexion.php'; // Asegúrate de tener tu archivo de conexión

// Verifica si se envió un ID válido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el proveedor
    $sql = "DELETE FROM proveedores WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Proveedor eliminado correctamente.";
        header("Location: lista_proveedores.php"); // Redirige a la lista de proveedores
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    echo "ID no válido.";
}
?>
