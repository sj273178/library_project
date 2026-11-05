<?php
declare(strict_types=1);

// Get the current script path
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Split the path into parts
$scriptParts = explode('/', trim($scriptName, '/'));

// List of application folders
$folders = [
    'auth',
    'authors',
    'books',
    'categories',
    'dashboard',
    'loans',
    'members'
];

// Set the base URL
$baseUrl = '';

if (isset($scriptParts[1]) && in_array($scriptParts[1], $folders, true)) {
    $baseUrl = '/' . $scriptParts[0];
}

define('BASE_URL', $baseUrl);


// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'library_db';


// Create a PDO database connection.
try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    exit('Database connection failed.');
}

?>
