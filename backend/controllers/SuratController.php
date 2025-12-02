<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/response.php';
require_once __DIR__ . '/../core/auth.php';

class SuratController {

    public function ajukan() {
        global $pdo;

        $user = auth(); // cek token
        $input = json_decode(file_get_contents("php://input"), true);

        $jenis = $input['jenis'] ?? '';
        $keperluan = $input['keperluan'] ?? '';

        if (!$jenis || !$keperluan) {
            jsonResponse(false, "Data tidak lengkap");
        }

        $stmt = $pdo->prepare("
            INSERT INTO surat (user_id, jenis, keperluan, status)
            VALUES (:user_id, :jenis, :keperluan, 'pending')
        ");

        $stmt->execute([
            'user_id' => $user['id'],
            'jenis' => $jenis,
            'keperluan' => $keperluan
        ]);

        jsonResponse(true, "Pengajuan surat berhasil");
    }

    public function listByUser() {
        global $pdo;

        $user = auth();

        $stmt = $pdo->prepare("SELECT * FROM surat WHERE user_id = :id ORDER BY id DESC");
        $stmt->execute(['id' => $user['id']]);

        jsonResponse(true, "Data surat ditemukan", $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function updateStatus() {
    global $pdo;

    $user = auth();

    if ($user['role'] !== 'lurah') {
        jsonResponse(false, "Anda bukan Lurah");
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $id = $input['id'] ?? null;
    $status = $input['status'] ?? null;

    if (!$id || !$status) jsonResponse(false, "Data tidak lengkap");

    $stmt = $pdo->prepare("UPDATE surat SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);

    jsonResponse(true, "Status surat diperbarui");
    }


}
