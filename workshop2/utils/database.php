<?php 

$dsn = 'mysql:host=localhost;dbname=workshops;charset=utf8mb4';
$dbUser = 'root'; 
$dbPassword = '';

if ($dsn === false || $dsn === '' || $dbUser === false || $dbPassword === false) {
    error_log('Authentication unavailable: configure DB_DSN, DB_USER, and DB_PASSWORD.');
}

$conn = new PDO($dsn, $dbUser, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);