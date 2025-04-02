<?php
require 'config.php';

$auth_url = "https://github.com/login/oauth/authorize?client_id=" . GITHUB_CLIENT_ID . "&redirect_uri=" . GITHUB_REDIRECT_URI;
header("Location: $auth_url");
exit();
?>
