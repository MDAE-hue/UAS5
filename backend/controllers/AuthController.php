<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/jwt.php';
require_once __DIR__ . '/../core/response.php';

class AuthController {
    public function login() {
        global $pdo;

        $input = json_decode(file_get_contents("php://input"), true);
        $nik = $input['nik'] ?? '';

        if (!$nik) jsonResponse(false, "NIK wajib diisi");

        $stmt = $pdo->prepare("SELECT * FROM users WHERE nik = :nik LIMIT 1");
        $stmt->execute(['nik' => $nik]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) jsonResponse(false, "NIK tidak ditemukan");

        $token = JWT::encode([
            "id" => $user['id'],
            "nik" => $user['nik'],
            "role" => $user['role'],
            "exp" => time() + (60 * 60 * 24) // 1 hari
        ]);

        jsonResponse(true, "Login berhasil", [
            "token" => $token,
            "user" => $user
        ]);
    }
}
