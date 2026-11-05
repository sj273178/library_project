
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


// Create database connection
$conn = new mysqli(
    $host,
    $username,
    $password,
    $dbname
);

// Check connection
if ($conn->connect_error) {
    error_log($conn->connect_error);
    die('Database connection failed.');
}

// Set character encoding
$conn->set_charset('utf8mb4');

?>
