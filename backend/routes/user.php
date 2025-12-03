<?php
require_once __DIR__ . '/../controllers/UserController.php';

$user = new UserController();

// GET /users
if ($method === 'GET' && $uri === '/users') {
    $user->index();
    return;
}

// POST /users
if ($method === 'POST' && $uri === '/users') {
    $user->store();
    return;
}

// PUT /users/{id}
if ($method === 'PUT' && preg_match('#^/users/(\d+)$#', $uri, $m)) {
    $user->update($m[1]);
    return;
}

// DELETE /users/{id}
if ($method === 'DELETE' && preg_match('#^/users/(\d+)$#', $uri, $m)) {
    $user->destroy($m[1]);
    return;
}
