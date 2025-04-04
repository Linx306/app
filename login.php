<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
    $stmt->execute(["username" => $username]);
    $user = $stmt->fetch();

    if ($user && $password ===  $user["password"]) {
        $_SESSION["user"] = $username;
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
