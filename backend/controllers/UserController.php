<?php
require_once __DIR__ . '/../config/database.php';

class UserController {

    public function index() {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => true,
            "data" => $users
        ]);
        exit;
    }

    public function store() {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents('php://input'), true);

        global $conn;

        $stmt = $conn->prepare("INSERT INTO users (nik, name, role_id) VALUES (?, ?, ?)");
        $stmt->execute([
            $data["nik"],
            $data["name"],
            $data["role_id"]
        ]);

        echo json_encode(["status" => true, "message" => "User berhasil ditambahkan"]);
        exit;
    }

    public function update($id) {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);

        global $conn;

        $stmt = $conn->prepare("UPDATE users SET nik=?, name=?, role_id=? WHERE id=?");
        $stmt->execute([
            $data["nik"],
            $data["name"],
            $data["role_id"],
            $id
        ]);

        echo json_encode(["status" => true, "message" => "User berhasil diupdate"]);
        exit;
    }

    public function destroy($id) {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$id]);

        echo json_encode(["status" => true, "message" => "User dihapus"]);
        exit;
    }
}
