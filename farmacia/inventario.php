<?php
include("conexion.php");

// Obtener productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Farmacia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Inventario</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido -->
<div class="container mt-4">
    <h2 class="fw-bold"> Inventario de Productos</h2>

    <!-- Botón Agregar Producto -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">➕ Agregar Producto</button>

    <!-- Tabla -->
    <table id="tablaProductos" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nombre'] ?></td>
                <td><?= $row['stock'] ?></td>
                <td>$<?= number_format($row['precio'], 2) ?></td>
                <td>
                    <button class="btn btn-warning btn-sm btn-editar" 
                        data-id="<?= $row['id'] ?>" 
                        data-nombre="<?= $row['nombre'] ?>" 
                        data-stock="<?= $row['stock'] ?>" 
                        data-precio="<?= $row['precio'] ?>" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEditar">✏️ Editar</button>

                    <a href="eliminar_producto.php?id=<?= $row['id'] ?>" 
                        class="btn btn-danger btn-sm" 
                        onclick="return confirm('¿Seguro que quieres eliminar este producto?')">🗑 Eliminar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Agregar Producto -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="agregar_producto.php" method="POST">
                    <div class="mb-3">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Stock:</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio:</label>
                        <input type="number" name="precio" class="form-control" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="editar_producto.php" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Stock:</label>
                        <input type="number" name="stock" id="edit-stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio:</label>
                        <input type="number" name="precio" id="edit-precio" class="form-control" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#tablaProductos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/Spanish.json"
        }
    });

    $(".btn-editar").click(function () {
        $("#edit-id").val($(this).data("id"));
        $("#edit-nombre").val($(this).data("nombre"));
        $("#edit-stock").val($(this).data("stock"));
        $("#edit-precio").val($(this).data("precio"));
    });
});
</script>

<style>
    body {
    padding-top: 130px; /* Ajusta según la altura de la navbar */
}

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
            height: 100px; /* Ajusta el tamaño del logo */
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
            color: #d4e3fcr;
        }
</style>

</body>
</html>

