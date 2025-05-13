<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión actual
header("Location: login.php"); // Redirige al index en lugar de login.php
exit();
?>
