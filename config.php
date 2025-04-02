<?php
// Configuración para la autenticación de GitHub OAuth
define('GITHUB_CLIENT_ID', 'Ov23lierWZohk2ezfyh1');
define('GITHUB_CLIENT_SECRET', '5e0cb15fe188a5f8746cfd6ea5b56a3bcb6cb4e8');
define('GITHUB_REDIRECT_URI', 'https://10.1.213.105/callback.php');

// Configuración de la base de datos SQL (MariaDB)
define('DB_HOST', 'localhost');
define('DB_NAME', 'mi_basedatos');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
