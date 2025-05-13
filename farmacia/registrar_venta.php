<?php
session_start();
include("conexion.php");

// Verificar si el usuario es empleado
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empleado') {
    echo "<p style='color:red;'>Redirigiendo al login porque la sesión no está activa o el rol no es empleado.</p>";
    header("refresh:3;url=login.php");
    exit();
}

// Obtener productos disponibles
$sql = "SELECT id, nombre, stock, precio FROM productos WHERE estado = 'activo'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        /* Estilo General */
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Barra de Navegación */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 123, 255, 0.9);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .navbar img {
            height: 60px;
        }
        .navbar a {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }
        .navbar a:hover {
            color: #d4e3fc;
        }

        /* Ajuste del Contenido */
        .contenedor {
            padding-top: 120px; /* Asegura que el contenido no quede tapado */
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación -->
    <div class="navbar">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
    </div>

    <!-- Contenido Principal -->
    <div class="container contenedor">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h2 class="text-center mb-4">Registrar Venta</h2>
                    <form action="procesar_venta.php" method="POST">
                        <div class="mb-3">
                            <label for="producto" class="form-label">Selecciona un producto:</label>
                            <select name="producto_id" id="producto" class="form-select select2" required>
                                <option value="">-- Selecciona un producto --</option>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>" data-stock="<?= $row['stock'] ?>" data-precio="<?= $row['precio'] ?>">
                                        <?= $row['nombre'] ?> - Stock: <?= $row['stock'] ?> - $<?= $row['precio'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control form-control-lg" min="1" required>
                            <small id="stock-info" class="text-danger"></small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Registrar Venta
                            </button>
                            <a href="empleado.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            $("#producto").on("change", function() {
                let selectedOption = this.options[this.selectedIndex];
                let stockDisponible = selectedOption.getAttribute("data-stock");
                $("#cantidad").attr("max", stockDisponible);
                $("#stock-info").text("Stock disponible: " + stockDisponible);
            });
        });
    </script>

</body>
</html>



