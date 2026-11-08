<?php

declare(strict_types=1);

// Initialize or resume the session
session_start();

// Unset all session variables
$_SESSION = [];

// If cookies are used, clear the session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        (bool) $params['secure'],
        (bool) $params['httponly']
    );
}

// Destroy the session storage on the server
session_destroy();

// Redirect to the login page and terminate script execution
header('Location: ../auth/login.php');
exit;