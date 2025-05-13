<?php
include("conexion.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Ejecutar la consulta de eliminación
    $sql = "DELETE FROM productos WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Redireccionar al inventario después de eliminar
        header("Location: inventario.php");
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    echo "ID no válido.";
}

$conn->close();
?>


