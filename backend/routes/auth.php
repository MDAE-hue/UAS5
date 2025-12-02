<?php
// routes/auth.php
require_once __DIR__ . '/../controllers/AuthController.php';

$auth = new AuthController();

if ($method === 'POST' && ($uri === '/login' || $uri === '/login/')) {
    $auth->login();
    return;
}

// optional health check
if ($method === 'GET' && ($uri === '/health' || $uri === '/')) {
    echo json_encode(["status" => true, "message" => "OK"]);
    return;
}
