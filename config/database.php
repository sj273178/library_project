<?php
// Owner: Brian Okello | Commit stage: 1 of 1 (connection configuration)
declare(strict_types=1);

// Work out the URL of the project folder from the running PHP script.
// This supports both http://localhost/library-system and http://localhost/sampleProject.
$scriptParts = explode('/', trim(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''), '/'));
$applicationFolders = ['auth', 'authors', 'books', 'categories', 'dashboard', 'loans', 'members'];
$baseUrl = '';
if (isset($scriptParts[1]) && in_array($scriptParts[1], $applicationFolders, true)) {
    $baseUrl = '/' . rawurlencode($scriptParts[0]);
}
define('BASE_URL', $baseUrl);
$host = '127.0.0.1';
$port = '3306';
$db = 'library_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    exit('Database connection failed. Please contact the administrator.');
}