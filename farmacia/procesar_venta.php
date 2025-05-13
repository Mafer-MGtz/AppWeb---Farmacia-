<?php
session_start();
include("conexion.php");

// Verificar si el usuario es empleado
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empleado') {
    echo "<p style='color:red;'>Redirigiendo al login porque la sesión no está activa o el rol no es empleado.</p>";
    header("refresh:3;url=login.php");
    exit();
}

// Validar que se envió el formulario correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"]) && isset($_POST["cantidad"])) {
    $producto_id = intval($_POST["producto_id"]);
    $cantidad = intval($_POST["cantidad"]);
    $usuario_id = $_SESSION['id']; // Usuario que realiza la venta

    // Verificar si el producto tiene suficiente stock
    $sql = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $stmt->bind_result($stock_disponible);
    $stmt->fetch();
    $stmt->close();

    if ($stock_disponible < $cantidad) {
        echo "<p style='color:red;'>Error: No hay suficiente stock disponible.</p>";
        echo "<a href='registrar_venta.php'>Volver</a>";
        exit();
    }

    // Registrar la salida (venta)
    $sql = "INSERT INTO salidas (producto_id, usuario_id, cantidad, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $producto_id, $usuario_id, $cantidad);
    $stmt->execute();
    $stmt->close();

    // Actualizar el stock del producto
    $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $producto_id);
    $stmt->execute();
    $stmt->close();

    echo "<p style='color:green;'>Venta registrada correctamente.</p>";
    header("refresh:2;url=empleado.php");
    exit();
} else {
    echo "<p style='color:red;'>Error: Datos incompletos.</p>";
    echo "<a href='registrar_venta.php'>Volver</a>";
    exit();
}
?>
