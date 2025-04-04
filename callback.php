<?php
session_start();
require 'config.php';
require 'blockchain.php'; // Agregar la conexión con blockchain

$blockchain = new BlockchainLogger(); // Se crea una instancia para registrar eventos

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Intercambio del código por un token de acceso
    $token_url = "https://github.com/login/oauth/access_token";
    $data = [
        "client_id" => GITHUB_CLIENT_ID,
        "client_secret" => GITHUB_CLIENT_SECRET,
        "code" => $code
    ];
    
    $options = [
        "http" => [
            "header" => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
            "method" => "POST",
            "content" => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($token_url, false, $context);
    $token_data = json_decode($response, true);
    
    if (isset($token_data["access_token"])) {
        $access_token = $token_data["access_token"];

        // Obtener información del usuario desde GitHub
        $user_url = "https://api.github.com/user";
        $options = [
            "http" => [
                "header" => "Authorization: token $access_token\r\nUser-Agent: PHP"
            ]
        ];
        $context = stream_context_create($options);
        $user_info = file_get_contents($user_url, false, $context);
        $user_data = json_decode($user_info, true);

        $_SESSION["user"] = $user_data["login"];

        // Guardar registro en blockchain
        $logMessage = "Inicio de sesión con GitHub: " . $user_data["login"] . " - " . date('Y-m-d H:i:s');
        $hash = $blockchain->logEvent($logMessage);

        // Se muestra el hash de la transacción
        echo "Registro en blockchain: " . htmlspecialchars($hash);
        
        header("Location: index.php");
        exit();
    }
}

echo "Error en la autenticación.";
?>
