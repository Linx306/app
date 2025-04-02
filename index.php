<?php
session_start();
require_once 'config.php';

$authUrl = "https://github.com/login/oauth/authorize?client_id=" . GITHUB_CLIENT_ID . "&redirect_uri=" . urlencode(GITHUB_REDIRECT_URI);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación con GitHub OAuth</title>
</head>
<body>
    <h1>Bienvenido a la aplicación con autenticación OAuth</h1>

    <?php if (!isset($_SESSION['user'])): ?>
        <p><a href="<?= htmlspecialchars($authUrl, ENT_QUOTES, 'UTF-8') ?>">Iniciar sesión con GitHub</a></p>
    <?php else: ?>
        <p>¡Hola, <?= htmlspecialchars($_SESSION['user']['login'], ENT_QUOTES, 'UTF-8') ?>!</p>
        <p><a href="logout.php">Cerrar sesión</a></p>
        <img src="<?= htmlspecialchars($_SESSION['user']['avatar_url'], ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" width="50">
    <?php endif; ?>

</body>
</html>
