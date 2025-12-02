<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/response.php';

function auth() {
    $headers = apache_request_headers();
    $authHeader = $headers['Authorization'] ?? '';

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        jsonResponse(false, "Token tidak ditemukan atau tidak valid");
    }

    $token = substr($authHeader, 7);
    $payload = JWT::decode($token);

    if (!$payload) {
        jsonResponse(false, "Token tidak valid / expired");
    }

    return $payload; // ini adalah data user
}
