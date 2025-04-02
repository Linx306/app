<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h2>Bienvenido</h2>

    <?php if (isset($_SESSION["user"])): ?>
        <p>Has iniciado sesión como <strong><?= htmlspecialchars($_SESSION["user"]) ?></strong></p>
        <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
        <p>Inicia sesión con una de las siguientes opciones:</p>
        <a href="login.php"><button>Iniciar sesión con usuario y contraseña</button></a>
        <a href="auth.php"><button>Iniciar sesión con GitHub</button></a>
    <?php endif; ?>
</body>
</html>
