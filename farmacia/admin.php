<?php
session_start();
if ($_SESSION['usuario_rol'] != "admin") {
    header("Location: index.php");
    exit();
}
?>
<h2>Bienvenido, Admin</h2>
<p>Aquí puedes gestionar usuarios, productos y proveedores.</p>
<a href="logout.php">Cerrar sesión</a>
