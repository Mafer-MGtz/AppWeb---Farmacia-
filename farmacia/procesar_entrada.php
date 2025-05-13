<?php
// Conexión a la base de datos
$host = "localhost:3307";  // Cambia el puerto si es diferente
$user = "root";
$pass = "";
$db = "farmacia";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.<br>";
}

// Verificar si los datos fueron enviados
if (!isset($_POST['producto_id'], $_POST['lote_id'], $_POST['cantidad'], $_POST['fecha_entrada']) ||
    empty($_POST['producto_id']) || empty($_POST['lote_id']) || empty($_POST['cantidad']) || empty($_POST['fecha_entrada'])) {
    die("⚠ Falta información en el formulario.");
}

// Obtener datos del formulario
$producto_id = $_POST['producto_id'];
$lote_id = $_POST['lote_id'];
$cantidad = $_POST['cantidad'];
$fecha_entrada = $_POST['fecha_entrada'];

// Verificar si el lote existe en la base de datos
$sql_check_lote = "SELECT id FROM lotes WHERE id = ?";
$stmt = $conn->prepare($sql_check_lote);
$stmt->bind_param("i", $lote_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("⚠ Error: El lote con ID $lote_id no existe.");
}

$stmt->close();

// Insertar entrada en la tabla 'entradas'
$sql_insert = "INSERT INTO entradas (producto_id, lote_id, cantidad, fecha_entrada) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("iiis", $producto_id, $lote_id, $cantidad, $fecha_entrada);

if ($stmt->execute()) {
    echo "✅ Entrada registrada exitosamente.";
} else {
    echo "❌ Error al registrar la entrada: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>