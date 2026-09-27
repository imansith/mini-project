<?php
// includes/db.php - Database Connection Setup using PDO

$host = 'localhost';
$dbname = 'unimart_db';
$username = 'root';
$password = ''; // Default XAMPP/WAMP password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Graceful fallback for local development if MySQL server is offline or database is not yet created
    $db_connection_error = $e->getMessage();
    $pdo = null;
}
?>
