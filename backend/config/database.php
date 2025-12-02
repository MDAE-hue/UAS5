<?php

$host = 'localhost';
$port = '5432';
$dbname = 'db_penyuratan';
$user = 'postgres';
$password = 'admin';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        "status" => false,
        "message" => "Database connection failed: " . $e->getMessage()
    ]));
}
