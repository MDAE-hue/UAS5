<?php
// public/index.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// method dan uri relatif ke project (menghandle subfolder)
$method = $_SERVER['REQUEST_METHOD'];

$scriptName = $_SERVER['SCRIPT_NAME']; // e.g. /backend/public/index.php
$requestUri = $_SERVER['REQUEST_URI'];  // e.g. /backend/login?x=1

// hitung base path (folder tempat index.php berada)
$basePath = str_replace('\\', '/', dirname($scriptName)); // /backend/public
// hapus query string
$uri = parse_url($requestUri, PHP_URL_PATH);

// buat uri relatif ke base path
if ($basePath !== '/' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}
if ($uri === '') $uri = '/';

// normalisasi: hilangkan trailing slash kecuali root
if ($uri !== '/' && str_ends_with($uri, '/')) {
    $uri = rtrim($uri, '/');
}

// debugging quick-check (hapus atau comment bila sudah ok)
// file_put_contents(__DIR__ . '/../logs/debug.txt', "REQ: $method $uri\n", FILE_APPEND);

// include routes
require_once __DIR__ . '/../routes/auth.php';
require_once __DIR__ . '/../routes/surat.php';

// default not found (jika route tidak di-handle)
http_response_code(404);
echo json_encode(["status" => false, "message" => "Endpoint tidak ditemukan: $method $uri"]);
