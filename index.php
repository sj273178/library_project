<?php
declare(strict_types=1);

session_start();


$baseUrl = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$destination = empty($_SESSION['user_id'])
    ? $baseUrl . '/auth/login.php'
    : $baseUrl . '/dashboard/index.php';

header('Location: ' . $destination);
exit;

?>