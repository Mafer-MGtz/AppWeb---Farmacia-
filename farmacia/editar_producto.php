<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $stock = $_POST["stock"];
    $precio = $_POST["precio"];

    $sql = "UPDATE productos SET nombre='$nombre', stock='$stock', precio='$precio' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: inventario.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
