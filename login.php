<?php
session_start();
require 'config.php';
require 'blockchain.php'; // Agregar la conexión con blockchain

$blockchain = new BlockchainLogger(); // Se crea una instancia para registrar eventos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
    $stmt->execute(["username" => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $username;

        // Guardar registro en blockchain
        $logMessage = "Inicio de sesión: $username - " . date('Y-m-d H:i:s');
        $hash = $blockchain->logEvent($logMessage);
        
        // Opcional: Mostrar hash como referencia
        echo "Registro en blockchain: " . htmlspecialchars($hash);
        
        header("Location: index.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Iniciar sesión</button>
</form>
