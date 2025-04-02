<?php
session_start();

// Destruir la sesión para cerrar sesión
session_destroy();

// Redirigir al usuario a la página de inicio
header('Location: index.php');
exit;
?>
