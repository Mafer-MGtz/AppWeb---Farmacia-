<?php
session_start();
include("conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Determinar a qué página regresar según el rol del usuario
$pagina_regreso = ($_SESSION["rol"] == "admin") ? "index.php" : "empleado.php";

// Consultar los productos en la base de datos
$sql = "SELECT id, nombre, descripcion, tipo, stock, stock_minimo, precio, estado FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS personalizado -->
</head>
<body>

    <!-- Barra de Navegación -->
    <div class="navbar">
        <!-- Logo -->
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
    </div>

    <div class="container mt-5 pt-5">
        <div class="p-4 bg-white shadow rounded">
            
            <!-- Encabezado con icono -->
            <h2 class="mb-4 text-center">
                <i class="bi bi-box-seam"></i> Inventario de Productos
            </h2>

            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Stock</th>
                        <th>Stock Mínimo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                            <td><?php echo ucfirst($row['tipo']); ?></td>
                            <!-- Stock con alerta de color si es menor o igual al stock mínimo -->
                            <td class="<?php echo ($row['stock'] <= $row['stock_minimo']) ? 'table-danger' : ''; ?>">
                                <?php echo $row['stock']; ?>
                            </td>
                            <td><?php echo $row['stock_minimo']; ?></td>
                            <td>$<?php echo number_format($row['precio'], 2); ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Botón de regresar con icono -->
            <div class="text-center">
                <a href="<?php echo $pagina_regreso; ?>" class="btn btn-primary mt-3">
                    <i class="bi bi-arrow-left"></i> Regresar
                </a>
            </div>

        </div>
    </div>

<style>
    /* Fondo general */
    body {
    background-color: #f8f9fa;
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

    /* Contenedor principal */
    .container-fluid {
        max-width: 90%;
    }

    .container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    }


    /* Tabla con bordes redondeados */
    .table {
    border-radius: 10px;
    overflow: hidden;
    }

    /* Resaltar filas al pasar el mouse */
    .table-hover tbody tr:hover {
    background-color: #e9ecef;
    }

    /* Botón personalizado */
    .btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 20px;
    font-size: 18px;
    transition: background 0.3s ease;
    }

    .btn-primary:hover {
    background-color: #0056b3;
    }
</style>

</body>
</html>


<?php
$conn->close();
?>


