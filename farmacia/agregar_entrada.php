<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "farmacia", 3307);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $producto_id = $_POST['producto_id'];
    $proveedor_id = $_POST['proveedor_id'];
    $usuario_id = 1; // Aquí deberías obtener el ID del usuario logueado.
    $cantidad = $_POST['cantidad'];
    $lote_id = $_POST['lote_id'] ? $_POST['lote_id'] : NULL; // Si no hay lote, se pone NULL

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Registrar la entrada en la tabla de entradas
        $stmt = $conexion->prepare("INSERT INTO entradas (producto_id, proveedor_id, usuario_id, lote_id, cantidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiii", $producto_id, $proveedor_id, $usuario_id, $lote_id, $cantidad);
        $stmt->execute();

        // Actualizar el stock en la tabla de productos
        $stmt = $conexion->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $producto_id);
        $stmt->execute();

        // Si se seleccionó un lote, actualizar la cantidad en la tabla lotes
        if ($lote_id) {
            $stmt = $conexion->prepare("UPDATE lotes SET cantidad = cantidad + ? WHERE id = ?");
            $stmt->bind_param("ii", $cantidad, $lote_id);
            $stmt->execute();
        }

        // Confirmar la transacción
        $conexion->commit();
        echo "";
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conexion->rollback();
        echo "Error al registrar la entrada: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding-top: 150px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: #333;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            width: 100%;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            background-color: #007bff;
            color: white;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }

        /* Barra de Navegación */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 123, 255, 0.9);
            padding: 20px 0; /* Aumenté el padding para que la barra sea más alta */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img {
            height: 60px; /* Ajusta el tamaño del logo */
            margin-left: 20px;
        }
        .navbar a {
            color: white;
            margin: 0 25px; /* Aumenté el margen para separar más los elementos */
            font-size: 22px; /* Aumenté el tamaño de la fuente */
            font-weight: bold; /* Hice el texto más grueso */
            cursor: pointer;
            text-decoration: none;
            transition: color 0.3s;
        }
        .navbar a:hover {
            color: #d4e3fc;
        }
    </style>
</head>
<body>

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" href="agregar_entrada.php">Agregar Entrada</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h2>Registrar Entrada de Producto</h2>
        <form action="agregar_entrada.php" method="POST">
            <div class="form-group">
                <label for="producto">Producto:</label>
                <select name="producto_id" id="producto" class="form-select" required>
                    <?php
                    // Obtener productos activos
                    $query = "SELECT id, nombre FROM productos WHERE estado = 'activo'";
                    $result = $conexion->query($query);

                    if ($result->num_rows > 0) {
                        // Mostrar los productos
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay productos disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <select name="proveedor_id" id="proveedor" class="form-select" required>
                    <?php
                    // Obtener proveedores
                    $query = "SELECT id, nombre FROM proveedores";
                    $result = $conexion->query($query);

                    if ($result->num_rows > 0) {
                        // Mostrar los proveedores
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay proveedores disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="lote">Lote (Opcional):</label>
                <select name="lote_id" id="lote" class="form-select">
                    <option value="">Seleccionar Lote</option>
                    <?php
                    // Obtener lotes disponibles
                    $query = "SELECT id, lote FROM lotes WHERE cantidad > 0";
                    $result = $conexion->query($query);

                    if ($result->num_rows > 0) {
                        // Mostrar los lotes
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['lote'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay lotes disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-submit">Registrar Entrada</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>