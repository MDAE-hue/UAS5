<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/jwt.php';

class AuthController {

    public function login() {
        // Pastikan header JSON
        header('Content-Type: application/json');

        // Ambil input JSON dari request body
        $data = json_decode(file_get_contents('php://input'), true);
        $nik = $data['nik'] ?? null;

        if (!$nik) {
            echo json_encode([
                "status" => false,
                "message" => "NIK harus diisi"
            ]);
            exit; // hentikan eksekusi agar tidak ada output tambahan
        }

        global $conn;

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE nik = ?");
            $stmt->execute([$nik]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo json_encode([
                    "status" => false,
                    "message" => "NIK tidak ditemukan"
                ]);
                exit;
            }

            // Payload JWT
            $payload = [
                "iss" => "php-jwt",          // issuer
                "sub" => $user['id'],        // subject
                "nik" => $user['nik'],
                "role_id" => $user['role_id'],
                "iat" => time(),
                "exp" => time() + (60*60*24) // 1 hari
            ];

            $token = JWT::encode($payload, "SECRET_KEY", 'HS256');

            echo json_encode([
                "status" => true,
                "message" => "Login berhasil",
                "data" => [
                    "token" => $token,
                    "user" => [
                        "id" => $user['id'],
                        "nik" => $user['nik'],
                        "name" => $user['name'],
                        "role_id" => $user['role_id'],
                        "created_at" => $user['created_at'],
                        "updated_at" => $user['updated_at']
                    ]
                ]
            ]);
            exit;

        } catch (PDOException $e) {
            echo json_encode([
                "status" => false,
                "message" => "Error server: " . $e->getMessage()
            ]);
            exit;
        }
    }
}
