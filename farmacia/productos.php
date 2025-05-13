<?php
include 'conexion.php';

$query = "SELECT * FROM productos";
$resultado = $conn->query($query);

while ($row = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";

    // Mostrar enlaces como botones normales
    echo "<td>";
    echo "<a href='editar_producto.php?id=" . $row['id'] . "' class='btn btn-warning'>Editar</a>";
    echo "<a href='eliminar_producto.php?id=" . $row['id'] . "' class='btn btn-danger' onclick=\"return confirm('¿Seguro que quieres eliminar este producto?');\">Eliminar</a>";
    echo "</td>";

    echo "</tr>";
}
?>




