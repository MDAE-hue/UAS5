<?php
// routes/surat.php
require_once __DIR__ . '/../controllers/SuratController.php';

$surat = new SuratController();

// Ajukan surat (POST /surat/ajukan)
if ($method === 'POST' && ($uri === '/surat/ajukan' || $uri === '/surat/ajukan/')) {
    $surat->ajukan();
    return;
}

// List surat user (GET /surat/me)
if ($method === 'GET' && ($uri === '/surat/me' || $uri === '/surat/me/')) {
    $surat->listByUser();
    return;
}

// Update status (PUT /surat/update)
if ($method === 'PUT' && ($uri === '/surat/update' || $uri === '/surat/update/')) {
    $surat->updateStatus();
    return;
}
