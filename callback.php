<?php
session_start();
require_once 'config.php';

// Verificar si hay un código de autorización
if (isset($_GET['code'])) {
    // Paso 1: Obtener el token de acceso de GitHub
    $code = $_GET['code'];
    $url = 'https://github.com/login/oauth/access_token';
    
    $data = [
        'client_id' => GITHUB_CLIENT_ID,
        'client_secret' => GITHUB_CLIENT_SECRET,
        'code' => $code,
        'redirect_uri' => GITHUB_REDIRECT_URI,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ]
    ];
    
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    // Extraer el token de acceso de la respuesta
    parse_str($response, $output);
    $access_token = $output['access_token'];
    
    // Paso 2: Usar el token de acceso para obtener datos del usuario
    $userUrl = 'https://api.github.com/user';
    $options = [
        'http' => [
            'header' => "Authorization: Bearer " . $access_token . "\r\n" .
                        "User-Agent: GitHub OAuth App\r\n",
            'method' => 'GET'
        ]
    ];
    
    $context  = stream_context_create($options);
    $user = json_decode(file_get_contents($userUrl, false, $context), true);

    // Guardar la información del usuario en la sesión
    $_SESSION['user'] = $user;
    
    // Mostrar los datos del usuario
    echo '<h1>Bienvenido, ' . htmlspecialchars($user['login']) . '!</h1>';
    echo '<img src="' . htmlspecialchars($user['avatar_url']) . '" alt="Avatar" width="50">';
} else {
    echo "No se recibió el código de autenticación.";
}
?>
