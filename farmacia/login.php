<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["correo"]) || empty($_POST["contraseña"])) {
        $error = "⚠️ Por favor, complete todos los campos.";
    } else {
        $correo = trim($_POST["correo"]);
        $contraseña = trim($_POST["contraseña"]);

        $sql = "SELECT id, nombre, contraseña, rol FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nombre, $contraseña_hash, $rol);
            $stmt->fetch();

            if (password_verify($contraseña, $contraseña_hash)) {
                $_SESSION["id"] = $id;
                $_SESSION["nombre"] = $nombre;
                $_SESSION["rol"] = $rol;

                if ($rol == "admin") {
                    header("Location: index.php");
                } elseif ($rol == "empleado") {
                    header("Location: empleado.php");
                } else {
                    $error = "⚠️ Error: Rol desconocido.";
                }
                exit();
            } else {
                $error = "⚠️ Contraseña incorrecta.";
            }
        } else {
            $error = "⚠️ No se encontró una cuenta con ese correo.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia - Sistema de Inventario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('img/fondoazul.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #343A40;
            text-align: center;
            padding-top: 120px; 
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
            color: #d4e3fc;
        }
        /* Secciones */
        .section {
            display: none;
            padding: 100px 20px;
            min-height: 100vh;
            margin-top: 80px;
        }
        .active {
            display: block;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            margin: auto;
            backdrop-filter: blur(5px);
        }
        .btn-login {
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .container {
            padding-top: 150px; /* Asegura que el contenido no quede tapado */
        }
    </style>
</head>
<body>

<!-- Barra de Navegación -->
<div class="navbar">
    <!-- Logo -->
    <img src="img/LetrasFarmaPlus.png" alt="Logo Farmacia">
    
    <!-- Enlaces de navegación -->
    <div>
        
        <a onclick="showSection('sobreNosotros')"><i class="fas fa-info-circle"></i> Bienvenida </a>
        <a onclick="showSection('servicios')"><i class="fas fa-concierge-bell"></i> Guía Rápida </a>
        <a onclick="showSection('contacto')"><i class="fas fa-phone-alt"></i> Soporte Técnico </a>
        <a onclick="showSection('login')"><i class="fas fa-sign-in-alt"></i> Acceso</a>
    </div>
</div>

<!-- Sección de Login -->
<div id="login" class="section active">
    <div class="login-container">
        <h2><i class="fas fa-user-circle"></i> Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label"><i class="fas fa-envelope"></i> Correo:</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label"><i class="fas fa-lock"></i> Contraseña:</label>
                <input type="password" name="contraseña" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
        </form>
        <p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php"> Registrarse </a></p>
    </div>
</div>

<!-- Sección Pagina Principal -->
<div id="sobreNosotros" class="section active text-center p-5 bg-light shadow-lg rounded">
    <h1 class="text-primary fw-bold mb-4">Bienvenidos al Sistema de Gestión de <span class="text-success">FarmaPlus</span></h1>
    <!--<img src="img/bienvenida2.png" alt="bienvenida" class="img-fluid mb-4 rounded shadow">-->
    <p class="lead text-secondary">
        Este sistema ha sido diseñado para facilitar la gestión interna de nuestra farmacia. Como empleado o administrador, podrás gestionar el inventario, registrar ventas, crear reportes y mucho más.
    </p>
    <div class="alert alert-info p-3 mt-3">
        <strong>¿Por qué es importante?</strong> Mantener un control eficiente del inventario y registrar adecuadamente todas las transacciones es clave para el éxito de la farmacia. Con este sistema, aseguramos que siempre tengamos los productos necesarios en stock y podamos atender a los clientes de manera efectiva.
    </div>
    <p class="mt-3">Inicia sesión para acceder al sistema y gestionar todas las operaciones de la farmacia.</p>
    <a href="login.php" class="btn btn-success btn-lg mt-3 shadow-sm">Iniciar Sesión</a>
</div>

<!-- Sección Guía Rápida -->
<div id="servicios" class="section p-5 bg-light shadow-lg rounded">
    <h2 class="text-center text-primary fw-bold mb-4 animate__animated animate__fadeInDown">📌 Guía Rápida para el Sistema</h2>
    <p class="text-center text-secondary animate__animated animate__fadeIn">Te damos la bienvenida al sistema. A continuación, te explicamos cómo puedes comenzar a usarlo.</p>

    <div class="card p-4 mb-4 shadow-sm animate__animated animate__fadeInLeft animate__delay-1s">
        <h3 class="text-success">1️⃣ Iniciar sesión</h3>
        <p>Para comenzar a usar el sistema, simplemente inicia sesión con tu nombre de usuario y contraseña.</p>
    </div>

    <div class="card p-4 mb-4 shadow-sm animate__animated animate__fadeInRight animate__delay-2s">
        <h3 class="text-success">🚀 Funcionalidades clave</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>📦 Gestión de Inventario:</strong> Los administradores pueden añadir, modificar y eliminar productos del inventario. Los empleados pueden ver el inventario, pero no modificarlo.</li>
            <li class="list-group-item"><strong>🛒 Registrar Ventas:</strong> Los empleados registran las ventas de productos, los cuales se actualizan automáticamente en el inventario.</li>
            <li class="list-group-item"><strong>🔄 Entradas y Salidas:</strong> Los administradores pueden registrar las entradas de productos (cuando llegan de los proveedores) y las salidas (cuando se venden productos).</li>
            <li class="list-group-item"><strong>📊 Generar Reportes:</strong> Los administradores pueden generar reportes de ventas, inventario y otros informes necesarios.</li>
        </ul>
    </div>

    <div class="card p-4 shadow-sm animate__animated animate__fadeInUp animate__delay-3s">
        <h3 class="text-success">👥 Roles de usuario</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>🧑‍💼 Empleados:</strong> Acceso limitado a la gestión de ventas y movimientos de inventario.</li>
            <li class="list-group-item"><strong>🛠️ Administradores:</strong> Acceso completo a todas las funcionalidades del sistema, incluyendo gestión de productos, usuarios y reportes.</li>
        </ul>
    </div>
</div>

<!-- Agrega esta librería para efectos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">



<!-- Soporte Técnico -->
<div id="contacto" class="section p-5 bg-light shadow-lg rounded mt-5">
    <h2 class="text-center text-primary fw-bold mb-4 animate__animated animate__fadeInDown">📞 Soporte Técnico</h2>
    <p class="text-center text-secondary animate__animated animate__fadeIn">¿Tienes algún problema o pregunta sobre cómo usar el sistema? Aquí te ayudamos.</p>

    <!-- Información de contacto -->
    <div class="card p-4 mb-4 shadow-sm animate__animated animate__fadeInLeft">
        <h3 class="text-success">📧 Información de contacto</h3>
        <p>Si necesitas ayuda inmediata, puedes contactarnos de las siguientes maneras:</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>📩 Correo electrónico:</strong> <a href="mailto:soporte@farmacia.com" class="text-decoration-none">soporte@farmacia.com</a></li>
            <li class="list-group-item"><strong>📞 Teléfono:</strong> <a href="tel:+525551234567" class="text-decoration-none">+52 555-123-4567</a></li>
            <li class="list-group-item"><strong>🕒 Horario de soporte:</strong> Lunes a Viernes, de 9:00 AM a 6:00 PM</li>
        </ul>
    </div>

    <!-- Problemas comunes y soluciones -->
    <div class="card p-4 shadow-sm animate__animated animate__fadeInRight animate__delay-1s">
        <h3 class="text-success">⚠️ Problemas comunes y soluciones</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>🔑 ¿Olvidé mi contraseña?</strong> - Haz clic en <a href="recuperar.php" class="text-decoration-none text-primary">"Olvidé mi contraseña"</a> en la página de inicio de sesión para recuperarla.</li>
            <li class="list-group-item"><strong>📦 ¿No puedo acceder al inventario?</strong> - Verifica si tu cuenta tiene el rol adecuado. Solo los administradores pueden modificar el inventario.</li>
            <li class="list-group-item"><strong>🛒 ¿Problemas con el registro de ventas?</strong> - Asegúrate de que el producto esté disponible en el inventario. Si el problema persiste, contacta con soporte.</li>
        </ul>
    </div>

    <!-- Botón de contacto -->
    <div class="text-center mt-4 animate__animated animate__fadeInUp animate__delay-2s">
        <a href="mailto:soporte@farmacia.com" class="btn btn-success btn-lg shadow-sm">
            ✉️ Contactar Soporte
        </a>
    </div>
</div>

<!-- Agrega esta librería para efectos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">



<script>
    function showSection(sectionId) {
        // Oculta todas las secciones
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        // Muestra solo la sección seleccionada
        document.getElementById(sectionId).classList.add('active');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>